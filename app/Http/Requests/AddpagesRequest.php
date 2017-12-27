<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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

        // Remove emty strings
        foreach ($accs as $key => $value) {
            if ('' == $value || null == $value) {
                unset($accs[$key]);
            }
        }
        // override request to the genearted array (that contains no empty values)
        $this->accounts = $accs;

        //Start generating rules
        $rules = [];
        for ($i = 0; $i < count($this->accounts); $i++) {
            $rules['accounts.' . $i] = 'required|url';
        }

        if (isset($this->since)) {
            $now = Carbon::now()->toDateString();
            $rules['since'] = 'required|date|before:until';
            $rules['until'] = 'required|date|after:since|before:' . $now;
        }
        if (isset($this->email)) {
            $rules['email'] = 'email';
        }

        return $rules;
    }
}
