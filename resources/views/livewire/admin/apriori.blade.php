<div>
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="eyebrow">Mesin rekomendasi</p>
            <h1 class="section-title mt-2">Kalkulasi Apriori</h1>
            <p class="mt-2 max-w-2xl text-slate-500">Atur ambang analisis dan tinjau aturan cross-selling yang menjadi sumber rekomendasi di katalog.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button wire:click="toggleMatrix" wire:loading.attr="disabled" class="btn-secondary">{{ $showMatrix ? 'Sembunyikan matriks 0/1' : 'Lihat matriks transaksi 0/1' }}</button>
            <button wire:click="calculate" wire:loading.attr="disabled" class="btn-primary">Jalankan kalkulasi</button>
        </div>
    </div>

    @if($showMatrix)
        <section id="matriks-transaksi" class="surface mt-7 overflow-hidden">
            <div class="flex flex-col gap-4 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="eyebrow">Prapemrosesan data</p>
                    <h2 class="mt-1 font-serif text-2xl font-semibold">Matriks transaksi biner</h2>
                    <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500">Sampel 10 transaksi berstatus selesai. Nilai <strong class="text-slate-700">1</strong> berarti produk ada minimal satu kali pada transaksi; nilai <strong class="text-slate-700">0</strong> berarti produk tidak ada. Jumlah kuantitas tidak digunakan pada tahap pembentukan basket Apriori.</p>
                </div>
                <span class="shrink-0 rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-bold text-indigo-700">Data sumber Apriori</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1080px] border-collapse text-center text-xs">
                    <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th scope="col" class="sticky left-0 z-10 min-w-32 border-b border-r border-slate-200 bg-slate-50 px-4 py-4 text-left">Transaksi</th>
                            @foreach($matrixProducts as $product)
                                <th scope="col" title="{{ $product->name }}" class="min-w-16 border-b border-r border-slate-200 px-2 py-4">{{ $product->code }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($matrixRows as $row)
                            <tr class="hover:bg-slate-50/70">
                                <th scope="row" class="sticky left-0 z-10 border-r border-slate-200 bg-white px-4 py-3 text-left font-bold text-slate-700">{{ $row['transaction_code'] }}</th>
                                @foreach($matrixProducts as $product)
                                    @php($exists = isset($row['product_ids'][$product->id]))
                                    <td class="border-r border-slate-100 px-2 py-3 font-bold {{ $exists ? 'bg-emerald-50 text-emerald-700' : 'text-slate-400' }}">{{ $exists ? 1 : 0 }}</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr><td colspan="{{ $matrixProducts->count() + 1 }}" class="px-6 py-10 text-center text-sm text-slate-500">Belum ada transaksi selesai untuk dibentuk menjadi matriks.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-100 px-6 py-4 text-xs leading-5 text-slate-500">
                <span class="font-bold text-slate-700">Legenda:</span>
                @foreach($matrixProducts as $product)
                    <span class="mr-3 inline-block"><strong class="text-slate-700">{{ $product->code }}</strong> = {{ $product->name }}</span>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mt-8 grid gap-6 lg:grid-cols-[.7fr_1.3fr]">
        <form wire:submit="save" class="surface h-fit p-6">
            <p class="eyebrow">Parameter</p>
            <h2 class="mt-2 font-serif text-2xl font-semibold">Ambang analisis</h2>
            <div class="mt-6 space-y-5">
                <label class="block text-sm font-bold text-slate-700">Minimum support
                    <input wire:model="min_support" type="number" step=".01" min=".01" max="1" class="input-ui">
                    <span class="mt-1.5 block text-xs font-normal text-slate-500">Proporsi minimum kemunculan kombinasi produk.</span>
                </label>
                <label class="block text-sm font-bold text-slate-700">Minimum confidence
                    <input wire:model="min_confidence" type="number" step=".01" min=".01" max="1" class="input-ui">
                    <span class="mt-1.5 block text-xs font-normal text-slate-500">Kekuatan minimum hubungan antar produk.</span>
                </label>
                <label class="flex items-start gap-3 rounded-xl bg-slate-50 p-3 text-sm font-semibold text-slate-700">
                    <input wire:model="schedule_enabled" type="checkbox" class="mt-0.5 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600">
                    <span>Kalkulasi otomatis harian<span class="mt-1 block text-xs font-normal text-slate-500">Aturan akan diperbarui berdasarkan transaksi selesai.</span></span>
                </label>
                <button class="btn-secondary w-full">Simpan parameter</button>
            </div>
        </form>

        <div class="surface overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                <div><p class="eyebrow">Hasil aktif</p><h2 class="mt-1 font-serif text-2xl font-semibold">Aturan rekomendasi</h2></div>
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-bold text-emerald-700">{{ count($rules) }} valid</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[620px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500"><tr><th class="px-6 py-4">Pemicu</th><th class="px-4 py-4">Rekomendasi</th><th class="px-4 py-4 text-right">Support</th><th class="px-4 py-4 text-right">Confidence</th><th class="px-6 py-4 text-right">Lift</th></tr></thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($rules as $rule)
                            <tr><td class="px-6 py-4 font-bold text-slate-800">{{ $rule->antecedent->name }}</td><td class="px-4 py-4 text-slate-700">{{ $rule->consequent->name }}</td><td class="px-4 py-4 text-right text-slate-600">{{ number_format($rule->support * 100, 1) }}%</td><td class="px-4 py-4 text-right text-slate-600">{{ number_format($rule->confidence * 100, 1) }}%</td><td class="px-6 py-4 text-right font-bold text-emerald-700">{{ number_format($rule->lift_ratio, 2) }}×</td></tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada aturan. Jalankan kalkulasi setelah transaksi selesai tersedia.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="surface mt-7 overflow-hidden">
        <div class="border-b border-slate-100 px-6 py-5"><p class="eyebrow">Audit</p><h2 class="mt-1 font-serif text-2xl font-semibold">Riwayat kalkulasi</h2></div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[650px] text-left text-sm">
                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500"><tr><th class="px-6 py-4">Waktu</th><th class="px-4 py-4">Pemicu</th><th class="px-4 py-4 text-right">Transaksi</th><th class="px-4 py-4 text-right">Aturan</th><th class="px-6 py-4 text-right">Durasi</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($logs as $log)
                        <tr><td class="px-6 py-4 font-semibold text-slate-700">{{ $log->created_at->format('d M Y, H:i') }}</td><td class="px-4 py-4 capitalize text-slate-600">{{ $log->triggered_by }}</td><td class="px-4 py-4 text-right">{{ $log->total_transactions }}</td><td class="px-4 py-4 text-right">{{ $log->total_rules_generated }}</td><td class="px-6 py-4 text-right text-slate-600">{{ $log->execution_time_ms }} ms</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
