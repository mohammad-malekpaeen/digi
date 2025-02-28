<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserRegisteredException extends DontReportException {

	public function __construct(?Throwable $previous = null) {
        $message = trans('exception.user-registered');
        parent::__construct($message, Response::HTTP_BAD_REQUEST, $previous);
	}
}
