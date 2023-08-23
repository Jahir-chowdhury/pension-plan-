@extends('layouts.admin.admin_master', ['title'=>'Approved EFT Return List'])

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
    <div class="row">
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-hear">
                    Search by intimation no.
                </div>
                <div class="card-body">
                    <form action="{{ isset($formSubmissionUrl) ? $formSubmissionUrl : route('collection.claim.approved') }}"id="payment-form"
                        method="get">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <label for="">Intimation No</label>
                                    <input type="text" name="intimation_no" value="{{old("intimation_no")}}"
                                        placeholder="Intimation No" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-sm">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="pull-left">Approve Claims List</span>
            </div>
            <div class="card-body">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <td>@lang('Member ID')</td>
                            <td>@lang('Intimation No')</td>
                            <td>@lang('Claim Type')</td>
                            <td>@lang('Incident Date')</td>
                            <td>@lang('Settled Amount')</td>
                            <td>@lang('Status')</td>
                            <td>@lang('Action')</td>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($claims as $claim)
                        <tr>
                            <td>{{$claim->member_id}}</td>
                            <td>{{$claim->intimation_number}}</td>
                            <td>{{$claim->claim_type}}</td>
                            <td>{{$claim->incident_date}}</td>
                            <td>{{$claim->claimed_amount}} TK</td>
                            <td>
                                <span  class="badge bg-success  member-update-btn" style="cursor: pointer;">
                                {{$claim->claimsStatus->name}}
                                </span>
                            </td>
                            <td>
                                <a href="{{route('collection.claim.payment', ['id' => $claim->id])}}">
                                    <span  class="badge bg-info  member-update-btn" style="cursor: pointer;">
                                        <b>Pay</b>
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
    </div>
@endsection

@push('custom_scripts')
<script src="{{asset('backend')}}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('backend')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="{{asset('backend')}}/js/pages/datatables.init.js"></script>
@endpush