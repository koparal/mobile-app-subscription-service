<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Device
 * @package App\Models
 *
 * @mixin Collection
 * @property int id
 * @property int device_id
 * @property string username
 * @property string password
 * @property string callback_url
 */

class Application extends Model
{
    /**
     * @var string
     */
    protected $table = "applications";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id',
        'username',
        'password',
        'callback_url',
    ];
}
