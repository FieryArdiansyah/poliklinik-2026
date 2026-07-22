<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class PlaintextLogin extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        /*
         * Sengaja membandingkan password plaintext.
         *
         * Ini merupakan anti-pattern dan hanya digunakan
         * untuk laboratorium keamanan lokal.
         */
        if (
            ! $user ||
            ! hash_equals(
                (string) $user->password,
                (string) $data['password'],
            )
        ) {
            $this->throwFailureValidationException();
        }

        if (
            $user instanceof FilamentUser &&
            ! $user->canAccessPanel(Filament::getCurrentPanel())
        ) {
            $this->throwFailureValidationException();
        }

        /*
         * Auth::attempt() tidak digunakan karena membutuhkan hash.
         * User langsung dimasukkan ke session.
         */
        Filament::auth()->login(
            $user,
            (bool) ($data['remember'] ?? false),
        );

        session()->regenerate();

        return app(LoginResponse::class);
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.email' => 'Email atau password tidak sesuai.',
        ]);
    }
}
