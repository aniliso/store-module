<?php namespace Modules\Store\Repositories\Eloquent;

use Modules\Store\Events\Brand\BrandWasCreated;
use Modules\Store\Events\Brand\BrandWasDeleted;
use Modules\Store\Events\Brand\BrandWasUpdated;
use Modules\Store\Repositories\BrandRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentBrandRepository extends EloquentBaseRepository implements BrandRepository
{
    public function update($model, $data)
    {
        $model->update($data);
        event(new BrandWasUpdated($model, $data));
        return $model;
    }

    public function create($data)
    {
        $model = $this->model->create($data);
        event(new BrandWasCreated($model, $data));
        return $model;
    }

    public function destroy($model)
    {
        event(new BrandWasDeleted($model->id, get_class($model)));
        return parent::destroy($model);
    }
}
