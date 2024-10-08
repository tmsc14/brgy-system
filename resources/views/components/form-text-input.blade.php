<div class="form-group">
    <label class="text-light" for="{{ $id }}">{{ $label }}</label>
    <input class="form-control" type="{{ $type ?? "text" }}" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}" />
    @if ($errors->has('email'))
        <span class="error">{{ $errors->first('email') }}</span>
    @endif
</div>
