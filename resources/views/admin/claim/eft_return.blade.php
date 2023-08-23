@extends('layouts.admin.admin_master', ['title'=>'EFT Return Claim'])

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
        <form action="{{route('claims.eft.return')}}">
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
        @if( !empty($claims) )
        <form action="">
            @csrf
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="pull-left">Member List</span>
                </div>
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <td>@lang('Name')</td>
                                <td>@lang('Employee ID')</td>
                                <td>@lang('Member ID')</td>
                                <td>@lang('Mobile No.')</td>
                                <td>@lang('Membership date')</td>
                                <td>@lang('Date of birth')</td>
                                <td>@lang('Action')</td>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($claims as $claim)
                            <tr>
                                <td>{{$claim->member->name}}</td>
                                <td>{{$claim->member->emp_id}}</td>
                                <td>{{$claim->member->member_id}}</td>
                                <td>{{$claim->member->mobile}}</td>
                                <td>{{$claim->member->membership_date}}</td>
                                <td>{{$claim->member->date_of_birth}}</td>
                                <td>
                                    <a href={{route('claims.eft.edit',['id' =>$claim->id])}}>
                                    <span  class="badge bg-info  member-update-btn" style="cursor: pointer;">
                                        <b>Edit</b>
                                    </span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        @endif
    </div>
@endsection



@push('custom_scripts')
<script src="{{asset('backend')}}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('backend')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="{{asset('backend')}}/js/pages/datatables.init.js"></script>
@endpush
