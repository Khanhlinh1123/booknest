<?php

namespace App\Http\Requests;

use App\Models\NguoiDung;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'tenND' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(NguoiDung::class)->ignore($this->user()->maND, 'maND')
            ],
            'diaChi' => ['nullable', 'string', 'max:255'],
            'ngaySinh' => ['nullable', 'date'],
            'gioiTinh' => ['nullable', 'in:Nam,Nữ,Khác'],
            'avatar' => ['nullable', 'image', 'max:2048'], 
        ];
    }

}
