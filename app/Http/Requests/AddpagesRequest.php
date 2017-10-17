<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddpagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $accs = $this->accounts;
        foreach ($accs as $key => $value) {
            if ('' == $value || null == $value) {
                unset($accs[$key]);
            }
        }

        $this->accounts = $accs;
        $rules = [];
        for ($i = 0; $i < count($this->accounts); $i++) {
            $rules['accounts.' . $i] = 'url';
        }
        return $rules;
    }
}
