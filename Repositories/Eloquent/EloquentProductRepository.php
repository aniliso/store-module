<?php namespace Modules\Store\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Store\Entities\Helpers\Status;
use Modules\Store\Events\Product\ProductWasCreated;
use Modules\Store\Events\Product\ProductWasDeleted;
use Modules\Store\Events\Product\ProductWasUpdated;
use Modules\Store\Repositories\ProductRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{
    public function all()
    {
        return $this->model->with(['translations', 'categories'])->get();
    }

    /**
     * @param $data
     * @return static
     */
    public function create($data)
    {
        $model = $this->model->create($data);
        event(new ProductWasCreated($model, $data));
        $model->setTags(array_get($data, 'tags', []));
        return $model;
    }

    /**
     * @param $model
     * @param array $data
     * @return mixed
     */
    public function update($model, $data)
    {
        $model->updated_at = \Carbon::now();
        $model->update($data);
        event(new ProductWasUpdated($model, $data));
        $model->setTags(array_get($data, 'tags', []));
        return $model;
    }

    /**
     * @param $model
     * @return bool
     */
    public function destroy($model)
    {
        event(new ProductWasDeleted($model->id, get_class($model)));
        return parent::destroy($model);
    }

    /**
     * @param $lang
     * @param $per_page
     * @return mixed
     */
    public function allTranslatedInPaginate($lang, $per_page)
    {
        return $this->model->whereHas('translations', function (Builder $q) use ($lang, $per_page) {
            $q->where("locale", "$lang");
            $q->where("title", '!=', '');
        })->with(['translations', 'categories', 'tags'])->orderBy('ordering', 'asc')->active()->paginate($per_page);
    }

    public function findBySlug($slug)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($slug) {
                $q->where('slug', $slug);
            })->with(['translations','categories','brand','related'])->active()->first();
        }

        return $this->model->where('slug', $slug)->active()->first();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findLocalesById($id)
    {
        return $this->model->whereHas('translations', function (Builder $q) use ($id) {
            $q->where('product_id', $id);
        })->with(['translations', 'categories', 'tags'])->first();
    }

    /**
     * @param int $amount
     * @return mixed
     */
    public function latest($amount=5)
    {
        return $this->model->whereStatus(Status::PUBLISHED)->orderBy('created_at', 'desc')->take($amount)->get();
    }

    /**
     * @return mixed
     */
    public function query()
    {
        return $this->model->query();
    }
}
