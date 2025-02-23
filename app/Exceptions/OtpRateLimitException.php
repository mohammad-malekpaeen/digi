<?php

namespace App\Exceptions;

class OtpRateLimitException extends DontReportException {

	public function __construct(string $message = "", int $code = 429) {
		parent::__construct($message, $code);
	}
}
