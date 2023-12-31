<?php

namespace App\Exceptions;

use App\Traits\HasApiResponses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use HasApiResponses;

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

        // Handle auth exception
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                throw $this->failed(
                    code: Response::HTTP_UNAUTHORIZED,
                    message: $e->getMessage()
                );
            }
        });

        // Handle validation exception
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                throw $this->failed(
                    code: Response::HTTP_UNPROCESSABLE_ENTITY,
                    message: $e->getMessage(),
                    errors: $e->validator->errors()
                );
            }
        });

        // Handle API rate-limiter exception
        $this->renderable(function (ThrottleRequestsException $e, $request) {
            if ($request->is('api/*')) {
                throw $this->failed(
                    code: Response::HTTP_TOO_MANY_REQUESTS,
                    message: $e->getMessage(),
                );
            }
        });

        // Handle model not found exception
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                throw $this->failed(
                    code: Response::HTTP_NOT_FOUND,
                    message: $e->getMessage(),
                );
            }
        });
    }
}
