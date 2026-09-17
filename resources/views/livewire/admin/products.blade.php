<div>
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="eyebrow">Katalog internal</p>
            <h1 class="section-title mt-2">Manajemen produk</h1>
            <p class="mt-2 text-slate-500">Atur pengalaman, cenderamata, gambar, dan video pendukung yang dapat dilihat wisatawan.</p>
        </div>
        <button wire:click="edit" class="btn-primary">+ Produk baru</button>
    </div>

    @if ($formOpen)
        <section class="surface mt-7 p-6 sm:p-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="eyebrow">{{ $editing ? 'Perbarui data' : 'Data baru' }}</p>
                    <h2 class="mt-1 font-serif text-2xl font-semibold">{{ $editing ? 'Perbarui produk' : 'Tambahkan produk' }}</h2>
                </div>
                <button type="button" wire:click="closeForm" class="text-sm font-bold text-slate-500 hover:text-slate-900">Tutup</button>
            </div>

            <form wire:submit="save" class="mt-6 grid gap-4 sm:grid-cols-2">
                <label class="text-sm font-bold">Kategori
                    <select wire:model="form.category_id" class="input-ui">
                        <option value="">Pilih kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('form.category_id')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
                </label>

                <label class="text-sm font-bold">Kode
                    <input wire:model="form.code" class="input-ui" placeholder="PW-01">
                    @error('form.code')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
                </label>

                <label class="text-sm font-bold">Nama produk
                    <input wire:model="form.name" class="input-ui">
                    @error('form.name')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
                </label>

                <label class="text-sm font-bold">Harga
                    <input wire:model="form.price" type="number" class="input-ui">
                    @error('form.price')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
                </label>

                <label class="text-sm font-bold">Stok
                    <input wire:model="form.stock" type="number" class="input-ui">
                    @error('form.stock')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
                </label>

                <label class="text-sm font-bold">Durasi <span class="font-normal text-slate-400">(opsional)</span>
                    <input wire:model="form.duration" class="input-ui">
                </label>

                <label class="text-sm font-bold sm:col-span-2">Path gambar WebP/JPG/PNG
                    <input wire:model="form.image" class="input-ui" placeholder="images/products/produk-baru.webp">
                    @error('form.image')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
                    <span class="mt-1 block text-xs font-normal text-slate-500">Gunakan hasil perintah optimasi media agar katalog selalu memiliki visual yang ringan.</span>
                </label>

                <label class="text-sm font-bold sm:col-span-2">URL atau ID video YouTube <span class="font-normal text-slate-400">(opsional)</span>
                    <input wire:model="form.youtube_video_id" class="input-ui" placeholder="https://youtu.be/xxxxxxxxxxx atau xxxxxxxxxxx">
                    @error('form.youtube_video_id')<span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>@enderror
                    <span class="mt-1 block text-xs font-normal text-slate-500">Tempel URL YouTube biasa, URL pendek, URL embed, atau ID videonya. Sistem hanya menyimpan ID yang tervalidasi.</span>
                </label>

                <label class="text-sm font-bold sm:col-span-2">Deskripsi
                    <textarea wire:model="form.description" rows="3" class="input-ui"></textarea>
                </label>

                <label class="flex items-center gap-2 text-sm font-bold">
                    <input wire:model="form.is_active" type="checkbox" class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600">
                    Tampilkan di katalog
                </label>

                <div class="sm:text-right">
                    <button wire:loading.attr="disabled" class="btn-primary">Simpan produk</button>
                </div>
            </form>
        </section>
    @endif

    <section class="surface mt-7 overflow-hidden">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <h2 class="font-serif text-2xl font-semibold">Daftar produk</h2>
            <span class="text-sm text-slate-500">{{ count($products) }} item</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-left text-sm">
                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-4 py-4">Kategori</th>
                        <th class="px-4 py-4 text-right">Harga</th>
                        <th class="px-4 py-4">Video</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($products as $product)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-6 py-4"><p class="font-bold text-slate-800">{{ $product->name }}</p><p class="mt-1 text-xs text-slate-400">{{ $product->code }}</p></td>
                            <td class="px-4 py-4 text-slate-600">{{ $product->category->name }}</td>
                            <td class="px-4 py-4 text-right font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-4">
                                @if($product->youtubeEmbedUrl())
                                    <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-700">▶ Ada video</span>
                                @else
                                    <span class="text-xs font-medium text-slate-400">Belum ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $product->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td class="px-6 py-4 text-right"><button wire:click="edit({{ $product->id }})" class="text-sm font-bold text-emerald-700">Edit</button><button wire:click="toggle({{ $product->id }})" class="ml-4 text-sm font-bold text-slate-500">Ubah status</button><button wire:click="confirmDelete({{ $product->id }})" class="ml-4 text-sm font-bold text-rose-600">Arsipkan</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    @if ($deleting)
        <div class="fixed inset-0 z-50 grid place-items-center bg-slate-950/50 p-4">
            <section class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                <h2 class="font-serif text-2xl font-semibold">Arsipkan produk?</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">Produk akan disembunyikan dari katalog. Riwayat pesanan lama tetap aman.</p>
                <div class="mt-6 flex justify-end gap-3"><button wire:click="$set('deleting', null)" class="btn-secondary">Batal</button><button wire:click="delete" class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-rose-700">Ya, arsipkan</button></div>
            </section>
        </div>
    @endif
</div>
