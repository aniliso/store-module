<?php

namespace Modules\Store\Http\Requests\Category;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateCategoryRequest extends BaseFormRequest
{
    protected $translationsAttributesKey = 'store::categories.form';
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ordering' => 'required|integer|max:9999'
        ];
    }

    public function translationRules()
    {
        return [
            'title' => 'required|min:3',
            'slug'  => 'required|min:3',
            'description' => 'required'
        ];
    }

    public function attributes()
    {
        return trans('store::categories.form');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
