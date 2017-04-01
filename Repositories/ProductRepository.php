<?php

namespace Modules\Store\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ProductRepository extends BaseRepository
{
    /**
     * @param $lang
     * @param $per_page
     * @return mixed
     */
    public function allTranslatedInPaginate($lang, $per_page);

    /**
     * @param $id
     * @return mixed
     */
    public function findLocalesById($id);

    /**
     * @param int $amount
     * @return mixed
     */
    public function latest($amount=5);

    /**
     * @return mixed
     */
    public function query();
}
