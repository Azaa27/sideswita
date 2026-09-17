<div>
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div><p class="eyebrow">Perjalananmu</p><h1 class="section-title mt-2">Pesanan saya</h1><p class="mt-2 text-slate-500">Pantau status konfirmasi dan buka detail setiap rencana kunjunganmu.</p></div>
        <a wire:navigate href="{{ route('catalog') }}" class="btn-primary">Jelajah wisata</a>
    </div>

    <section class="mt-8 space-y-4">
        @forelse ($orders as $order)
            @php($statusClass = match ($order->status) { 'completed' => 'bg-emerald-50 text-emerald-700', 'confirmed' => 'bg-sky-50 text-sky-700', 'cancelled' => 'bg-rose-50 text-rose-700', default => 'bg-amber-50 text-amber-700' })
            <article class="surface flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <div><div class="flex flex-wrap items-center gap-3"><p class="font-serif text-xl font-semibold text-slate-950">{{ $order->transaction_code }}</p><span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $statusClass }}">{{ ucfirst($order->status) }}</span></div><p class="mt-2 text-sm text-slate-500">Diajukan {{ $order->created_at->translatedFormat('d M Y, H:i') }} · Kunjungan {{ $order->visit_date->translatedFormat('d M Y') }}</p><p class="mt-2 text-sm font-semibold text-slate-700">{{ $order->items_count }} pilihan · Rp {{ number_format($order->total_price, 0, ',', '.') }}</p></div>
                <a wire:navigate href="{{ route('orders.show', $order) }}" class="btn-secondary shrink-0">Tinjau detail →</a>
            </article>
        @empty
            <div class="surface p-10 text-center"><p class="font-serif text-2xl font-semibold">Belum ada pesanan.</p><p class="mt-2 text-slate-500">Pilih pengalaman yang ingin kamu kunjungi dari katalog.</p><a wire:navigate href="{{ route('catalog') }}" class="btn-primary mt-6">Mulai jelajah</a></div>
        @endforelse
    </section>
    <div class="mt-7">{{ $orders->links() }}</div>
</div>
