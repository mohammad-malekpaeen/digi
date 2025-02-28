<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class OtpInvalidException extends DontReportException {

	public function __construct(?Throwable $previous = null) {
        $message = trans('exception.otp-invalid');
        parent::__construct($message, Response::HTTP_BAD_REQUEST, $previous);
	}
}
