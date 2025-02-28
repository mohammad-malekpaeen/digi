<?php

namespace App\Http\Requests\API\Auth;

use App\Enum\FieldEnum;
use App\Http\Requests\BaseRequest;

class ForgetRequest extends BaseRequest
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
        ];
    }

    public function getInputEmail(){
        return $this->input(FieldEnum::email->name);
    }

}
