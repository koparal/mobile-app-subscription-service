<?php

namespace App\Http\Requests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CheckSubscription
 * @package App\Http\Requests
 *
 * @mixin Collection
 * @property string client_token
 */

class CheckSubscription extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "client_token"=>"required"
        ];
    }
}
