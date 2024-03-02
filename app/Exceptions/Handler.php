<?php

namespace App\Exceptions;

use App\Traits\BaseTraits;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use BaseTraits;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                // dd(class_basename($e));
                if ($e instanceof NotFoundHttpException) {
                    return $this->response(404, 'Endpoint tidak ditemukan.');
                }

                if ($e instanceof MethodNotAllowedHttpException) {
                    return $this->response(405, 'Method yang digunakan salah.');
                }

                if ($e instanceof AuthenticationException) {
                    return $this->response(403, 'Anda harus login terlebih dahulu.');
                }

                if ($e instanceof AccessDeniedHttpException) {
                    return $this->response(403, 'Anda tidak memiliki izin.');
                }

                dd($e);
                return $this->response(500, 'Terjadi kesalahan yang tidak diketahui.');
            }
        });
    }
}
