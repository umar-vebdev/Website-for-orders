<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:10'],
            'address' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Пожалуйста, укажите ваше имя.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'phone.required' => 'Пожалуйста, укажите номер телефона.',
            'phone.regex' => 'Введите корректный номер телефона (например: +7 (999) 123-45-67).',
            'address.max' => 'Адрес не должен превышать 500 символов.',
            'description.max' => 'Комментарий не должен превышать 1000 символов.',
        ];
    }
}
