<?php

namespace App\Http\Controllers;

use App\Libs\Treasury\Manager;
use App\Models\TreasurySdnEntity;
use Illuminate\Http\Request;
use Throwable;

class TreasuryController extends Controller
{
    public function importOrUpdateSdnEntities(Manager $manager): array
    {
        try {
            $manager->importOrUpdate();
        } catch (Throwable $e) {
            return ['result' => false, 'info' => 'service unavailable', 'code' => $e->getCode()];
        }

        return ['result' => true, 'info' => '', 'code' => 200];
    }

    public function sdnEntitiesState(Manager $manager)
    {
        $info = $manager->isUpdating() ? 'updating' : (TreasurySdnEntity::query()->exists() ? 'ok' : 'empty');
        return [
            'result' => $info === 'ok',
            'info' => $info,
        ];
    }

    public function sdnEntitiesNames(Request $r, Manager $manager)
    {
        return $manager->getNames((string)$r->input('name'), (string)$r->input('type'));
    }
}
