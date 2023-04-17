{{-- Sites Index Template --}}
@extends('views.wp-admin.layouts.list')

@section('content')
<div class="gui-template__header">
    {!! $this->component($nav) !!}
</div>

<div class="gui-template__content px-2 mt-2">
    <div class="container-fluid px-2 mt-2">
        {{ isset($new_site_button) ? $this->component($new_site_button) : '' }}
    </div>
    <div class="container-fluid px-2 mt-2">
        @forelse ($sites ?? [] as $site)
        {{-- @dump($site) --}}
        {!! $this->component($site) !!}
        @empty
        <div class="card">
            <div class="card-body">
                @i18n('No sites, yet.')
            </div>
        </div>
        @endforelse
    </div>
</div>

<div class="gui-template__footer">
</div>
@endsection