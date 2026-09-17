<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Jalatrang Wisata') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-toast-notifications />
    <a href="#content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:shadow">Langsung ke konten</a>
    <header x-data="{ open: false }" class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur">
        <div class="page-shell flex h-18 items-center justify-between gap-4 py-3">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3" wire:navigate>
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-emerald-800 text-lg font-serif font-bold text-amber-300">J</span>
                <span class="font-serif text-xl font-bold tracking-tight text-slate-950">Jalatrang <em class="font-normal text-emerald-700">Wisata</em></span>
            </a>
            <nav class="hidden items-center gap-1 lg:flex" aria-label="Navigasi utama">
                <a wire:navigate href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'nav-link nav-link-active' : 'nav-link' }}">Beranda</a>
                <a wire:navigate href="{{ route('catalog') }}" class="{{ request()->routeIs('catalog','products.*') ? 'nav-link nav-link-active' : 'nav-link' }}">Jelajah wisata</a>
                @auth
                    <a wire:navigate href="{{ route('cart') }}" class="{{ request()->routeIs('cart','checkout') ? 'nav-link nav-link-active' : 'nav-link' }}">Keranjang</a>
                    <a wire:navigate href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'nav-link nav-link-active' : 'nav-link' }}">Pesanan saya</a>
                    @if(auth()->user()->hasRole('admin'))
                        <a wire:navigate href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'nav-link nav-link-active' : 'nav-link' }}">Ruang admin</a>
                    @endif
                @endauth
            </nav>
            <div class="flex items-center gap-2">
                @auth
                    <a wire:navigate href="{{ route('profile') }}" class="hidden text-right sm:block"><span class="block text-xs font-semibold text-slate-500">{{ auth()->user()->name }}</span><span class="block text-xs text-emerald-700">Akun saya</span></a>
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">@csrf <button class="btn-secondary px-3 py-2 text-xs">Keluar</button></form>
                @else
                    <a wire:navigate href="{{ route('login') }}" class="btn-secondary px-3 py-2 text-xs sm:px-4 sm:text-sm">Masuk</a>
                    <a wire:navigate href="{{ route('register') }}" class="hidden btn-primary px-3 py-2 text-xs sm:inline-flex sm:px-4 sm:text-sm">Mulai jelajah</a>
                @endauth
                <button type="button" x-on:click="open = !open" x-bind:aria-expanded="open" class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 text-xl text-slate-700 lg:hidden" aria-label="Buka navigasi"><span x-show="!open">☰</span><span x-show="open" x-cloak>×</span></button>
            </div>
        </div>
        <nav x-show="open" x-cloak x-transition class="border-t border-slate-200 bg-white px-4 py-3 shadow-sm lg:hidden" aria-label="Navigasi seluler">
            <div class="page-shell grid gap-1"><a wire:navigate x-on:click="open=false" href="{{ route('home') }}" class="nav-link">Beranda</a><a wire:navigate x-on:click="open=false" href="{{ route('catalog') }}" class="nav-link">Jelajah wisata</a>@auth<a wire:navigate x-on:click="open=false" href="{{ route('cart') }}" class="nav-link">Keranjang</a><a wire:navigate x-on:click="open=false" href="{{ route('orders.index') }}" class="nav-link">Pesanan saya</a><a wire:navigate x-on:click="open=false" href="{{ route('profile') }}" class="nav-link">Akun saya</a>@if(auth()->user()->hasRole('admin'))<a wire:navigate x-on:click="open=false" href="{{ route('admin.dashboard') }}" class="nav-link">Ruang admin</a>@endif<form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-slate-100 pt-3">@csrf <button class="w-full rounded-xl bg-rose-50 px-4 py-2.5 text-left text-sm font-bold text-rose-700">Keluar</button></form>@else<a wire:navigate x-on:click="open=false" href="{{ route('login') }}" class="nav-link">Masuk</a><a wire:navigate x-on:click="open=false" href="{{ route('register') }}" class="nav-link">Buat akun</a>@endauth</div>
        </nav>
    </header>
    @auth
        @if(auth()->user()->hasRole('admin') && request()->routeIs('admin.*'))
            <div class="border-b border-slate-200 bg-slate-950 text-slate-200"><div class="page-shell flex gap-1 overflow-x-auto py-2 text-sm"><a wire:navigate href="{{route('admin.dashboard')}}" class="rounded-lg px-3 py-2 {{request()->routeIs('admin.dashboard')?'bg-white/10 text-white':'hover:bg-white/5'}}">Ringkasan</a><a wire:navigate href="{{route('admin.products')}}" class="rounded-lg px-3 py-2 {{request()->routeIs('admin.products')?'bg-white/10 text-white':'hover:bg-white/5'}}">Produk</a><a wire:navigate href="{{route('admin.orders')}}" class="rounded-lg px-3 py-2 {{request()->routeIs('admin.orders')?'bg-white/10 text-white':'hover:bg-white/5'}}">Pesanan</a><a wire:navigate href="{{route('admin.apriori')}}" class="rounded-lg px-3 py-2 {{request()->routeIs('admin.apriori')?'bg-white/10 text-white':'hover:bg-white/5'}}">Apriori</a></div></div>
        @endif
    @endauth
    <main id="content" class="page-shell min-h-[calc(100vh-190px)] py-8 sm:py-10">
        {{ $slot }}
    </main>
    <footer class="mt-12 border-t border-slate-200 bg-white"><div class="page-shell flex flex-col gap-5 py-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between"><div><p class="font-serif text-lg font-semibold text-slate-900">Jalatrang Wisata</p><p class="mt-1">E-Tourism BUMDes Jalatrang Mandiri, Ciamis.</p></div><p>© {{ now()->year }} · Dibuat untuk pengalaman wisata yang bermakna.</p></div></footer>
</body>
</html>
