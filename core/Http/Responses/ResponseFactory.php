<?php

namespace Core\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class ResponseFactory
{
    use Macroable;

    /**
     * Return a new response from the application.
     */
    public function make(string $content = '', int $status = 200, array $headers = []): Response
    {
        return new Response($content, $status, $headers);
    }

    /**
     * Return a new JSON response from the application.
     *
     * @param  mixed  $data
     */
    public function json($data = [], int $status = 200, array $headers = [], int $options = 0): JsonResponse
    {
        return new JsonResponse($data, $status, $headers, $options);
    }

    /**
     * Create a new streamed response instance.
     */
    public function stream(\Closure $callback, int $status = 200, array $headers = []): StreamedResponse
    {
        return new StreamedResponse($callback, $status, $headers);
    }

    /**
     * Create a new file download response.
     *
     * @param  \SplFileInfo|string  $file
     */
    public function download($file, ?string $name = null, array $headers = [], ?string $disposition = 'attachment'): BinaryFileResponse
    {
        $response = new BinaryFileResponse($file, 200, $headers, true, $disposition);

        if (! is_null($name)) {
            return $response->setContentDisposition($disposition, $name, str_replace('%', '', Str::ascii($name)));
        }

        return $response;
    }
}
