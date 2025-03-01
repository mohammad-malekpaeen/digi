<?php

namespace App\Http\Requests\API;

use App\Enum\FieldEnum;
use App\Http\Requests\BaseRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Validation\Rule;

class PostRequest extends BaseRequest
{


    /**
     * @var array
     */
    protected array $shouldBeSlug = [FieldEnum::slug->name];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [

            FieldEnum::categoryId->name => [
                'required',
                'integer',
                Rule::exists(Category::class, FieldEnum::id->value)->withoutTrashed()
            ],

            FieldEnum::userId->name => [
                'required',
                'integer',
                Rule::exists(User::class, FieldEnum::id->value)->withoutTrashed()
            ],

            FieldEnum::title->name => [
                'required',
                'string',
                'max:255'
            ],
            FieldEnum::slug->name => [
                'required',
                'string',
                'max:255',
                Rule::unique(Post::class, FieldEnum::slug->value)->withoutTrashed(),
            ],

            FieldEnum::body->name => [
                'required',
                'string',
                'max:4294967295'
            ],
        ];
    }

    public function getInputTitle()
    {
        return $this->input(FieldEnum::title->name);
    }

    public function getInputSlug()
    {
        return $this->input(FieldEnum::slug->name);
    }

    public function getInputCategoryId()
    {
        return $this->input(FieldEnum::categoryId->name);
    }

    public function getInputUserId()
    {
        return $this->input(FieldEnum::userId->name);
    }

    public function getInputBody()
    {
        return $this->input(FieldEnum::body->name);
    }
}
