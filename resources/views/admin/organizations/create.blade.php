@extends('layouts.admin.admin_master', ['title'=>'Create new Organization and details'])

@push('custom_styles')
    <style>
        .form-group{
            margin-top: 5px;
        }
    </style>
    <link href="{{asset('backend')}}/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{asset('backend')}}/libs/%40chenfengyuan/datepicker/datepicker.min.css" type="text/css">
    <link href="{{asset('backend')}}/libs/%40chenfengyuan/datepicker/datepicker.min.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="pull-left">@lang('Organization Details Form')</span>
                </div>
                <div class="card-body">
                    @include('messages')
                    @include('admin.organizations.create_form')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_scripts')
<script src="{{asset('backend')}}/libs/select2/js/select2.min.js"></script>
<script src="{{asset('backend')}}/js/pages/form-advanced.init.js"></script>
<!--Quill js-->
<script src="{{asset('backend')}}/libs/quill/quill.min.js"></script>
<script src="{{asset('backend')}}/libs/flatpickr/flatpickr.min.js"></script>
@endpush
