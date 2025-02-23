<?php

namespace Core\Http\Responses;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

final class ErrorResponder
{
    private static $trace;

    private static $line;

    private static $file;

    private static $result;

    private static $code;

    private static $message;

    public static function handler(Throwable $exception): JsonResponse
    {
        self::$trace = $exception->getTrace();
        self::$file = $exception->getFile();
        self::$line = $exception->getLine();
        self::$message = $exception->getMessage();

        $class = get_class($exception);

        switch ($class) {
            case ValidationException::class:
                return self::fail(
                    422,
                    400,
                    'the given data was invalid',
                    $exception->errors()
                );
            case NotFoundHttpException::class:
                return self::fail(
                    404,
                    404,
                    'page not found'
                );
            case MethodNotAllowedHttpException::class:
                return self::fail(
                    405,
                    400,
                    'method not allowed'
                );
            case ModelNotFoundException::class:
                return self::fail(
                    404,
                    404,
                    'entity not found'
                );
            case QueryException::class:
                return self::fail(
                    500,
                    400,
                    Str::contains($exception->getMessage(), 'Duplicate') ? 'duplicate error' : 'query error' // Check Query Exception Error
                );
            case \TypeError::class:
                return self::fail(
                    400,
                    400,
                    'type error'
                );
            default:
                return self::fail(
                    400,
                    400,
                    $exception->getMessage()
                );
        }
    }

    public static function fail(int $status, int $code = 400, ?string $message = null, array $error = []): JsonResponse
    {
        self::$code = $code;

        $locale = trans('messages.'.$message, [], 'fa');
        self::$result['errors'] = [
            'status' => $status,
            'detail' => $message,
            'detail_locale' => strpos($locale, 'messages.') === 0 ? $message : $locale,
        ];

        if ($error) {
            self::$result['errors']['fields'] = $error;
        }

        if (config('app.debug', false)) {
            self::$result['errors']['debug'] = [
                'message' => self::$message,
                'line' => self::$line,
                'file' => self::$file,
                'trace' => collect(self::$trace)->map(function ($trace) {
                    return Arr::except($trace, ['args']);
                })->all(),
            ];
        }

        return self::returner();
    }

    private static function returner(): JsonResponse
    {
        return response()->json(self::$result, self::$code);
    }
}
