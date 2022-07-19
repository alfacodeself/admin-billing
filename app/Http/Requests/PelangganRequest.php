<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PelangganRequest extends FormRequest
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
            'nik' => 'required|numeric|digits:16|unique:pelanggan,nik',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_hp' => 'required|numeric|digits_between:9,15|unique:pelanggan,nomor_hp',
            'email' => 'required|unique:pelanggan,email|email',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'rt' => 'required|numeric|digits_between:1,3',
            'rw' => 'required|numeric|digits_between:1,3',
            'alamat' => 'required|min:5',
            'latitude' => 'required',
            'longitude' => 'required',
            'foto' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048'
        ];
    }
}
