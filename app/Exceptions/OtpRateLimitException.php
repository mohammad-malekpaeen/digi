<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class OtpRateLimitException extends DontReportException {

	public function __construct(?Throwable $previous = null) {
        $message = trans('exception.throttle');
        parent::__construct($message, Response::HTTP_TOO_MANY_REQUESTS, $previous);
	}
}
