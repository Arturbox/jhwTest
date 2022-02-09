<?php

namespace App\Jobs;

use App\Libs\Facades\Treasury;
use App\Models\TreasurySdnEntity;

class UpdateTreasurySdnEntities extends Job
{

    public function handle()
    {
        foreach (collect(Treasury::getOfacSdn())->chunk(1000) as $entities) {
            TreasurySdnEntity::query()->upsert($entities->toArray(), 'uid', ['first_name', 'last_name']);
        }
    }
}
