<div {{ $attributes->merge(['class' => ($spaced ?? false ? 'mb-2' : '') . ' fs-3 fw-bold']) }}>
    {{ $slot }}
</div>
