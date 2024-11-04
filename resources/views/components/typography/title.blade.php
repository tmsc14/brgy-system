<span {{ $attributes->merge(['class' => ($spaced ?? false ? 'mb-2' : '') . ' fs-2 fw-bold']) }}>
    {{ $slot }}
</span>
