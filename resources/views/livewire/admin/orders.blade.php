<div>
    <div>
        <p class="eyebrow">Operasional</p>
        <h1 class="section-title mt-2">Pesanan masuk</h1>
        <p class="mt-2 text-slate-500">Konfirmasi setiap pengajuan agar pengunjung mendapatkan kepastian sebelum berkunjung.</p>
    </div>

    <section class="surface mt-7 overflow-hidden">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <h2 class="font-serif text-2xl font-semibold">Daftar pesanan</h2>
            <span class="text-sm text-slate-500">{{ $orders->total() }} pesanan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[780px] text-left text-sm">
                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500"><tr><th class="px-6 py-4">Pesanan</th><th class="px-4 py-4">Pengunjung</th><th class="px-4 py-4">Kunjungan</th><th class="px-4 py-4 text-right">Total</th><th class="px-4 py-4">Status</th><th class="px-6 py-4 text-right">Tindakan</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($orders as $order)
                        @php
                            $statusClass = match ($order->status) {
                                'completed' => 'bg-emerald-50 text-emerald-700',
                                'confirmed' => 'bg-sky-50 text-sky-700',
                                'cancelled' => 'bg-rose-50 text-rose-700',
                                default => 'bg-amber-50 text-amber-700',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-6 py-4"><p class="font-bold text-slate-800">{{ $order->transaction_code }}</p><p class="mt-1 text-xs text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</p></td>
                            <td class="px-4 py-4 font-semibold text-slate-700">{{ $order->visitor_name }}</td><td class="px-4 py-4 text-slate-600">{{ $order->visit_date->format('d M Y') }}</td><td class="px-4 py-4 text-right font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $statusClass }}">{{ ucfirst($order->status) }}</span></td>
                            <td class="px-6 py-4 text-right"><a wire:navigate href="{{ route('admin.orders.show', $order) }}" class="btn-secondary px-3 py-2 text-xs">Detail →</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-6 py-4">{{ $orders->links() }}</div>
    </section>
</div>
