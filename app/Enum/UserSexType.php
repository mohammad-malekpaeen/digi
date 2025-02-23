<?php

namespace App\Enum;

enum UserSexType: int {

	use BaseEnum;

	case male   = 1;
	case female = 2;
}
