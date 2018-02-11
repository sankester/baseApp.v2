<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class MenuRequest extends FormRequest
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
                $rules = [
                    'menu_title' =>  'required|min:1|max:100',
                    'menu_desc' =>  'required|min:1|max:100',
                    'menu_url' =>  'required|min:1|max:100',
                    'menu_st' =>  'required|min:1|max:100',
                    'active_st' =>  'required|min:1|max:100',
                    'display_st' =>  'required|min:1|max:100',
                ];
                break;
            case 'PUT':
            case 'PATCH':
            {
                $rules = [
                    'menu_title' =>  'required|min:1|max:100',
                    'menu_desc' =>  'required|min:1|max:100',
                    'menu_url' =>  'required|min:1|max:100',
                    'menu_st' =>  'required|min:1|max:100',
                    'active_st' =>  'required|min:1|max:100',
                    'display_st' =>  'required|min:1|max:100',
                    'menu_target' =>  'required|min:1|max:100',
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

        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }

}
