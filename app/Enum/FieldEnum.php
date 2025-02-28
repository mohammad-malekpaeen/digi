<?php

namespace App\Enum;

enum FieldEnum: string {

	use BaseEnum;

	case id                              = 'id';
	case categoryId                      = 'category_id';
	case userId                          = 'user_id';
	case body                            = 'body';
	case code                            = 'code';
	case email                           = 'email';
	case name                            = 'name';
	case path                            = 'path';
	case phoneNumber                     = 'phone_number';
	case slug                            = 'slug';
	case title                           = 'title';
	case label                           = 'label';
	case type                            = 'type';
	case acceptedAt                      = 'accepted_at';
	case approvedAt                      = 'approved_at';
	case createdAt                       = 'created_at';
	case deletedAt                       = 'deleted_at';
	case emailVerifiedAt                 = 'email_verified_at';
	case updatedAt                       = 'updated_at';
	case verifiedAt                      = 'verified_at';
	case data                            = 'data';
	case categories                      = 'categories';
	case mobileNumber                    = 'mobile_number';
	case date                            = 'date';
	case format                          = 'format';
	case username                        = 'username';
	case password                        = 'password';
	case postId                          = 'post_id';
	case key                             = 'key';
	case isExpired                       = 'is_expired';
	case startedAt                       = 'started_at';
	case cancelAt                        = 'cancel_at';
    case message                         = 'message';
    case user                            = 'user';
    case authorization                   = 'authorization';
    case token                           = 'token';
    case bearer                          = 'bearer';
}
