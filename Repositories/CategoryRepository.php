<?php

namespace Modules\Store\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CategoryRepository extends BaseRepository
{
    /**
     * @param string $except
     * @return mixed
     */
    public function lists($except='');

    /**
     * @param $id
     * @return mixed
     */
    public function findLocalesById($id);

    public function roots();
}
