<?php

namespace App\Repositories\Config;

use App\Models\Config;
use App\Repositories\BaseRepository;
use App\Repositories\Config\ConfigRepositoryInterface;

class ConfigRepository extends BaseRepository implements ConfigRepositoryInterface
{

    /**
     * ConfigRepository constructor.
     *
     * @param Config $model
     */
    public function __construct(Config $model)
    {
        parent::__construct($model);
    }
}
