<div>
    <a wire:navigate href="{{ route('catalog') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-900">← Kembali ke katalog</a>

    <div class="mt-7 grid gap-8 lg:grid-cols-[1.3fr_.7fr]">
        <section class="surface overflow-hidden">
            <div class="relative min-h-80 bg-emerald-950 p-8 text-white sm:p-10">
                <img src="{{ asset($product->image) }}" width="1400" height="900" fetchpriority="high" alt="Ilustrasi {{ $product->name }}" class="absolute inset-0 h-full w-full object-cover opacity-55">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-950 via-emerald-950/75 to-emerald-950/30"></div>
                <div class="relative">
                    <p class="text-sm font-bold text-amber-200">{{ $product->category->name }} · {{ $product->code }}</p>
                    <h1 class="mt-5 max-w-2xl font-serif text-4xl font-semibold leading-tight sm:text-5xl">{{ $product->name }}</h1>
                    @if($product->duration)
                        <p class="mt-5 inline-flex rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-sm">Durasi pengalaman · {{ $product->duration }}</p>
                    @endif
                </div>
            </div>

            <div class="p-7 sm:p-10">
                <p class="max-w-2xl text-lg leading-8 text-slate-600">{{ $product->description }}</p>

                @if($embedUrl = $product->youtubeEmbedUrl())
                    <section class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-slate-950" x-data="{ loaded: false }" wire:ignore aria-labelledby="video-title">
                        <div class="flex items-center justify-between gap-3 border-b border-white/10 px-5 py-4 text-white sm:px-6">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-300">Video pendukung</p>
                                <h2 id="video-title" class="mt-1 font-serif text-xl font-semibold">Lihat gambaran {{ $product->name }}</h2>
                            </div>
                            <span class="hidden rounded-full bg-white/10 px-3 py-1 text-xs font-bold text-slate-200 sm:inline-flex">Sumber: YouTube</span>
                        </div>

                        <div class="relative aspect-video bg-slate-900">
                            <img src="{{ asset($product->image) }}" width="1400" height="900" loading="lazy" decoding="async" alt="Pratinjau video {{ $product->name }}" class="absolute inset-0 h-full w-full object-cover opacity-45" x-show="!loaded">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/25 to-slate-950/40" x-show="!loaded"></div>

                            <div class="absolute inset-0 grid place-items-center p-6 text-center" x-show="!loaded">
                                <div>
                                    <span class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-white text-xl text-emerald-900 shadow-lg" aria-hidden="true">▶</span>
                                    <p class="mx-auto mt-4 max-w-md text-sm leading-6 text-slate-200">Putar video referensi untuk membantu Anda mengenal produk ini sebelum memesan.</p>
                                    <button type="button" x-on:click="loaded = true" class="mt-5 inline-flex items-center justify-center rounded-xl bg-white px-5 py-3 text-sm font-bold text-emerald-900 transition hover:bg-amber-100 focus:outline-none focus:ring-4 focus:ring-white/30">Putar video</button>
                                </div>
                            </div>

                            <template x-if="loaded">
                                <iframe
                                    class="absolute inset-0 h-full w-full"
                                    src="{{ $embedUrl }}"
                                    title="Video pendukung {{ $product->name }}"
                                    loading="lazy"
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen>
                                </iframe>
                            </template>
                        </div>

                        <div class="flex flex-col gap-2 bg-slate-900 px-5 py-3 text-xs leading-5 text-slate-300 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <p>Video bersumber dari kanal publik YouTube dan ditampilkan setelah Anda memilih untuk memutarnya.</p>
                            <a href="{{ $product->youtubeWatchUrl() }}" target="_blank" rel="noopener noreferrer" class="shrink-0 font-bold text-amber-300 hover:text-amber-200">Buka di YouTube ↗</a>
                        </div>
                    </section>
                @endif

                <div class="mt-8 flex flex-wrap items-center justify-between gap-5 border-y border-slate-100 py-5">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Harga pengalaman</p>
                        <p class="mt-1 text-3xl font-bold tracking-tight text-emerald-800">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <p class="max-w-xs text-sm leading-6 text-slate-500">Pemesanan akan dikonfirmasi langsung oleh pengelola sebelum kunjungan.</p>
                </div>

                @auth
                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <label class="text-sm font-bold text-slate-700">Jumlah
                            <input wire:model="quantity" type="number" min="1" class="input-ui w-full sm:w-28">
                        </label>
                        <button wire:click="add" wire:loading.attr="disabled" class="btn-primary self-end px-6">Tambah ke keranjang</button>
                    </div>
                @else
                    <a wire:navigate class="btn-primary mt-7" href="{{ route('login') }}">Masuk untuk memesan</a>
                @endauth
            </div>
        </section>

        <aside class="surface h-fit p-6">
            <p class="eyebrow">Pilihan pelengkap</p>
            <h2 class="mt-2 font-serif text-2xl font-semibold">Wisatawan lain juga mempertimbangkan</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">Rekomendasi dari pola transaksi yang telah tervalidasi.</p>
            <div class="mt-5 space-y-3">
                @foreach($recommendations as $item)
                    <a wire:navigate href="{{ route('products.show', $item) }}" class="group flex overflow-hidden rounded-xl border border-slate-100 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <img src="{{ asset($item->image) }}" width="120" height="100" loading="lazy" decoding="async" alt="" class="h-24 w-24 object-cover transition group-hover:scale-105">
                        <span class="p-3"><span class="block font-bold text-slate-800">{{ $item->name }}</span><span class="mt-1 block text-sm font-semibold text-emerald-700">Rp {{ number_format($item->price, 0, ',', '.') }}</span></span>
                    </a>
                @endforeach
            </div>
        </aside>
    </div>
</div>
