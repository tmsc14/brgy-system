<div class="d-flex gap-4 mb-4 flex-column flex-xl-row justify-content-around">
    @if ($steps ?? false)
    @foreach ($steps as $step)
        <div>
            @if ($step->isCurrent())
                <span class="fs-4 text text-primary fw-bold">
                    {{ $step->order }}. {{ $step->label }}
                </span>
            @else
                <a wire:click="showStep('{{ $step->step_name }}')" class="fs-4 text text-brown-primary" href="#">
                    {{ $step->order }}. {{ $step->label }}
                </a>
            @endif
        </div>
    @endforeach
    @endif
</div>
