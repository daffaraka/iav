<?php

namespace App\Http\Controllers\NewMigration;

use App\Http\Controllers\Controller;
use App\Services\ErrorPageService;
use App\Support\ErrorPageCatalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class ErrorPageController extends Controller
{
    /**
     * Handle unmatched web GET/HEAD routes so session and auth context are preserved.
     */
    public function fallback(Request $request): JsonResponse
    {
        $allowedMethods = $this->findAllowedMethodsForPath($request);

        if ($allowedMethods !== []) {
            if (($request->expectsJson() || $request->is('api/*')) && ! $request->inertia()) {
                return response()->json([
                    'message' => 'Metode permintaan HTTP tidak diizinkan.',
                ], 405, ['Allow' => implode(', ', $allowedMethods)]);
            }

            throw new MethodNotAllowedHttpException($allowedMethods);
        }

        if (($request->expectsJson() || $request->is('api/*')) && ! $request->inertia()) {
            return response()->json([
                'message' => 'Halaman atau endpoint tidak ditemukan.',
            ], 404);
        }

        abort(404);
    }

    /**
     * Preview any supported HTTP error screen in local/testing or for super-admin.
     */
    public function preview(
        Request $request,
        ErrorPageService $errorPageService,
        int $status = 404
    ): Response {
        $canPreview = app()->environment(['local', 'testing'])
            || ($request->user()?->hasRole('super-admin') ?? false);

        if (! $canPreview || ! ErrorPageCatalog::isSupported($status)) {
            abort(404);
        }

        return $errorPageService->renderInertiaError(
            request: $request,
            status: $status,
            isPreview: true
        );
    }

    /**
     * Find alternate HTTP verbs if a non-fallback route matches the same URI path.
     *
     * @return array<int, string>
     */
    protected function findAllowedMethodsForPath(Request $request): array
    {
        $allowed = [];

        /** @var IlluminateRoute $route */
        foreach (Route::getRoutes()->getRoutes() as $route) {
            if ($route->isFallback) {
                continue;
            }

            if ($route->matches($request, false)) {
                foreach ($route->methods() as $method) {
                    $allowed[$method] = true;
                }
            }
        }

        return array_keys($allowed);
    }
}
