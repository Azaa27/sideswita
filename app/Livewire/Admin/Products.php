<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.store')]
class Products extends Component
{
    public ?int $editing = null;
    public ?int $deleting = null;
    public bool $formOpen = false;

    public array $form = [
        'category_id' => '',
        'code' => '',
        'name' => '',
        'price' => '',
        'stock' => 0,
        'duration' => '',
        'description' => '',
        'image' => 'images/hero-jalatrang.webp',
        'youtube_video_id' => '',
        'is_active' => true,
    ];

    public function edit(?int $id = null): void
    {
        $this->resetValidation();
        $this->editing = $id;
        $this->formOpen = true;

        $this->form = $id
            ? Product::findOrFail($id)->only(array_keys($this->form))
            : [
                'category_id' => '',
                'code' => '',
                'name' => '',
                'price' => '',
                'stock' => 0,
                'duration' => '',
                'description' => '',
                'image' => 'images/hero-jalatrang.webp',
                'youtube_video_id' => '',
                'is_active' => true,
            ];
    }

    public function closeForm(): void
    {
        $this->formOpen = false;
        $this->editing = null;
        $this->resetValidation();
    }

    public function save(): void
    {
        $videoInput = trim((string) ($this->form['youtube_video_id'] ?? ''));
        $this->form['youtube_video_id'] = $videoInput === ''
            ? null
            : Product::normalizeYoutubeVideoId($videoInput) ?? $videoInput;

        $data = $this->validate([
            'form.category_id' => ['required', 'exists:categories,id'],
            'form.code' => ['required', 'max:20', Rule::unique('products', 'code')->ignore($this->editing)],
            'form.name' => ['required', 'max:200'],
            'form.price' => ['required', 'numeric', 'min:0'],
            'form.stock' => ['required', 'integer', 'min:0'],
            'form.duration' => ['nullable', 'max:50'],
            'form.description' => ['nullable'],
            'form.image' => ['required', 'string', 'max:255'],
            'form.youtube_video_id' => ['nullable', 'regex:/^[A-Za-z0-9_-]{11}$/'],
            'form.is_active' => ['boolean'],
        ], [
            'form.youtube_video_id.regex' => 'Gunakan URL YouTube yang valid atau ID video YouTube 11 karakter.',
        ])['form'];

        if (!file_exists(public_path($data['image']))) {
            $this->addError('form.image', 'Berkas gambar tidak ditemukan di folder public.');

            return;
        }

        $data['slug'] = str($data['code'].' '.$data['name'])->slug();
        Product::updateOrCreate(['id' => $this->editing], $data);

        $this->closeForm();
        $this->dispatch('toast', type: 'success', message: 'Produk dan video pendukung berhasil disimpan.');
    }

    public function toggle(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => ! $product->is_active]);
        $this->dispatch('toast', type: 'success', message: 'Status produk diperbarui.');
    }

    public function confirmDelete(int $id): void
    {
        $this->deleting = $id;
    }

    public function delete(): void
    {
        Product::findOrFail($this->deleting)->delete();
        $this->deleting = null;
        $this->dispatch('toast', type: 'success', message: 'Produk diarsipkan dari katalog.');
    }

    public function render()
    {
        return view('livewire.admin.products', [
            'products' => Product::with('category')->latest()->get(),
            'categories' => Category::all(),
        ]);
    }
}
