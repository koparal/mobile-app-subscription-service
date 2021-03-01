<?php

namespace App\Models;

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
 * @property string app_id
 * @property string uid
 * @property string language
 * @property string operating_system
 * @property string client_token
 *
 * @property-read Subscription subscription
 * @property-read Application application
 */

class Device extends Model
{
    /**
     * @var string
     */
    protected $table = "device";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'app_id',
        'language',
        'operating_system',
        'client_token'
    ];

    /**
     * @return HasOne
     */
    public function application()
    {
        return $this->hasOne(Application::class, "device_id");
    }

    /**
     * @return HasOne
     */
    public function subscription()
    {
        return $this->hasOne(Subscription::class, "device_id");
    }
}
