@extends('views.wp-admin.layouts.list')

@use(PinkCrab\Stock_Management\WP_Admin\GUI\Component\Shared\Notification)
@use(PinkCrab\Stock_Management\WP_Admin\GUI\Component\Bootstrap\Input)

@php
// dump($form, get_defined_vars());
// dump($form->get_notifications()->get_errors());
// $r = ($form->is_submitted() && $form->has_error('site_name')) ? 'is-invalid' : '';
// dump($r, $form->has_error('site_name'));
// dump(add_query_arg());
// dump(admin_url(sprintf(basename($_SERVER['REQUEST_URI']))));
@endphp

@section('content')
<div class="gui-template__header">
    {!! $this->component($nav) !!}
</div>
<div class="gui-template__content">
    {!! $this->component(new Notification($form->get_notifications())) !!}
    
    <div></div>
    @form(method="post")
        @input(type="hidden" name="page" value="pc_stockman_location")
        @input(type="hidden" name="gui_route" value="sites")
        @input(type="hidden" name="gui_action" value="create")
        @input(type="hidden" name="form_nonce" value="$nonce")
        
        <div class="form-group mb-3 site_name">
            {{ $this->component(Input::text(
                'site_name', 
                ['id' => 'site_name', 'value' => $form->get_value('site_name')], 
                $form->get_errors('site_name')
                )->set_label(__('Site Name', 'pc-stockman')))
            }}
        </div>

        <div class="form-group mb-3 site_ref">
            {{ $this->component(Input::text(
                'site_ref', 
                ['id' => 'site_ref', 'value' => $form->get_value('site_ref')], 
                $form->get_errors('site_ref')
                )->set_label(__('Site Reference', 'pc-stockman')))
            }}
        </div>

        <div class="form-group mb-3 site_barcode">
            {{ $this->component(Input::text(
                'site_barcode', 
                ['id' => 'site_barcode', 'value' => $form->get_value('site_barcode')], 
                $form->get_errors('site_barcode')
                )->set_label(__('Site Barcode', 'pc-stockman')))
            }}
        </div>

        <button type="submit" class="btn btn-primary">@i18n('Submit')</button>
    @endform()
</div>
<div class="gui-template__footer">
</div>
@endsection
