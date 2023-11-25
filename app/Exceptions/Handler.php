<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {

            if($exception instanceof AuthenticationException){
                $response = [
                    'code' => Response::HTTP_UNAUTHORIZED,
                    'status' => false,
                    'message' => "Unauthorized! Please contact to support",
                    'data' => [],
                    "timestamp" => time()
                ];
                return response()->json($response,Response::HTTP_UNAUTHORIZED);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                $response = [
                    'code' => Response::HTTP_METHOD_NOT_ALLOWED,
                    'status' => true,
                    'message' => "Method Not Allowed",
                    'data' => [],
                    "timestamp" => time()
                ];
                return response()->json($response,Response::HTTP_METHOD_NOT_ALLOWED);
            }

            if ($exception instanceof NotFoundHttpException) {

                $response = [
                    'code' => Response::HTTP_NOT_FOUND,
                    'status' => true,
                    'message' => "Not Found",
                    'data' => [],
                    "timestamp" => time()
                ];
                return response()->json($response,Response::HTTP_NOT_FOUND);
            }
        }

        return parent::render($request, $exception);
    }
}
