<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PurchaseSubscription
 * @package App\Http\Requests
 *
 * @mixin Collection
 * @property string client_token
 * @property string receipt
 * @property Carbon expire_date
 */

class PurchaseSubscription extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_token' => 'required',
            'receipt' => 'required',
            'expire_date' => 'date'
        ];
    }
}
