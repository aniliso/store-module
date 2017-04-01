<?php namespace Modules\Store\Http\Requests\Product;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateProductRequest extends BaseFormRequest
{
    protected $translationsAttributesKey = 'store::products.form';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categories' => "required|array|min:1",
            'brand_id'   => 'required|integer',
            'ordering'   => 'required|integer|max:9999'
        ];
    }

    public function translationRules()
    {
        $id = $this->route()->parameter('product')->id;

        return [
            'title' => "required",
            'slug'  => "required|unique:store__product_translations,slug,$id,product_id",
            'description' => "required|min:10"
        ];
    }

    public function attributes()
    {
        return [
            'categories' => trans('store::products.form.categories')
        ];
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

    protected function getValidatorInstance()
    {
        $data = $this->all();
        $data['price'] = str_replace(',', '.', $data['price']);
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
