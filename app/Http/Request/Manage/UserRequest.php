<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
            {
                $rules = [
                    'name' =>  'required|min:3|max:100',
                    'jabatan' =>  'required|min:3|max:100',
                    'username' =>  'required|min:3|max:50|unique:users',
                    'email' =>  'required|email|unique:users',
                    'password' =>  'required',
                    'password_confirm' => 'required|same:password',
                    'images' => 'image|mimes:jpeg,png,jpg,gif,svg'
                ];
                break;
            }
            case 'PUT':
            case 'PATCH':
            {
                $rules = [
                    'name' =>  'required|min:3|max:100',
                    'jabatan' =>  'required|min:3|max:100',
                ];

                if ($this->hasFile('images')){
                    $rules['images']  = 'image|mimes:jpeg,png,jpg,gif,svg';
                }

                // cek apakah username sama dengan username yang di gunakan
                if($this->input('username') == $this->user->username){
                    // ignore update
                    $rules['username'] = 'required|min:3|max:50|unique:users,id,'.$this->user->id;
                }else{
                    // unique rule
                    $rules['username'] = 'required|min:3|max:50|unique:users';
                }
                // cek apakah password sama dengan passsword yang di gunakan
                if($this->input('email') == $this->user->email){

                    $rules['email'] = 'required|email|unique:users,email,'.$this->user->id;
                }else{
                    $rules['email'] =  'required|email|unique:users';
                }
                // cek apakah ada password yang di post
                if(!empty($this->input('password'))){
                    $rules['password_confirm'] = 'required|same:password';
                }
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
            'required'  => ':attribute harus di isi .',
            'same'      => ':attribute and :other harus sama .',
            'min'       => 'panjang :attribute minimal :min .',
            'max'       => 'panjang :attribute maksimal :min .',
            'unique'    => ':attribute telah digunakan.',
            'mimes'     => 'app tidak support :attribute'
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
