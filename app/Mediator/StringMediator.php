<?php

namespace App\Mediator;

use App\Contracts\Mediator\StringMediatorContract;
use Illuminate\Support\Str;

class StringMediator implements StringMediatorContract
{

    /**
     * @param string $statement
     * @return string
     */
    public function normalizePersianAndArabicCharacters(string $statement): string
    {
        $numbers = ['۰', '۱', '۲', '۳', '۴', '٤', '۵', '٥', '٦', '۶', '۷', '۸', '۹'];
        $englishNumbers = [0, 1, 2, 3, 4, 4, 5, 5, 6, 6, 7, 8, 9];
        $arabicLetters = ['ك', 'دِ', 'بِ', 'زِ', 'ذِ', 'شِ', 'سِ', 'ى', 'ي', 'ة'];
        $persianLetters = ['ک', 'د', 'ب', 'ز', 'ذ', 'ش', 'س', 'ی', 'ی', 'ه'];

        $statement = str_replace($numbers, $englishNumbers, $statement);
        return str_replace($arabicLetters, $persianLetters, $statement);
    }

    /**
     * @param string $label
     * @param string $separator
     * @return string
     */
    public function slug(string $label, string $separator = '-'): string
    {
        return Str::slug($label, $separator);
    }

}
