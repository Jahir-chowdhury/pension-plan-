@extends('layouts.admin.admin_master', ['title' => 'Edit Role'])

@push('custom_styles')
    <style>
        .form-group {
            margin-top: 5px;
        }
    </style>
    <link href="{{ asset('backend') }}/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('backend') }}/libs/%40chenfengyuan/datepicker/datepicker.min.css" type="text/css">
    <link href="{{ asset('backend') }}/libs/%40chenfengyuan/datepicker/datepicker.min.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="pull-left">@lang('Role Edit Form')</span>
                </div>
                <div class="card-body">
                    @include('messages')
                    @include('admin.roles.edit_form')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_scripts')
    <script src="{{ asset('backend') }}/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('backend') }}/js/pages/form-advanced.init.js"></script>
    <!--Quill js-->
    <script src="{{ asset('backend') }}/libs/quill/quill.min.js"></script>
    <script src="{{ asset('backend') }}/libs/flatpickr/flatpickr.min.js"></script>

    <script>
        /**
         * Check all the permissions
         */
        $("#edit_checkPermissionAll").click(function() {
            if ($(this).is(':checked')) {
                // check all the checkbox
                $('input[type=checkbox]').prop('checked', true);
            } else {
                // un check all the checkbox
                $('input[type=checkbox]').prop('checked', false);
            }
        });

        function edit_checkPermissionByGroup(className, checkThis) {
            const groupIdName = $("#" + checkThis.id);
            const classCheckBox = $('.' + className + ' input');
            if (groupIdName.is(':checked')) {
                classCheckBox.prop('checked', true);
            } else {
                classCheckBox.prop('checked', false);
            }
            edit_implementAllChecked();
        }

        function edit_checkSinglePermission(groupClassName, groupID, countTotalPermission) {
            const classCheckbox = $('.' + groupClassName + ' input');
            const groupIDCheckBox = $("#" + groupID);
            // if there is any occurance where something is not selected then make selected = false
            if ($('.' + groupClassName + ' input:checked').length == countTotalPermission) {
                groupIDCheckBox.prop('checked', true);
            } else {
                groupIDCheckBox.prop('checked', false);
            }
            edit_implementAllChecked();
        }

        function edit_implementAllChecked() {
            const countPermissions = {{ count($all_permissions) }};
            const countPermissionGroups = {{ count($group_permissions) }};
            console.log(countPermissionGroups)
            if ($('.edit_all input:checked').length >= (countPermissions + countPermissionGroups)) {
                $("#edit_checkPermissionAll").prop('checked', true);
            } else {
                $("#edit_checkPermissionAll").prop('checked', false);
            }
        }
    </script>
@endpush
