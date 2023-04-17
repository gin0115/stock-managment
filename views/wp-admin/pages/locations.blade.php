{{-- Layouts dashboard. --}}

@extends('views.wp-admin.layouts.list')

@section('content')
<div class="gui-template__header">
    {!! $this->component($nav) !!}
</div>

<div class="gui-template__content">
    <div class="container-fluid">
        @forelse ($sites ?? [] as $site)
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
