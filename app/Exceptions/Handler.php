<?php

namespace App\Exceptions;

use App\Http\Responses\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
                    return new ApiResponse([], 404, 'Endpoint tidak ditemukan.');
                }

                if ($e instanceof MethodNotAllowedHttpException) {
                    return new ApiResponse([], 405, 'Metode yang Anda gunakan salah.');
                }

                if ($e instanceof AuthenticationException) {
                    return new ApiResponse([], 403, 'Anda harus login terlebih dahulu.');
                }

                if ($e instanceof AccessDeniedHttpException) {
                    return new ApiResponse([], 403, 'Anda tidak memiliki izin.');
                }

                if ($e instanceof ValidationException) {
                    return new ApiResponse($e->validator->getMessageBag(), 400, 'Terjadi kesalahan pada input.');
                }

                return new ApiResponse($e, 500, 'Terjadi kesalahan yang tidak diketahui.');
            }
        });
    }
}
