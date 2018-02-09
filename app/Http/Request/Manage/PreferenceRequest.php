<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;

class PreferenceRequest extends FormRequest
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
    { // set default rules
        $rules = [];
        // cek method
        switch($this->method())
        {
            case 'POST':
            case 'PUT':
            case 'PATCH':
            {
                $rules = [
                    'pref_group' =>  'required|min:3|max:100',
                    'pref_name' =>  'required|min:3|max:100',
                    'pref_value' =>  'required|min:3|max:191',
                ];
                break;
            }
            default:break;
        }
        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required'    => ':attribute harus di isi .',
            'same'    => ':attribute and :other harus sama .',
            'min'    => 'panjang :attribute minimal :min .',
            'max'    => 'panjang :attribute maksimal :min .',
            'unique'  => ':attribute telah digunakan.',
        ];
    }

    public function response(array $errors){
        // set notification error
        flash($this->getErrorNotification())->error();
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }

    public function getErrorNotification()
    {
        // cek request method
        if($this->method() == 'POST'){
            return 'Gagal menambahkan data';
        }else if($this->method() == 'PUT' || $this->method() == 'PATCH'){
            return 'Gagal mengubah data';
        }
    }
}
