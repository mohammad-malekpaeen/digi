<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ModelNotFoundException extends BaseException {

	/**
	 * @param Throwable|null $previous
	 */
	public function __construct(?Throwable $previous = null) {
		$message = trans('exception.modelNotFound');
		parent::__construct($message, Response::HTTP_NOT_FOUND, $previous);
	}
}
