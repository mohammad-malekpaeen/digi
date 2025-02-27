<?php

namespace App\Contracts\Mediator;

interface StringMediatorContract {

	/**
	 * @param string $statement
	 * @return string
	 */
	public function normalizePersianAndArabicCharacters(string $statement): string;

	/**
	 * @param string $label
	 * @param string $separator
	 * @return string
	 */
	public function slug(string $label, string $separator = '-'): string;
}
