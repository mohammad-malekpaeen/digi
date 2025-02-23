<?php

namespace App\Enum;

enum UserTypeEnum: int {

	use BaseEnum;

	case REAL  = 0;
	case LEGAL = 1;
}
