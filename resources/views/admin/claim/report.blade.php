@extends('layouts.admin.admin_master', ['title'=>'Report'])

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
    <h5 class="mb-3"><strong>Search Report</strong></h5>
    <div class="row p-3">
        @include('messages')
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-hear">
                    Search Report
                </div>
                <div class="card-body">
                    <form action="{{ isset($formSubmissionUrl) ? $formSubmissionUrl : route('claims.report') }}"
                        method="get">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="">Select an Organization</label>
                                <select name="organization_id" class="form-control">
                                    <option value="">All Organization</option>
                                    @foreach($organizations as $org)
                                    <option value="{{$org->id}}" {{request()->organization_id == $org->id ? 'selected' : ''}} >{{$org->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Member Code</label>
                                    <input type="text" name="memberCode" value="{{ $request['memberCode'] ?? '' }}"
                                        placeholder="Member Code" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label for="">Select Report Type</label>
                                <select name="status_id" class="form-control">
                                    <option value="">All</option>
                                    @foreach($claimStatus as $status)
                                    <option value="{{$status->id}}" {{request()->status_id == $status->id ? 'selected' : ''}} >{{$status->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Start Date</label>
                                    <input type="date" class="form-control" name="startDate"
                                        value="{{ $request['startDate'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">End Date</label>
                                    <input type="date" class="form-control" name="endDate"
                                        value="{{ $request['endDate'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-sm">Search</button>
                                <button type="submit" name="submit" value="download"
                                class="btn btn-success btn-sm">Download</button>
                                <a href="{{ route(\Request::route()->getName()) }}" class="btn btn-info btn-sm"> Remove
                                    Filters</a>
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
                <span class="pull-left"> List Of Claims</span>
                {{-- <ul><a href="{{ route('dashboard.download',['id' => 1]) }}"><span
                    key="t-crypto"><button type="submit" name="submit" value="download"
                    class="btn btn-success btn-sm">Download</button></span></a></ul> --}}
            </div>
            <div class="card-body">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <td>@lang('Organization')</td>
                            <td>@lang('Member ID')</td>
                            <td>@lang('Intimation No')</td>
                            <td>@lang('Claim Type')</td>
                            <td>@lang('Incident Date')</td>
                            <td>@lang('Claimed Amount')</td>
                            <td>@lang('Rivew')</td>
                            <td>@lang('Status')</td>
                            <td>@lang('Action')</td>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($claims as $claim)
    
                        <tr>
                            <td>{{$claim->organization->name}}</td>
                            <td>{{$claim->member_id}}</td>
                            <td>{{$claim->intimation_number}}</td>
                            <td>{{$claim->claim_type}}</td>
                            <td>{{$claim->incident_date}}</td>
                            <td>{{$claim->claimed_amount}} TK</td>
                            <td><span class="badge bg-warning">{{$claim->claim_officer_remarks?? 'No Rivew'}}</span></td>
                            <td>
                                @if ($claim->claim_status==6) 
                                    <span class="badge bg-success">Settled</span>
                                @elseif($claim->claim_status==1) 
                                    <span class="badge bg-danger">Under Processing</span>
                                @elseif($claim->claim_status==3) 
                                    <span class="badge bg-danger">Documents Required</span>
                                @elseif($claim->claim_status==2)
                                    <span class="badge bg-danger">Documents investigation</span>
                                @elseif($claim->claim_status==4)
                                    <span class="badge bg-danger">With Discussion</span>
                                @elseif($claim->claim_status==5)
                                    <span class="badge bg-danger">Regreted</span>
                                @else
                                    <span class="badge bg-danger">Under Processing</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('claims.process_create', ['id' => $claim->id])}}">
                                    <span  class="badge bg-info  member-update-btn" style="cursor: pointer;">
                                        <b>Process</b>
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
@section('scripts')
    <!--Nice select-->
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script>
        //Nice select
        $('.bulk-actions').niceSelect();
    </script>
@endsection

