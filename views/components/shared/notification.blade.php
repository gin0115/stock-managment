@if(!empty($errors))
    @include('views.components.shared.notification-row', [
        'notification_type' => 'danger',
        'errors' => $errors,
    ])
@endif

@if(!empty($warnings))
    @include('views.components.shared.notification-row', [
        'notification_type' => 'warning',
        'errors' => $warnings,
    ])
@endif

@if(!empty($successes))
    @include('views.components.shared.notification-row', [
        'notification_type' => 'success',
        'errors' => $successes,
    ])
@endif

@if(!empty($infos))
    @include('views.components.shared.notification-row', [
        'notification_type' => 'info',
        'errors' => $infos,
    ])
@endif
{{-- @dump(get_defined_vars()) --}}
