<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Component;

new class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="login-dropdown-form">
    <form wire:submit="login" class="auth-form" style="gap: 1rem;">
        <div class="form-group" style="margin-bottom: 0;">
            <label for="dropdown-username" class="form-label" style="font-size: 0.85rem; margin-bottom: 0.35rem;">Username</label>
            <input wire:model="form.username" id="dropdown-username" type="text" name="username" class="form-input" placeholder="Username" required autocomplete="username">
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <label for="dropdown-password" class="form-label" style="font-size: 0.85rem; margin-bottom: 0.35rem;">Password</label>
            <input wire:model="form.password" id="dropdown-password" type="password" name="password" class="form-input" placeholder="Password" required autocomplete="current-password">
        </div>

        <div class="form-check" style="margin: 0;">
            <label for="dropdown-remember" class="form-check-label" style="font-size: 0.85rem;">
                <input wire:model="form.remember" id="dropdown-remember" type="checkbox" name="remember">
                <span>Remember me</span>
            </label>
        </div>

        @if ($errors->has('form.username'))
            <p class="form-error" style="color: var(--color-danger); font-size: 0.8rem;">{{ $errors->first('form.username') }}</p>
        @endif

        <button type="submit" class="btn btn-primary" style="width: 100%;">Log in</button>
    </form>

    <div style="margin-top: 1rem; text-align: center; font-size: 0.85rem; color: var(--color-text-muted);">
        <span>Don't have an account?</span>
        <a href="{{ route('register') }}" wire:navigate class="auth-link">Sign up</a>
    </div>
</div>
