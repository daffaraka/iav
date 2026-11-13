<?php

use App\Models\User;
use App\Support\ErrorPageCatalog;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

function makeErrorModuleUser(array $overrides = []): User
{
    return User::factory()->create(array_merge([
        'username' => 'err_' . Str::lower(Str::random(10)),
        'unit' => 'BPS',
        'departemen' => 'IT',
        'jabatan' => 'Staff',
    ], $overrides));
}

test('guest hitting unknown url receives 404 inertia error page with guest navigation', function () {
    $response = $this->get('/halaman-yang-tidak-pernah-ada');

    $response->assertNotFound()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 404)
            ->where('error.codeLabel', 'NOT FOUND')
            ->where('error.category', 'not_found')
            ->where('authContext.isAuthenticated', false)
            ->where('navigation.homeUrl', '/')
            ->where('preview.enabled', false)
        );
});

test('authenticated user hitting unknown url receives 404 inertia error page with dashboard navigation', function () {
    $user = makeErrorModuleUser(['name' => 'Budi Santoso']);

    $response = $this->actingAs($user)->get('/modul-hilang-123');

    $response->assertNotFound()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 404)
            ->where('authContext.isAuthenticated', true)
            ->where('authContext.userName', 'Budi Santoso')
            ->where('navigation.homeUrl', '/dashboard')
        );
});

test('inertia spa visit to unknown url returns 404 with x-inertia header', function () {
    $version = app(\App\Http\Middleware\HandleInertiaRequests::class)->version(request());

    $response = $this->get('/spa-not-found', [
        'X-Inertia' => 'true',
        'X-Inertia-Version' => (string) $version,
    ]);

    $response->assertNotFound()
        ->assertHeader('X-Inertia', 'true')
        ->assertJsonPath('component', 'Errors/ErrorIndex')
        ->assertJsonPath('props.error.status', 404);
});

test('forbidden route renders 403 inertia error page', function () {
    $user = makeErrorModuleUser();

    $response = $this->actingAs($user)->get('/user');

    $response->assertForbidden()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 403)
            ->where('error.codeLabel', 'FORBIDDEN')
            ->where('error.category', 'forbidden')
        );
});

test('wrong http method renders 405 inertia error page', function () {
    $response = $this->get('/logout');

    $response->assertStatus(405)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 405)
            ->where('error.codeLabel', 'METHOD NOT ALLOWED')
        );
});

test('token mismatch renders 419 page expired inertia error page', function () {
    Route::middleware('web')->get('/_test/error-419', function () {
        throw new TokenMismatchException('CSRF token mismatch.');
    });

    $response = $this->get('/_test/error-419');

    $response->assertStatus(419)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 419)
            ->where('error.codeLabel', 'PAGE EXPIRED')
            ->where('error.primaryAction', 'reload')
        );
});

test('rate limit renders 429 inertia error page and preserves retry-after header', function () {
    Route::middleware('web')->get('/_test/error-429', function () {
        throw new TooManyRequestsHttpException(45, 'Too Many Attempts.');
    });

    $response = $this->get('/_test/error-429');

    $response->assertStatus(429)
        ->assertHeader('Retry-After', '45')
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 429)
            ->where('error.retryAfter', 45)
        );
});

test('server error 500 hides internal exception message when debug mode is disabled', function () {
    config()->set('app.debug', false);

    Route::middleware('web')->get('/_test/error-500', function () {
        throw new RuntimeException('Sensitive SQL credentials leaked');
    });

    $response = $this->get('/_test/error-500');

    $response->assertStatus(500)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 500)
            ->where('error.detail', null)
        );
});

test('maintenance 503 renders cleanly even when request has no session middleware', function () {
    Route::get('/_test/error-503-no-session', function () {
        abort(503);
    });

    $response = $this->get('/_test/error-503-no-session');

    $response->assertStatus(503)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 503)
            ->where('error.category', 'maintenance')
            ->where('authContext.isAuthenticated', false)
        );
});

test('json requests to missing routes keep json 404 responses', function () {
    $response = $this->getJson('/endpoint-json-hilang');

    $response->assertNotFound()
        ->assertJsonStructure(['message']);
});

test('preview endpoint renders all supported error statuses and rejects invalid status', function () {
    foreach (ErrorPageCatalog::SUPPORTED_STATUSES as $status) {
        $this->get("/errors/preview/{$status}")
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Errors/ErrorIndex')
                ->where('error.status', $status)
                ->where('preview.enabled', true)
            );
    }

    $this->get('/errors/preview/999')
        ->assertNotFound()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 404)
        );
});

test('preview endpoint defaults to 404 and denies non-super-admin in production', function () {
    $this->get('/errors/preview')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 404)
            ->where('preview.enabled', true)
        );

    app()->detectEnvironment(fn () => 'production');
    try {
        $staff = makeErrorModuleUser();
        $this->actingAs($staff)
            ->get('/errors/preview/500')
            ->assertNotFound()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Errors/ErrorIndex')
                ->where('error.status', 404)
            );
    } finally {
        app()->detectEnvironment(fn () => 'testing');
    }
});

test('custom 403 message and 401 unauthorized render tailored metadata', function () {
    Route::middleware('web')->get('/_test/error-403-custom', function () {
        abort(403, 'Akses khusus koordinator.');
    });

    Route::middleware('web')->get('/_test/error-401', function () {
        abort(401);
    });

    $this->get('/_test/error-403-custom')
        ->assertForbidden()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 403)
            ->where('error.detail', 'Akses khusus koordinator.')
        );

    $this->get('/_test/error-401')
        ->assertUnauthorized()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Errors/ErrorIndex')
            ->where('error.status', 401)
            ->where('error.primaryAction', 'login')
        );
});
