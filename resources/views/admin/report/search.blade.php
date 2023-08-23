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
                    <form action="{{ isset($formSubmissionUrl) ? $formSubmissionUrl : route('dashboard.report') }}"
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
                                <select name="reportType" class="form-control">
                                    {{-- <option value="">Select Report Type</option> --}}
                                    <option value="summury"{{request()->reportType == 'summury' ? 'selected' : ''}}>Summury Report</option>
                                    <option value="installment"{{request()->reportType == 'installment' ? 'selected' : ''}}>Installment Report</option>
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
                            <div class="col-sm-12 col-md-3">
                                <label for="">Select (with/without) Interset</label>
                                <select name="interestType" class="form-control">
                                    {{-- <option  value="">Select Report Type</option> --}}
                                    <option value="0"{{request()->interestType == 0 ? 'selected' : ''}}>With Interset</option>
                                    <option value="1"{{request()->interestType == 1 ? 'selected' : ''}}>Without Interset</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-sm">Search</button>
                                
                                <a href="{{ route(\Request::route()->getName()) }}" class="btn btn-info btn-sm"> Remove
                                    Filters</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @if($reportType !== 'installment')
            <div class="row">
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <a href="">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div class="avatar-sm">
                                                <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                                    <i class='fas fa-dollar-sign'></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="font-size-15 mb-0 text-truncate">Total</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3 pt-1">
                                            <div>
                                                <center><h4 class="font-size-50 center">{{round($total_premium)}} TK</h4></center>
                                                <p class="mb-0 text-success fw-semibold font-size-15"> Deposited Premium <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                            </div>
                                            <div>
                                                <div id="chart-sparkline1"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                                <i class='fas fa-dollar-sign'></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="font-size-14 mb-0 text-truncate"> Total</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3 pt-1">
                                        <div>
                                            <center><h4 class="font-size-50 center">{{round($total_withdrawal)}} TK</h4></center>
                                            <p class="mb-0 text-success fw-semibold font-size-15">Withdrawal<i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                        </div>
                                        <div>
                                            <div id="chart-sparkline1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                                <i class='fas fa-dollar-sign'></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="font-size-14 mb-0 text-truncate">Total</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3 pt-1">
                                        <div>
                                            <center><h4 class="font-size-50 center">{{round($total_accumulated_fund)}} TK</h4></center>
                                            <p class="mb-0 text-success fw-semibold font-size-15">Acumulated Fund <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                        </div>
                                        <div>
                                            <div id="chart-sparkline1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                        <i class='fas fa-dollar-sign'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="font-size-14 mb-0 text-truncate">Total</h6>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-1">
                                <div>
                                    <center><h4 class="font-size-50 center">{{round($total_net_balance)}} TK</h4></center>
                                    <p class="mb-0 text-success fw-semibold font-size-15"> Net Balance <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                </div>
                                <div>
                                    <div id="chart-sparkline1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <a href="">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div class="avatar-sm">
                                                <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                                    <i class='fas fa-dollar-sign'></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class="font-size-15 mb-0 text-truncate">Total</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3 pt-1">
                                            <div>
                                                <center><h4 class="font-size-50 center">{{round($total_net_charge)}} TK</h4></center>
                                                <p class="mb-0 text-success fw-semibold font-size-15"> Net Charge <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                            </div>
                                            <div>
                                                <div id="chart-sparkline1"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                                <i class='fas fa-dollar-sign'></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="font-size-14 mb-0 text-truncate"> Total</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3 pt-1">
                                        <div>
                                            <center><h4 class="font-size-50 center">{{round($total_interest)}} TK</h4></center>
                                            <p class="mb-0 text-success fw-semibold font-size-15">Net Interest<i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                        </div>
                                        <div>
                                            <div id="chart-sparkline1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="avatar-sm">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                                <i class='fas fa-dollar-sign'></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="font-size-14 mb-0 text-truncate">Total</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3 pt-1">
                                        <div>
                                            <center><h4 class="font-size-50 center">{{0}}</h4></center>
                                            <p class="mb-0 text-success fw-semibold font-size-15">Acumulated Fund <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                        </div>
                                        <div>
                                            <div id="chart-sparkline1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            
            </div>
         @else
         <div class="row justify-content-center">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="pull-left"> List Of Installment</span>
                    {{-- <ul><a href="{{ route('dashboard.download',['id' => 1]) }}"><span
                        key="t-crypto"><button type="submit" name="submit" value="download"
                        class="btn btn-success btn-sm">Download</button></span></a></ul> --}}
                </div>
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <td>@lang('Organization')</td>
                                <td>@lang('Member')</td>
                                <td>@lang('Year/Month')</td>
                                <td>@lang('Employee C.')</td>
                                <td>@lang('Employer C.')</td>
                                <td>@lang('Premium')</td>
                                <td>@lang('Ac.Fund')</td>
                                <td>@lang('Charge')</td>
                                <td>@lang('Interest')</td>
                                <td>@lang('Download')</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($installment as $temp)
                            <tr>
                                <td>{{$temp->org_id}}</td>
                                <td>{{$temp->member_code}}</td>
                                <td>{{$temp->year.'/'.$temp->month}}</td>
                                <td>{{$temp->employeeContribution}} TK</td>
                                <td>{{$temp->employerContribution}} TK</td>
                                <td>{{$temp->amount}} TK</td>
                                <td>{{round($temp->accumulated_fund)}} TK</td>
                                <td>{{round($temp->net_charge)}} TK</td>
                                <td>{{round($temp->interest)}} TK</td>
                                <td>
                                    <a href="{{ route('dashboard.download', ['id' => $temp->member_code]) }}">
                                        <span data-obj="{{ $temp }}"
                                            class="badge bg-info  organization-update-btn" style="cursor: pointer;">
                                            <b>Individual</b>
                                        </span>
                                    </a>
                                    <a href="{{ route('dashboard.download.org', ['id' => $temp->org_id]) }}">
                                        <span data-obj="{{ $temp }}"
                                            class="badge bg-info  organization-update-btn" style="cursor: pointer;">
                                            <b>Organization</b>
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
         @endif
        
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

