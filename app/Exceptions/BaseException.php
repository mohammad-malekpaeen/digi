<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Throwable;

class BaseException extends Exception {

	/**
	 * @param string         $message
	 * @param int            $code
	 * @param Throwable|null $previous
	 */
	public function __construct(string $message = "", int $code = 500, ?Throwable $previous = null) {
		$code = $previous?->getCode() ?: $code;
		$message = $message ?: trans('exception.general');
		parent::__construct($message, $code, $previous);
	}

	/**
	 * @param $request
	 * @return \Illuminate\Foundation\Application|Response|Application|ResponseFactory|false|RedirectResponse
	 */
	public function render($request): \Illuminate\Foundation\Application|Response|Application|ResponseFactory|false|RedirectResponse {
		if (Config::get('app.debug')) {
			return false;
		}

		if ($request->expectsJson()) {
			return response(['message' => $this->getMessage()], $this->getCode());
		}

		return new Response(
			View::make('errors.general', [
				'title'   => Response::$statusTexts[$this->getCode()] ?? $this->getCode() ?? 500,
				'code'    => $this->getCode(),
				'message' => $this->getMessage(),
			]),
			$this->getCode()
		);
	}
}
