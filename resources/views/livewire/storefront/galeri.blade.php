<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Galeri Jalatrang · {{ config('app.name', 'Jalatrang Wisata') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="border-b border-slate-200 bg-white">
        <div class="page-shell flex items-center justify-between py-5">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-300 font-serif text-lg font-bold text-emerald-950">J</span>
                <span class="font-serif text-xl font-bold text-slate-900">Jalatrang Wisata</span>
            </a>
            <a href="{{ route('home') }}" class="btn-secondary">Kembali ke beranda</a>
        </div>
    </header>

    <main class="page-shell py-14 sm:py-20">
        <div class="max-w-2xl">
            <p class="eyebrow">Cerita dari Jalatrang</p>
            <h1 class="section-title mt-3">Galeri Jalatrang</h1>
            <p class="mt-5 max-w-xl leading-8 text-slate-600">Saksikan lanskap, aktivitas, dan cerita yang membuat Jalatrang layak untuk dikunjungi.</p>
        </div>

        <section class="mx-auto mt-10 flex max-w-5xl flex-row flex-wrap items-start justify-center gap-6" aria-label="Video galeri Jalatrang">
            @foreach ([
                ['file' => 'Video Jalatrang 1.mp4', 'title' => 'Pesona Jalatrang'],
                ['file' => 'Video Jalatrang 2.mp4', 'title' => 'Aktivitas di Jalatrang'],
                ['file' => 'Video Jalatrang 3.mp4', 'title' => 'Cerita dari Jalatrang'],
            ] as $video)
                <article class="surface w-full max-w-xs shrink-0 overflow-hidden">
                    <video class="aspect-video w-full bg-emerald-950 object-cover" controls preload="metadata">
                        <source src="{{ asset('images/source/' . $video['file']) }}" type="video/mp4">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>
                    <div class="p-5">
                        <h2 class="font-serif text-2xl font-semibold text-slate-950">{{ $video['title'] }}</h2>
                    </div>
                </article>
            @endforeach
        </section>
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="page-shell py-8 text-sm text-slate-500">
            <p class="font-serif text-lg font-semibold text-slate-900">Jalatrang Wisata</p>
            <p class="mt-1">E-Tourism BUMDes Jalatrang Mandiri, Ciamis.</p>
        </div>
    </footer>
</body>

</html>
