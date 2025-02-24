<?php

namespace App\Enum;

enum FilterField: string {

	case onlyTrashed = 'oth';
	case withTrashed = 'wth';
	case in          = 'in:';
	case fullText    = 'f:';
	case null        = 'e';
	case notNull     = 'ne';
	case lowerThan   = 'lt:';
	case greaterThan = 'gt:';
	case between     = 'bt:';
	case where       = '';
}
