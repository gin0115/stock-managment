<label for={{ $name }}>{{ $label }}</label>
<input type="text" name={{ $name }} {!! $attributes !!}>
@if(! empty($errors))
<div id="validation{{ $name }}" class="invalid-feedback">
    @foreach($errors as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif