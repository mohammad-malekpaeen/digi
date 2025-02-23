<?php

namespace App\Enum;

enum EloquentScope {

	case withTrashed;
	case onlyTrashed;
}
