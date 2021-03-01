<?php

namespace App\Models;

use App\Events\Subscription\SubscriptionUpdated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Device
 * @package App\Models
 *
 * @mixin Collection
 * @property int id
 * @property string device_id
 * @property Carbon expire_date
 * @property integer status
 * @property integer sync_status
 * @property string log
 *
 * @property-read Device device
 */

class Subscription extends Model
{
    /**
     * @var string
     */
    protected $table = "subscriptions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id',
        'expire_date',
        'status',
        'sync_status',
        'log'
    ];


    protected $dates = [
        'expire_date',
        'created_at',
        'updated_at'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'updated' => SubscriptionUpdated::class
    ];

    /**
     * @return HasOne
     */
    public function device()
    {
        return $this->hasOne(Device::class, "id","device_id");
    }
}
