<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Jalatrang Wisata')); ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:600,700&display=swap" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
    <?php if (isset($component)) { $__componentOriginal704196272d5e2debce23ffdbf1a3fb23 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal704196272d5e2debce23ffdbf1a3fb23 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast-notifications','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast-notifications'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal704196272d5e2debce23ffdbf1a3fb23)): ?>
<?php $attributes = $__attributesOriginal704196272d5e2debce23ffdbf1a3fb23; ?>
<?php unset($__attributesOriginal704196272d5e2debce23ffdbf1a3fb23); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal704196272d5e2debce23ffdbf1a3fb23)): ?>
<?php $component = $__componentOriginal704196272d5e2debce23ffdbf1a3fb23; ?>
<?php unset($__componentOriginal704196272d5e2debce23ffdbf1a3fb23); ?>
<?php endif; ?>
    <a href="#content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:shadow">Langsung ke konten</a>
    <header x-data="{ open: false }" class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur">
        <div class="page-shell flex h-18 items-center justify-between gap-4 py-3">
            <a href="<?php echo e(route('home')); ?>" class="flex min-w-0 items-center gap-3" wire:navigate>
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-emerald-800 text-lg font-serif font-bold text-amber-300">J</span>
                <span class="font-serif text-xl font-bold tracking-tight text-slate-950">Jalatrang <em class="font-normal text-emerald-700">Wisata</em></span>
            </a>
            <nav class="hidden items-center gap-1 lg:flex" aria-label="Navigasi utama">
                <a wire:navigate href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'nav-link nav-link-active' : 'nav-link'); ?>">Beranda</a>
                <a wire:navigate href="<?php echo e(route('catalog')); ?>" class="<?php echo e(request()->routeIs('catalog','products.*') ? 'nav-link nav-link-active' : 'nav-link'); ?>">Jelajah wisata</a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a wire:navigate href="<?php echo e(route('cart')); ?>" class="<?php echo e(request()->routeIs('cart','checkout') ? 'nav-link nav-link-active' : 'nav-link'); ?>">Keranjang</a>
                    <a wire:navigate href="<?php echo e(route('orders.index')); ?>" class="<?php echo e(request()->routeIs('orders.*') ? 'nav-link nav-link-active' : 'nav-link'); ?>">Pesanan saya</a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole('admin')): ?>
                        <a wire:navigate href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.*') ? 'nav-link nav-link-active' : 'nav-link'); ?>">Ruang admin</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </nav>
            <div class="flex items-center gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a wire:navigate href="<?php echo e(route('profile')); ?>" class="hidden text-right sm:block"><span class="block text-xs font-semibold text-slate-500"><?php echo e(auth()->user()->name); ?></span><span class="block text-xs text-emerald-700">Akun saya</span></a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="hidden sm:block"><?php echo csrf_field(); ?> <button class="btn-secondary px-3 py-2 text-xs">Keluar</button></form>
                <?php else: ?>
                    <a wire:navigate href="<?php echo e(route('login')); ?>" class="btn-secondary px-3 py-2 text-xs sm:px-4 sm:text-sm">Masuk</a>
                    <a wire:navigate href="<?php echo e(route('register')); ?>" class="hidden btn-primary px-3 py-2 text-xs sm:inline-flex sm:px-4 sm:text-sm">Mulai jelajah</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <button type="button" x-on:click="open = !open" x-bind:aria-expanded="open" class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 text-xl text-slate-700 lg:hidden" aria-label="Buka navigasi"><span x-show="!open">☰</span><span x-show="open" x-cloak>×</span></button>
            </div>
        </div>
        <nav x-show="open" x-cloak x-transition class="border-t border-slate-200 bg-white px-4 py-3 shadow-sm lg:hidden" aria-label="Navigasi seluler">
            <div class="page-shell grid gap-1"><a wire:navigate x-on:click="open=false" href="<?php echo e(route('home')); ?>" class="nav-link">Beranda</a><a wire:navigate x-on:click="open=false" href="<?php echo e(route('catalog')); ?>" class="nav-link">Jelajah wisata</a><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?><a wire:navigate x-on:click="open=false" href="<?php echo e(route('cart')); ?>" class="nav-link">Keranjang</a><a wire:navigate x-on:click="open=false" href="<?php echo e(route('orders.index')); ?>" class="nav-link">Pesanan saya</a><a wire:navigate x-on:click="open=false" href="<?php echo e(route('profile')); ?>" class="nav-link">Akun saya</a><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole('admin')): ?><a wire:navigate x-on:click="open=false" href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link">Ruang admin</a><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-2 border-t border-slate-100 pt-3"><?php echo csrf_field(); ?> <button class="w-full rounded-xl bg-rose-50 px-4 py-2.5 text-left text-sm font-bold text-rose-700">Keluar</button></form><?php else: ?><a wire:navigate x-on:click="open=false" href="<?php echo e(route('login')); ?>" class="nav-link">Masuk</a><a wire:navigate x-on:click="open=false" href="<?php echo e(route('register')); ?>" class="nav-link">Buat akun</a><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
        </nav>
    </header>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole('admin') && request()->routeIs('admin.*')): ?>
            <div class="border-b border-slate-200 bg-slate-950 text-slate-200"><div class="page-shell flex gap-1 overflow-x-auto py-2 text-sm"><a wire:navigate href="<?php echo e(route('admin.dashboard')); ?>" class="rounded-lg px-3 py-2 <?php echo e(request()->routeIs('admin.dashboard')?'bg-white/10 text-white':'hover:bg-white/5'); ?>">Ringkasan</a><a wire:navigate href="<?php echo e(route('admin.products')); ?>" class="rounded-lg px-3 py-2 <?php echo e(request()->routeIs('admin.products')?'bg-white/10 text-white':'hover:bg-white/5'); ?>">Produk</a><a wire:navigate href="<?php echo e(route('admin.orders')); ?>" class="rounded-lg px-3 py-2 <?php echo e(request()->routeIs('admin.orders')?'bg-white/10 text-white':'hover:bg-white/5'); ?>">Pesanan</a><a wire:navigate href="<?php echo e(route('admin.apriori')); ?>" class="rounded-lg px-3 py-2 <?php echo e(request()->routeIs('admin.apriori')?'bg-white/10 text-white':'hover:bg-white/5'); ?>">Apriori</a></div></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <main id="content" class="page-shell min-h-[calc(100vh-190px)] py-8 sm:py-10">
        <?php echo e($slot); ?>

    </main>
    <footer class="mt-12 border-t border-slate-200 bg-white"><div class="page-shell flex flex-col gap-5 py-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between"><div><p class="font-serif text-lg font-semibold text-slate-900">Jalatrang Wisata</p><p class="mt-1">E-Tourism BUMDes Jalatrang Mandiri, Ciamis.</p></div><p>© <?php echo e(now()->year); ?> · Dibuat untuk pengalaman wisata yang bermakna.</p></div></footer>
</body>
</html>
<?php /**PATH C:\laragon\www\sideswita 2\resources\views/layouts/store.blade.php ENDPATH**/ ?>