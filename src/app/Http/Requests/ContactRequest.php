<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        // 認可は別途ミドルウェアで担保する前提。ここでは true。
        return true;
    }

    public function rules(): array
    {
        return [
            'last_name'   => ['required'],
            'first_name'  => ['required'],
            'gender'      => ['required', 'in:1,2,3'], // 1:男性 2:女性 3:その他（PDF準拠）
            'email'       => ['required', 'email'],
            'tel'         => ['required'],
            'address'     => ['required'],
            'building'    => ['nullable'],
            'category_id' => ['required', 'exists:categories,id'],
            'detail'      => ['required', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'last_name.required'   => '姓を入力してください',
            'first_name.required'  => '名を入力してください',
            'gender.required'      => '性別を選択してください',
            'gender.in'            => '性別を選択してください',
            'email.required'       => 'メールアドレスを入力してください',
            'email.email'          => 'メールアドレスはメール形式で入力してください',
            'tel.required'         => '電話番号を入力してください',
            'address.required'     => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'category_id.exists'   => 'お問い合わせの種類を選択してください',
            'detail.required'      => 'お問い合わせの内容を入力してください',
            'detail.max'           => 'お問い合わせ内容は120文字以内で入力してください',
        ];
    }
}