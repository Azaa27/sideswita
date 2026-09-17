<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $destination = auth()->user()->hasRole('admin')
            ? route('admin.dashboard', absolute: false)
            : route('dashboard', absolute: false);

        $this->redirectIntended(default: $destination, navigate: true);
    }
}; ?>

<div>
    <p class="eyebrow">Selamat datang</p>
    <h1 class="mt-2 font-serif text-3xl font-semibold text-slate-950">Masuk ke akunmu</h1>
    <p class="mt-2 text-sm leading-6 text-slate-500">Lanjutkan merencanakan pengalaman di Desa Jalatrang.</p>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="mt-7">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-5">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600" name="remember">
                <span class="ms-2 text-sm text-slate-600">Ingat saya</span>
            </label>
        </div>

        <div class="mt-6 flex items-center justify-between gap-4">
            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-emerald-700 hover:text-emerald-900" href="{{ route('password.request') }}" wire:navigate>
                    Lupa kata sandi?
                </a>
            @endif

            <x-primary-button class="ms-3">
                Masuk
            </x-primary-button>
        </div>
    </form>
</div>
