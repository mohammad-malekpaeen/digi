<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserInvalidCredentialException extends DontReportException {

	public function __construct(?Throwable $previous = null) {
        $message = trans('exception.user-invalidCredential');
        parent::__construct($message, Response::HTTP_BAD_REQUEST, $previous);
	}
}
