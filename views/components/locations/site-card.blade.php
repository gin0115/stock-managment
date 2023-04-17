<div id="site_{{ $site->name() | sanitize_title }}" class="card location__site">
    <div class="card-header">
        <div class="row align-items-start">
            <div class="col">
                <h2>{{ $site->name() }}<span class="ref"> [{{ $site->ref() }}]</span><h2>
            </div>
            <div class="col text-end">
                {!! $this->component($button_group, false) !!}
            </div>
        </div>

    </div>
    <div class="card-body">
        
    </div>
</div>
