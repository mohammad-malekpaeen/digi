<?php

namespace App\Enum;

enum ColumnFormat: string {

	case TEXT        = 'text';
	case IMAGE       = 'image';
	case IMAGE_LIST  = 'image_list';
	case BOOLEAN     = 'boolean';
	case DATE        = 'date';
	case DATE_JALALI = 'jdate';
}
