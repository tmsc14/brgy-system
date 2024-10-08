<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <input type="{{ $type ?? "text" }}" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}" />
    @if ($errors->has('email'))
        <span class="error">{{ $errors->first('email') }}</span>
    @endif
</div>
