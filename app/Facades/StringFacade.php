<?php

namespace App\Facades;

use App\Contracts\Mediator\StringMediatorContract;

/**
 * @method static string convertMobileNumberToE164Format(string $mobileNumber)
 * @method static string makeUniqueId(int $length = 13)
 * @method static int makeIntegerUniqueId(int $length = 13)
 * @method static string maskMobileNumber(string $string)
 * @method static bool hasPersianArabicCharacters(string $string)
 * @method static string normalizePersianAndArabicCharacters(string $string)
 * @method static string slug(string $string, string $separator = '-')
 * @method static string|null storageUrl(string|null $path)
 * @see StringMediatorContract
 */
class StringFacade extends BaseFacade {

	protected static function getFacadeAccessor(): string {
		return StringMediatorContract::class;
	}
}
