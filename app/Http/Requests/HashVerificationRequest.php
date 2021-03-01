<?php

namespace App\Http\Requests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class HashVerificationRequest
 * @package App\Http\Requests
 *
 * @mixin Collection
 * @property string platform
 * @property string hash
 */

class HashVerificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "platform" => "required",
            "hash" => "required"
        ];
    }
}
