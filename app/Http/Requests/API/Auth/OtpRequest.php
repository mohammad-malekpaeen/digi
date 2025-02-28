<?php

namespace App\Http\Requests\API\Auth;

use App\Enum\FieldEnum;
use App\Http\Requests\BaseRequest;

class OtpRequest extends BaseRequest
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
            FieldEnum::email->name => 'required|string|email|max:255|unique:users',
        ];
    }

    public function getInputEmail(){
        return $this->input(FieldEnum::email->name);
    }

}
