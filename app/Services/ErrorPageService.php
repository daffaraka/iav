<?php

namespace App\Services;

use App\Http\Middleware\HandleInertiaRequests;
use App\Support\ErrorPageCatalog;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ErrorPageService
{
    private const EXCLUDED_STATUSES = [409, 422];

    /**
     * Register Inertia error page rendering on Laravel's exception handler.
     */
    public static function register(Exceptions $exceptions): void
    {
        $exceptions->respond(function (SymfonyResponse $response, Throwable $exception, Request $request) {
            return app(self::class)->handle($response, $exception, $request);
        });
    }

    /**
     * Intercept eligible HTTP error responses and return an Inertia error page.
     */
    public function handle(SymfonyResponse $response, Throwable $exception, Request $request): SymfonyResponse
    {
        if (! $this->shouldRenderInertiaError($request, $response, $exception)) {
            return $response;
        }

        return $this->renderInertiaError(
            request: $request,
            status: $response->getStatusCode(),
            exception: $exception,
            originalResponse: $response
        );
    }

    /**
     * Render the Inertia error page for a given status code.
     */
    public function renderInertiaError(
        Request $request,
        int $status,
        ?Throwable $exception = null,
        ?SymfonyResponse $originalResponse = null,
        bool $isPreview = false
    ): SymfonyResponse {
        try {
            $this->configureInertiaEnvironment($request);
            $props = $this->buildProps($request, $status, $exception, $originalResponse, $isPreview);

            $inertiaResponse = Inertia::render('Errors/ErrorIndex', $props)
                ->toResponse($request)
                ->setStatusCode($isPreview ? 200 : $status);

            $retryAfter = $this->resolveRetryAfter($originalResponse, $exception);
            if (! $isPreview && $retryAfter !== null) {
                $inertiaResponse->headers->set('Retry-After', (string) $retryAfter);
            }

            return $inertiaResponse;
        } catch (Throwable) {
            if ($originalResponse !== null) {
                return $originalResponse;
            }

            return response('Terjadi kesalahan pada sistem.', $status);
        }
    }

    /**
     * Determine whether an exception response should render the Inertia error view.
     */
    protected function shouldRenderInertiaError(
        Request $request,
        SymfonyResponse $response,
        Throwable $exception
    ): bool {
        $status = $response->getStatusCode();

        if ($status < 400 || $status >= 600 || in_array($status, self::EXCLUDED_STATUSES, true)) {
            return false;
        }

        if (($request->expectsJson() || $request->is('api/*')) && ! $request->inertia()) {
            return false;
        }

        // Preserve Ignition stack traces in debug mode for unexpected non-HTTP exceptions.
        if (config('app.debug') && ! ($exception instanceof HttpExceptionInterface)) {
            return false;
        }

        return true;
    }

    /**
     * Isolate shared props and align root view + asset version for error responses.
     */
    protected function configureInertiaEnvironment(Request $request): void
    {
        // Prevent lazy DB closures in HandleInertiaRequests from failing during 500/503 errors.
        Inertia::flushShared();

        try {
            $middleware = app(HandleInertiaRequests::class);
            Inertia::version(fn () => $middleware->version($request));
            Inertia::setRootView($middleware->rootView($request));
        } catch (Throwable) {
            Inertia::setRootView('app');
        }
    }

    /**
     * Build sanitized, self-contained props for the Errors/ErrorIndex page.
     *
     * @return array<string, mixed>
     */
    protected function buildProps(
        Request $request,
        int $status,
        ?Throwable $exception,
        ?SymfonyResponse $originalResponse,
        bool $isPreview
    ): array {
        $meta = ErrorPageCatalog::resolve($status);
        $authContext = $this->resolveAuthContext($request, $status);

        return [
            'error' => [
                'status' => $meta['status'],
                'codeLabel' => $meta['codeLabel'],
                'category' => $meta['category'],
                'title' => $meta['title'],
                'description' => $meta['description'],
                'detail' => $this->resolveSafeDetail($status, $exception),
                'suggestions' => $meta['suggestions'],
                'primaryAction' => $meta['primaryAction'],
                'requestedPath' => $this->formatRequestedPath($request),
                'method' => $request->method(),
                'timestamp' => now()
                    ->timezone(config('app.timezone', 'Asia/Jakarta'))
                    ->format('d M Y, H:i:s'),
                'retryAfter' => $this->resolveRetryAfter($originalResponse, $exception),
            ],
            'authContext' => $authContext,
            'navigation' => [
                'homeUrl' => $authContext['isAuthenticated'] ? '/dashboard' : '/',
                'homeLabel' => $authContext['isAuthenticated'] ? 'Kembali ke Dashboard' : 'Ke Beranda',
                'loginUrl' => '/login',
                'supportUrl' => '/helpdesk',
            ],
            'preview' => [
                'enabled' => $isPreview,
                'statuses' => $isPreview ? ErrorPageCatalog::previewOptions() : [],
            ],
        ];
    }

    /**
     * Safely resolve basic authentication info without triggering queries during server outages.
     *
     * @return array{isAuthenticated: bool, userName: ?string}
     */
    protected function resolveAuthContext(Request $request, int $status): array
    {
        if ($status >= 500 || ! $request->hasSession()) {
            return ['isAuthenticated' => false, 'userName' => null];
        }

        try {
            $user = $request->user();

            return [
                'isAuthenticated' => $user !== null,
                'userName' => $user?->name,
            ];
        } catch (Throwable) {
            return ['isAuthenticated' => false, 'userName' => null];
        }
    }

    /**
     * Return a safe, user-appropriate detail message without leaking internal errors in production.
     */
    protected function resolveSafeDetail(int $status, ?Throwable $exception): ?string
    {
        if ($exception === null) {
            return null;
        }

        if ($status >= 500 && ! config('app.debug')) {
            return null;
        }

        if (! ($exception instanceof HttpExceptionInterface) && ! config('app.debug')) {
            return null;
        }

        $message = trim($exception->getMessage());
        if ($message === '' || $this->isBoilerplateMessage($message)) {
            return null;
        }

        return $message;
    }

    /**
     * Filter noisy framework boilerplate messages when debug mode is disabled.
     */
    protected function isBoilerplateMessage(string $message): bool
    {
        if (config('app.debug')) {
            return false;
        }

        $boilerplatePrefixes = [
            'The route ',
            'No query results for model',
            'This action is unauthorized.',
            'Too Many Attempts.',
            'CSRF token mismatch.',
        ];

        foreach ($boilerplatePrefixes as $prefix) {
            if (str_starts_with($message, $prefix)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract numeric Retry-After seconds from response or HTTP exception headers.
     */
    protected function resolveRetryAfter(
        ?SymfonyResponse $originalResponse,
        ?Throwable $exception
    ): ?int {
        $headerValue = $originalResponse?->headers->get('Retry-After');

        if ($headerValue === null && $exception instanceof HttpExceptionInterface) {
            $headers = $exception->getHeaders();
            $headerValue = $headers['Retry-After'] ?? $headers['retry-after'] ?? null;
        }

        if (is_numeric($headerValue) && (int) $headerValue > 0) {
            return (int) $headerValue;
        }

        return null;
    }

    /**
     * Format the requested URI safely for display in the error card.
     */
    protected function formatRequestedPath(Request $request): string
    {
        $uri = $request->getRequestUri();

        return $uri !== '' ? $uri : '/';
    }
}
