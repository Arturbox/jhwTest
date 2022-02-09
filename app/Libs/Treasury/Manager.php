<?php

namespace App\Libs\Treasury;

use App\Jobs\UpdateTreasurySdnEntities;
use App\Models\TreasurySdnEntity;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Throwable;

class Manager
{
    const ST_STRONG = 'strong';
    const ST_WEAK = 'weak';
    const SEARCH_TYPES = [self::ST_STRONG, self::ST_WEAK];

    public function isUpdating(): bool
    {
        return (bool)Cache::get(self::class);
    }

    /**
     * @throws Throwable
     */
    public function importOrUpdate()
    {
        try {
            self::updating();
            dispatch_sync(app(UpdateTreasurySdnEntities::class));
        } finally {
            self::processed();
        }
    }

    public function getNames(string $name, string $type): Collection
    {
        $options = [];
        switch ($this->type($type)) {
            case self::ST_STRONG:
                break;
            case self::ST_WEAK:
                $options['mode'] = 'boolean';
                break;
            default:
                $options['expanded'] = true;

        }

        return TreasurySdnEntity::query()
            ->whereFullText(['first_name', 'last_name'], $name, $options)
            ->get(['uid', 'first_name', 'last_name']);
    }

    private static function processed()
    {
        Cache::forget(self::class);
    }

    private static function updating()
    {
        Cache::put(self::class, 1);
    }

    private function type(string $type): ?string
    {
        $type = strtolower($type);
        if (!in_array($type, self::SEARCH_TYPES)) {
            return null;
        }

        return $type;
    }
}
