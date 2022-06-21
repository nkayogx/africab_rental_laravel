<?php

namespace App\Repositories;

use App\Models\Region;
use App\Rental\Repositories\Contracts\RegionInterface;

class RegionRepository extends BaseRepository implements RegionInterface {

    protected $model;

    /**
     * CurrencyRepository constructor.
     * @param Currency $model
     */
    function __construct(Region $model)
    {
        $this->model = $model;
    }

}
