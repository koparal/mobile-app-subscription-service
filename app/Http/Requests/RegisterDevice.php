<?php

namespace App\Http\Requests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PurchaseSubscription
 * @package App\Http\Requests
 *
 * @mixin Collection
 * @property string uid
 * @property integer app_id
 * @property string language
 * @property string operating_system
 * @property string username
 * @property string password
 */

class RegisterDevice extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uid' => 'required',
            'app_id' => 'integer|required',
            'language' => 'required',
            'operating_system' => 'required',
            'username' => '',
            'password' => ''
        ];
    }
}
