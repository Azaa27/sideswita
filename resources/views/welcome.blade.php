<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Jalatrang Wisata</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:600,700&display=swap"
        rel="stylesheet" />@vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>
    <header class="absolute inset-x-0 top-0 z-20">
        <div class="page-shell flex items-center justify-between py-5 text-white"><a href="{{route('home')}}"
                class="flex items-center gap-3"><span
                    class="grid h-10 w-10 place-items-center rounded-xl bg-amber-300 font-serif text-lg font-bold text-emerald-950">J</span><span
                    class="font-serif text-xl font-bold">Jalatrang Wisata</span></a>
            <nav class="flex items-center gap-4 text-sm font-semibold">@auth <a
                    href="{{route('catalog')}}">Jelajah</a><a
                    href="{{route('cart')}}">Keranjang</a>@if(auth()->user()->hasRole('admin'))<a
                    href="{{route('admin.dashboard')}}">Admin</a>@endif @else <a href="{{route('login')}}">Masuk</a><a
                    class="rounded-xl bg-white px-4 py-2 text-emerald-950" href="{{route('register')}}">Buat
                    akun</a>@endauth</nav>
        </div>
    </header>
    <main>
        <section class="relative min-h-[760px] overflow-hidden bg-emerald-950 pb-20 pt-36 text-white sm:pt-44"><img
                src="{{asset('images/jalatrang-hero.jpg')}}" width="1400" height="900" fetchpriority="high"
                alt="Lanskap abstrak Desa Jalatrang" class="absolute inset-0 h-full w-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-950 via-emerald-950/75 to-emerald-950/25"></div>
            <div class="absolute -bottom-28 left-[45%] h-72 w-72 rounded-full border border-white/10 bg-emerald-400/10">
            </div>
            <div class="page-shell relative grid min-h-[560px] items-end gap-12 lg:grid-cols-[1.15fr_.85fr]">
                <div class="pb-4">
                    <p class="eyebrow !text-amber-300">Desa wisata · Ciamis, Jawa Barat</p>
                    <h1
                        class="mt-5 max-w-3xl font-serif text-5xl font-semibold leading-[1.03] tracking-tight sm:text-7xl">
                        Cerita perjalanan yang tumbuh dari tanah Jalatrang.</h1>
                    <p class="mt-6 max-w-xl text-lg leading-8 text-emerald-100">Temukan pengalaman alam, pertanian, dan
                        budaya yang dirangkai bersama warga lalu bawa pulang karya lokal yang bermakna.</p>
                        <div class="mt-9 flex flex-wrap gap-3"><a href="{{route('catalog')}}"
                            class="inline-flex rounded-xl bg-amber-300 px-5 py-3 font-bold text-emerald-950 transition hover:bg-amber-200">Jelajahi
                            pengalaman →</a><a href="#cerita"
                            class="inline-flex rounded-xl border border-white/20 px-5 py-3 font-bold text-white transition hover:bg-white/10">Kenali
                            Jalatrang</a><a href="{{route('gallery')}}"
                            class="inline-flex rounded-xl border border-white/20 px-5 py-3 font-bold text-white transition hover:bg-white/10">Galeri
                            Jalatrang</a></div>
                </div>
                <div class="rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur-sm">
                    <p class="text-sm font-semibold text-amber-200">Dibuat untuk perjalanan yang mudah</p>
                    <div class="mt-6 space-y-5">
                        <div class="flex gap-4"><span
                                class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-white/15 font-bold">01</span>
                            <div><b>Pilih sesuai minat</b>
                                <p class="mt-1 text-sm text-emerald-100">Katalog paket dan cenderamata yang ringkas.</p>
                            </div>
                        </div>
                        <div class="flex gap-4"><span
                                class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-white/15 font-bold">02</span>
                            <div><b>Susun kunjungan</b>
                                <p class="mt-1 text-sm text-emerald-100">Satukan pilihanmu dalam satu pemesanan.</p>
                            </div>
                        </div>
                        <div class="flex gap-4"><span
                                class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-white/15 font-bold">03</span>
                            <div><b>Temukan pelengkap</b>
                                <p class="mt-1 text-sm text-emerald-100">Rekomendasi cerdas berdasarkan pola transaksi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="cerita" class="page-shell py-20 sm:py-28">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div class="relative"><img src="{{asset('images/jalatrang-hero.jpg')}}" width="1400" height="900"
                        loading="lazy" decoding="async" alt="Ilustrasi wisata pertanian"
                        class="h-96 w-full rounded-3xl object-cover shadow-2xl shadow-emerald-950/15"><img
                        src="{{asset('images/jalatrang-hero2.jpeg')}}" width="700" height="450" loading="lazy"
                        decoding="async" alt="Ilustrasi batik Jalatrang"
                        class="absolute -bottom-7 -right-3 hidden h-48 w-56 rounded-2xl border-8 border-[#f6f8f5] object-cover shadow-xl sm:block">
                </div>
                <div>
                    <p class="eyebrow">Tentang tempat ini</p>
                    <h2 class="section-title mt-3">Satu desa, banyak cara untuk pulang dengan cerita.</h2>
                    <p class="mt-5 max-w-xl leading-8 text-slate-600">Jalatrang mengundangmu untuk memperlambat langkah:
                        belajar dari tanah, menyusuri lanskap, menikmati budaya, dan bertemu karya yang dibuat dengan
                        ketekunan warga.</p>
                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div>
                            <p class="font-serif text-3xl font-semibold text-emerald-800">5</p>
                            <p class="mt-1 text-sm text-slate-500">paket wisata</p>
                        </div>
                        <div>
                            <p class="font-serif text-3xl font-semibold text-emerald-800">8</p>
                            <p class="mt-1 text-sm text-slate-500">karya lokal</p>
                        </div>
                        <div>
                            <p class="font-serif text-3xl font-semibold text-emerald-800">1</p>
                            <p class="mt-1 text-sm text-slate-500">perjalanan utuh</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white py-20 sm:py-28">
            <div class="page-shell">
                <div class="max-w-2xl">
                    <p class="eyebrow">Pilihan pengalaman</p>
                    <h2 class="section-title mt-3">Ada ruang untuk setiap jenis perjalanan.</h2>
                </div>
                <div class="mt-10 grid gap-5 md:grid-cols-3"><a href="{{route('catalog',['category'=>'paket-wisata'])}}"
                        class="group relative min-h-80 overflow-hidden rounded-3xl bg-emerald-900 p-6 text-white"><img
                            src="{{asset('images/alam dan petualangan.jpg')}}" width="700" height="450" loading="lazy"
                            decoding="async" alt="Ilustrasi trekking"
                            class="absolute inset-0 h-full w-full object-cover opacity-55 transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-950/25"></div>
                        <div class="relative flex h-full flex-col justify-end">
                            <p class="text-sm font-bold text-amber-200">Di luar ruang</p>
                            <h3 class="mt-2 font-serif text-3xl font-semibold">Alam dan petualangan</h3>
                            <p class="mt-3 text-sm text-emerald-50">Susuri jalur, sawah, dan lanskap desa.</p>
                        </div>
                    </a><a href="{{route('catalog',['category'=>'paket-wisata'])}}"
                        class="group relative min-h-80 overflow-hidden rounded-3xl bg-emerald-900 p-6 text-white"><img
                            src="{{asset('images/budaya dan tradisi.jpeg')}}" width="700" height="450" loading="lazy"
                            decoding="async" alt="Ilustrasi budaya Sunda"
                            class="absolute inset-0 h-full w-full object-cover opacity-55 transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-950/25"></div>
                        <div class="relative flex h-full flex-col justify-end">
                            <p class="text-sm font-bold text-amber-200">Di dalam cerita</p>
                            <h3 class="mt-2 font-serif text-3xl font-semibold">Budaya dan tradisi</h3>
                            <p class="mt-3 text-sm text-emerald-50">Rasakan sisi Sunda yang lebih dekat.</p>
                        </div>
                    </a><a href="{{route('catalog',['category'=>'cenderamata'])}}"
                        class="group relative min-h-80 overflow-hidden rounded-3xl bg-emerald-900 p-6 text-white"><img
                            src="{{asset('images/karya warga.jpg')}}" width="700" height="450" loading="lazy"
                            decoding="async" alt="Ilustrasi kopi Jalatrang"
                            class="absolute inset-0 h-full w-full object-cover opacity-55 transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-950/25"></div>
                        <div class="relative flex h-full flex-col justify-end">
                            <p class="text-sm font-bold text-amber-200">Untuk dibawa pulang</p>
                            <h3 class="mt-2 font-serif text-3xl font-semibold">Karya warga</h3>
                            <p class="mt-3 text-sm text-emerald-50">Cenderamata yang menyimpan rasa tempat.</p>
                        </div>
                    </a></div>
            </div>
        </section>
        <section class="page-shell py-20 sm:py-28">
            <div class="rounded-3xl bg-emerald-950 px-7 py-12 text-center text-white sm:px-12">
                <p class="eyebrow !text-amber-300">Mulai dari satu pilihan kecil</p>
                <h2 class="mx-auto mt-4 max-w-3xl font-serif text-4xl font-semibold leading-tight sm:text-5xl">Mari
                    jadikan kunjunganmu lebih dari sekadar destinasi.</h2>
                <p class="mx-auto mt-5 max-w-xl leading-7 text-emerald-100">Pilih pengalaman yang paling menarik
                    untukmu. Kami bantu menemukan pelengkap yang membuatnya lebih utuh.</p><a
                    href="{{route('catalog')}}"
                    class="mt-8 inline-flex rounded-xl bg-amber-300 px-6 py-3 font-bold text-emerald-950 hover:bg-amber-200">Lihat
                    semua katalog</a>
            </div>
        </section>
    </main>
    <footer class="border-t border-slate-200 bg-white">
        <div
            class="page-shell flex flex-col gap-5 py-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="font-serif text-lg font-semibold text-slate-900">Jalatrang Wisata</p>
                <p class="mt-1">E-Tourism BUMDes Jalatrang Mandiri, Ciamis.</p>
            </div>
            <p>© {{now()->year}} · Dibuat untuk pengalaman wisata yang bermakna.</p>
        </div>
    </footer>
</body>

</html>
