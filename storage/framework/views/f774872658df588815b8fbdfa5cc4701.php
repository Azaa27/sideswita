<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"><title><?php echo e(config('app.name','Jalatrang Wisata')); ?></title><link rel="preconnect" href="https://fonts.bunny.net"><link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:600,700&display=swap" rel="stylesheet"/><?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css','resources/js/app.js']); ?></head><body><?php if (isset($component)) { $__componentOriginal704196272d5e2debce23ffdbf1a3fb23 = $component; } ?>
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
<?php endif; ?><?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('layout.navigation', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3462907320-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($header)): ?><header class="border-b border-slate-200 bg-white"><div class="page-shell py-7"><?php echo e($header); ?></div></header><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><main class="page-shell py-8 sm:py-10"><?php echo e($slot); ?></main></body></html>
<?php /**PATH C:\laragon\www\sideswita 2\resources\views/layouts/app.blade.php ENDPATH**/ ?>