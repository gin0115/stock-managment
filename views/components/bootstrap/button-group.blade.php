<div {!! $attributes !!}>
    @foreach($buttons as $button)
    {!! $this->component($button, false) !!}
    @endforeach
</div>