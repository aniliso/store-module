<?php namespace Modules\Store\Presenters;

use Modules\Core\Presenters\BasePresenter;
use Modules\Store\Entities\Helpers\Status;

class BaseStorePresenter extends BasePresenter
{
    private $status;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->status = app('Modules\Store\Entities\Helpers\Status');
    }

    public function status()
    {
        return $this->status->get($this->entity->status);
    }

    public function statusLabelClass()
    {
        switch ($this->entity->status) {
            case Status::DRAFT:
                return 'bg-red';
                break;
            case Status::PUBLISHED:
                return 'bg-green';
                break;
            default:
                return 'bg-red';
                break;
        }
    }
}