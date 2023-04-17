<div class="alert alert-{{$notification_type}}" role="alert">
    <div class="list-group">
        @foreach($errors as $type => $type_errors)
            <div>
                <div class="d-flex w-100 justify-content-between ">
                    <h5 class="mb-1">{{ $type }}</h5>
                </div>
                @foreach($type_errors as $error)
                    <p class="mb-1">{{ $error }}</p>
                @endforeach
            </div>
        @endforeach
    </div>
</div>