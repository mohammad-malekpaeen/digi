<?php

namespace App\Http\Requests\API\Auth;

use App\Enum\FieldEnum;
use App\Http\Requests\BaseRequest;

class ResetPasswordRequest extends BaseRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            FieldEnum::email->name => 'required|string|email|max:255|exists:users,email',
            FieldEnum::password->name => 'required|string|min:3',
            FieldEnum::code->name => 'required|string|min:6',
        ];
    }

    public function getInputEmail(){
        return $this->input(FieldEnum::email->name);
    }

    public function getInputPassword(){
        return $this->input(FieldEnum::password->name);
    }

    public function getInputCode(){
        return (int) $this->input(FieldEnum::code->name);
    }
}
