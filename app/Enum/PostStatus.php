<?php

namespace App\Enum;

enum PostStatus: int {

	use BaseEnum;

	case published = 1;
	case draft     = 2;
	case archived  = 3;
}
