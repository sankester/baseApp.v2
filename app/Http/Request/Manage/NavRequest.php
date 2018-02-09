<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;

class NavRequest extends FormRequest
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
        // set default rules
        $rules = [];
        // cek method
        switch($this->method())
        {
            case 'POST':
            case 'PUT':
            case 'PATCH':
            {
                $rules = [
                    'nav_title' =>  'required|min:3|max:100',
                    'nav_url' =>  'required|min:1|max:100',
                    'nav_no' =>  'required|integer',
                    'nav_st' =>  'required',
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
            'integer'  => ':attribute harus berupa angka.',
        ];
    }

    public function response(array $errors){
        // set error notification
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
        // cek reuest method
        if($this->method() == 'POST'){
            return 'Gagal menambahkan data';
        }else if($this->method() == 'PUT' || $this->method() == 'PATCH'){
            return 'Gagal mengubah data';
        }
    }
}
