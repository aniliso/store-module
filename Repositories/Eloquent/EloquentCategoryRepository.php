<?php namespace Modules\Store\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Store\Events\Category\CategoryWasCreated;
use Modules\Store\Events\Category\CategoryWasDeleted;
use Modules\Store\Events\Category\CategoryWasUpdated;
use Modules\Store\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{
    public function all()
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with(['translations', 'products'])->orderBy('ordering', 'ASC')->get();
        }

        return $this->model->orderBy('ordering', 'ASC')->get();
    }

    public function create($data)
    {
        $model = $this->model->create($data);
        if(!empty($data['parent_id']) && is_numeric($data['parent_id']))
        {
            $parent = $this->model->find($data['parent_id']);
            $model->makeChildOf($parent);
        }

        event(new CategoryWasCreated($model, $data));

        return $model;
    }

    public function update($model, $data)
    {
        $model->update($data);

        if(!\Request::ajax()) {
            if(isset($data['parent_id'])) {
                if($parent = $this->model->find($data['parent_id'])) {
                    if(!$parent->equals($model)) {
                        if($parent->isDescendantOf($model)) {
                            $parent->moveToRightOf($model);
                            $model->makeChildOf($parent);
                        } else {
                            $model->makeChildOf($parent);
                        }
                    }
                }
            } else {
                $model->parent_id = null;
                $model->save();
            }
        }

        event(new CategoryWasUpdated($model, $data));

        return $model;
    }

    public function destroy($model)
    {
        event(new CategoryWasDeleted($model->id, get_class($model)));

        return parent::destroy($model);
    }

    public function lists($except='')
    {
        return $this->all()->sortBy('ordering')->except($except)->keyBy('id')->map(function($category){
            return $category->present()->titleWithSelf(' > ');
        })->toArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findLocalesById($id)
    {
        return $this->model->whereHas('translations', function (Builder $q) use ($id) {
            $q->where('category_id', $id);
        })->with('translations')->first();
    }

    public function roots()
    {
        return $this->model->roots();
    }

    public function findBySlug($slug)
    {
        return $this->model->whereHas('translations', function(Builder $q) use ($slug) {
           $q->where('slug', $slug);
        })->with(['products'])->first();
    }
}
