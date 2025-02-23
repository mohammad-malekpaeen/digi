<?php

namespace App\Contracts\Services;

interface OtpServiceContract {

    /**
     * @param string $email
     * @param int $code
     * @return bool
     */
	public function check(string $email,int $code): bool;

	/**
	 * @param string $email
	 * @return int
	 */
	public function create(string $email): int;

}
