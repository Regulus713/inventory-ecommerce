<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('inventory.index', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="auth-header">
        <h1 class="auth-title">Confirm Password</h1>
        <p class="auth-subtitle">This is a secure area. Please confirm your password.</p>
    </div>

    <form wire:submit="confirmPassword" class="auth-form">
        <div class="form-group">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="password" id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="auth-actions">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</div>
