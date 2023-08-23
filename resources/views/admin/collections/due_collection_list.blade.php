@extends('layouts.admin.admin_master', ['title'=>'Due Collection Information'])

@push('custom_styles')
    <style>
        .form-group{
            margin-bottom: 10px;
        }
        .required-label::after {
            content: " *";
            color: red;
        }
    </style>
    <!-- DataTables -->
    <link href="{{asset('backend')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    @include('messages')
    <div class="row justify-content-center">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="pull-left">Due collection List</span>
            </div>
            <div class="card-body">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <td>@lang('Organization Name')</td>
                            <td>@lang('Organization Code')</td>
                            <td>@lang('Due Date')</td>
                            <td>@lang('Due Amount')</td>
                            <td>@lang('Suspence Amount')</td>
                            <td>@lang('Member Count')</td>
                            <td>@lang('Action')</td>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($collections as $collection)
                        <tr>
                            <td>{{$collection->organization->name}}</td>
                            <td>{{$collection->organization->code}}</td>
                            <td>{{$collection->due_date}}</td>
                            <td>{{$collection->amount}}</td>
                            <td>{{$collection->suspence_amount}}</td>
                            <td>{{$collection->members_count}}</td>
                            <td>
                                <span data-obj="{{$collection}}" class="badge bg-info  member-update-btn" style="cursor: pointer;">
                                    <b>Download</b>
                                </span>
                            </td>
                        </tr>
                    @empty
                        
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>



@endsection



@push('custom_scripts')
<script src="{{asset('backend')}}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('backend')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="{{asset('backend')}}/js/pages/datatables.init.js"></script>
@endpush
