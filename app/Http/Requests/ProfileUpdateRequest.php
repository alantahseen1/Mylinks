<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Usernames that cannot be registered because they collide with app routes.
     *
     * @var array<int, string>
     */
    public const array RESERVED_USERNAMES = [
        'admin',
        'api',
        'contact',
        'dashboard',
        'help',
        'login',
        'logout',
        'password',
        'profile',
        'register',
        'settings',
        'support',
        'about',
        'terms',
        'privacy',
        'verify-email',
        'forgot-password',
        'reset-password',
        'confirm-password',
        'email',
        'locale',
        'language',
        'links',
        'go',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                'max:30',
                Rule::notIn(self::RESERVED_USERNAMES),
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'bio' => ['nullable', 'string', 'max:500'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
