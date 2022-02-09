<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property int uid
 * @property string first_name
 * @property string last_name
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class TreasurySdnEntity extends Model
{
    protected $fillable = ['uid', 'first_name', 'last_name'];

    public static function updateAll()
    {

    }
}
