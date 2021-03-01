<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Device
 * @package App\Models
 *
 * @mixin Collection
 * @property int id
 * @property int app_id
 * @property string event_status
 * @property string status
 *
 * @property-read Application application
 */

class FailedCallbackEvent extends Model
{
    /**
     * @var string
     */
    protected $table = "failed_callback_events";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_id',
        'event_status',
        'status'
    ];


    /**
     * @return HasOne
     */
    public function application()
    {
        return $this->hasOne(Application::class, "id", "app_id");
    }
}
