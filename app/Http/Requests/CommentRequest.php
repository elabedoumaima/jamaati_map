<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'author_name' => 'required|string|max:255|min:2',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|max:1000|min:5',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'author_name.required' => 'الاسم مطلوب',
            'author_name.min' => 'الاسم يجب أن يكون أكثر من حرفين',
            'author_name.max' => 'الاسم طويل جداً',
            'author_email.required' => 'البريد الإلكتروني مطلوب',
            'author_email.email' => 'البريد الإلكتروني غير صحيح',
            'author_email.max' => 'البريد الإلكتروني طويل جداً',
            'content.required' => 'التعليق مطلوب',
            'content.min' => 'التعليق قصير جداً',
            'content.max' => 'التعليق طويل جداً',
        ];
    }
}