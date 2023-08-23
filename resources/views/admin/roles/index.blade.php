@extends('layouts.admin.admin_master', ['title' => 'Roles'])

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
                    <span class="pull-left">@lang('Role Lists')</span>
                </div>
                <div class="card-body">
                    @include('messages')

                    <table class="table table-bordered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr class="table-hd-bg">
                                <th>#</th>
                                <th>Name</th>
                                <th>action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @role(1)
                                            <a href="{{ route('role.edit', $role->id) }}" class="btn btn-info"><i
                                                    class="fas fa-edit"></i></a>
                                        @endrole
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
@endpush
