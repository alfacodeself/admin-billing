<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MitraRequest extends FormRequest
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
        return [
            'foto' => 'required|image|mimes:png,jpg,jpeg,svg,gif,jfif|max:2048',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_hp' => 'required|numeric|digits_between:9,15|unique:mitra,nomor_hp',
            'email' => 'required|unique:mitra,email|email',
        ];
    }
}
