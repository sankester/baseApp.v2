<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class PermissionRequest extends FormRequest
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
                    'portal_id'     =>  'required|max:10',
                    'permission_type'     =>  'required',
                ];
                if ($this->has('permission_nm')){
                    $rules['permission_nm']  = 'required|min:1|max:191';
                }
                if ($this->has('permission_slug')){
                    $rules['permission_slug']  = 'required|min:1|max:191';
                }
                if ($this->has('permission_group')){
                    $rules['permission_group']  = 'required|min:1|max:191';
                }
                if ($this->has('permission_desc')){
                    $rules['permission_desc']  = 'required|min:1|max:191';
                }
                if ($this->has('resource')){
                    $rules['resource']  = 'required|min:1|max:191|alpha';
                }
                if ($this->has('crud_selected')){
                    $rules['crud_selected']  = 'required|min:1|max:191';
                }
                break;
            case 'PUT':
            case 'PATCH':
            {
                $rules = [
                    'portal_id'     =>  'required|max:10',
                    'permission_type'     =>  'required',
                ];
                if ($this->has('permission_nm')){
                    $rules['permission_nm']  = 'required|min:1|max:191';
                }
                if ($this->has('permission_slug')){
                    $rules['permission_slug']  = 'required|min:1|max:191';
                }
                if ($this->has('permission_group')){
                    $rules['permission_group']  = 'required|min:1|max:191';
                }
                if ($this->has('permission_desc')){
                    $rules['permission_desc']  = 'required|min:1|max:191';
                }
                if ($this->has('resource')){
                    $rules['resource']  = 'required|min:1|max:191|alpha';
                }
                if ($this->has('crud_selected')){
                    $rules['crud_selected']  = 'required|min:1|max:191';
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
        ];
    }

    public function response(array $errors){
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }
        $this->getErrorNotification();
        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }

    public function getErrorNotification()
    {
        // cek request method
        if($this->method() == 'POST'){
            // set notifikasi error
            $this->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal tambah menu.']);
        }else if($this->method() == 'PUT' || $this->method() == 'PATCH'){
            // set notifikasi error
            $this->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal update menu.']);
        }
    }
}
