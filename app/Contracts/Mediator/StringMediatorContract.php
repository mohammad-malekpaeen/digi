<?php

namespace App\Contracts\Mediator;

interface StringMediatorContract {

	/**
	 * @param string $mobileNumber
	 * @return string
	 */
	public function convertMobileNumberToE164Format(string $mobileNumber): string;

	/**
	 * @param $string
	 * @return bool
	 */
	public function hasPersianArabicCharacters($string): bool;

	/**
	 * @param string $statement
	 * @return string
	 */
	public function normalizePersianAndArabicCharacters(string $statement): string;

	/**
	 * @param int $length
	 * @return string
	 */
	public function makeUniqueId(int $length = 13): string;

	/**
	 * @param int $length
	 * @return int
	 */
	public function makeIntegerUniqueId(int $length = 13): int;

	/**
	 * @param $string
	 * @return string
	 */
	public function maskMobileNumber($string): string;

	/**
	 * @param string|null $url
	 * @return string|null
	 */
	public function getRelativePath(?string $url = null): ?string;

	/**
	 * @param string $datetime
	 * @param string $format
	 * @return string
	 */
	public function convertDateToJalali(string $datetime, string $format = 'Y-n-j H:i'): string;

	/**
	 * @param string $label
	 * @param string $separator
	 * @return string
	 */
	public function slug(string $label, string $separator = '-'): string;

	/**
	 * @param string|null $path
	 * @return string|null
	 */
	public function storageUrl(string|null $path): string|null;
}
