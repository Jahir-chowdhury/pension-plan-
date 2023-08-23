@extends('layouts.admin.admin_master', ['title'=>'Contract'])

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
        <form action="{{route('organization.contract.index')}}">
        <div class="col-md-12 justify-content-center row">
            <div class="col-sm-12 col-md-5">
                <select name="organization_id" class="form-control">
                    <option value="">Select an Organization</option>
                    @foreach($organizations as $org)
                    <option value="{{$org->id}}" {{request()->organization_id == $org->id ? 'selected' : ''}} >{{$org->name}}</option>
                    @endforeach
                </select>
            </div>
            
            
            <div class="col-sm-12 col-md-3">
                <button type="submit" class="btn btn-md btn-primary">Search</button>
            </div>

            <div class="col-sm-12"><hr /></div>
        </div>
        </form>

        @if( $selectedOrganization )
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="pull-left">Contract List</span>
            </div>
            <div class="card-body">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <td>@lang('Name')</td>
                            <td>@lang('Title')</td>
                            <td>@lang('Version')</td>
                            <td>@lang('File')</td>
                            <td>@lang('Status')</td>
                            <td>@lang('Action')</td>
                        </tr>
                    </thead>


                    <tbody>
                    @forelse($selectedOrganization->contract as $contract)
                        <tr>
                            <td>{{$selectedOrganization->name}}</td>
                            <td>{{$contract->contract_tittle}}</td>
                            <td>{{$contract->contract_version}}</td>
                            <td>
                                <div class="entry input-group upload-input-group ">
                                    <a href="{{asset($contract->path)}}" target="blank">
                                    <img src="{{ asset('thumnail/pdf.png') }}" alt="" class="img-thumbnail"width="50" height="20">
                                </div>
                            </td>

                            <td>
                                @if ($contract->active_status) 
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <span  class="badge bg-info  member-update-btn" style="cursor: pointer;">
                                    <a href="{{asset($contract->path)}}" target="_blank"><b>Download</b></a>
                                </span>
                            </td>
                        </tr>
                    @empty
                        
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

@endsection



@push('custom_scripts')
<script src="{{asset('backend')}}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('backend')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="{{asset('backend')}}/js/pages/datatables.init.js"></script>
@endpush
