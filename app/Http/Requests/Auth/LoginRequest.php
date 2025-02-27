<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /** @throws ValidationException */
    public function authenticate(string $systemTenantID): void
    {
        $this->ensureIsNotRateLimited($systemTenantID);

        if (! Auth::attempt($this->only('email', 'password'))) {
            RateLimiter::hit($this->throttleKey($systemTenantID));

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($systemTenantID));
    }

    /** @throws ValidationException */
    public function ensureIsNotRateLimited(string $systemTenantID): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($systemTenantID), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(string $systemTenantID): string
    {
        return Str::transliterate(
            string: Str::lower(
                value: $this->string('email')->toString(),
            ).'|'.$this->$systemTenantID,
        );
    }
}
