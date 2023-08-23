@extends('layouts.admin.admin_master', ['title'=>'Dashboard'])

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
@hasanyrole('Super Admin|Admin')
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
                                        <i class='fas fa-industry'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="font-size-15 mb-0 text-truncate"> Active Organization</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-1">
                                <div>
                                    <center><h4 class="font-size-50 center">{{$active_org}}</h4></center>
                                    <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
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
                <a href="">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                        <i class='fas fa-users'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="font-size-15 mb-0 text-truncate"> Active Member</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-1">
                                <div>
                                    <center><h4 class="font-size-50 center">{{$active_member}}</h4></center>
                                    <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
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
                                    <i class='fas fa-industry'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="font-size-14 mb-0 text-truncate"> Inactive Organization</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3 pt-1">
                            <div>
                                <center><h4 class="font-size-50 center">{{$inactive_org}}</h4></center>
                                <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
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
                        <h6 class="font-size-14 mb-0 text-truncate"> Total Premium </h6>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3 pt-1">
                    <div>
                        <center><h4 class="font-size-50 center">{{$total_premium}} TK</h4></center>
                        <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                    </div>
                    <div>
                        <div id="chart-sparkline1"></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- end row -->
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <center><h4 class="card-title">Latest Organization</h4> </center>   
                <div class="table-responsive">
                    <table class="table table-striped mb-0">

                        <thead>
                            <tr>
                                <th>Code</th>
                                <th> Name</th>
                                <th>Employer Contribution</th>
                                <th>Employee Contribution</th>
                                <th>Onboard </th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($organizations as $organization)
                            <tr>
                                <td>{{ $organization->code }}</td>
                                <td>{{ $organization->name }}</td>
                                <td><center>{{ $organization->employer_protion }} %</center></td>
                                <td><center>{{ $organization->employee_protion }} %</center></td>
                                <td>{{ $organization->commencement_date }}</td>
                                <td>{{ $organization->phone }}</td>
                            </tr>
                            @empty
                    
                            @endforelse
                        </tbody>
                    </table>
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
                        <h6 class="font-size-14 mb-0 text-truncate"> Suspens Amount </h6>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3 pt-1">
                    <div>
                        <center><h4 class="font-size-50 center">{{$suspense}} TK</h4></center>
                        <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                    </div>
                    <div>
                        <div id="chart-sparkline1"></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endhasanyrole
<!-- Works on later -->
@hasanyrole('Super Admin|Operator|Doctor|Claim Officer|Claim HOD|COO|CEO')
<div class="row">
    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <a href="{{route('claims.underprocessing')}}">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                        <i class='fas fa-industry'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="font-size-15 mb-0 text-truncate">Under Processing</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-1">
                                <div>
                                    <center><h4 class="font-size-50 center">{{$under_process}}</h4></center>
                                    <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                </div>
                                <div>
                                    <div id="chart-sparkline1"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <a href="{{route('claims.document.required')}}">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                        <i class='fas fa-users'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="font-size-15 mb-0 text-truncate">Document Required</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-1">
                                <div>
                                    <center><h4 class="font-size-50 center">{{$document_required}}</h4></center>
                                    <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                </div>
                                <div>
                                    <div id="chart-sparkline1"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                    <i class='fas fa-industry'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="font-size-14 mb-0 text-truncate">Regreted Claim</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3 pt-1">
                            <div>
                                <center><h4 class="font-size-50 center">{{$regreted}}</h4></center>
                                <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
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
                        <h6 class="font-size-14 mb-0 text-truncate"> Total Claim </h6>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3 pt-1">
                    <div>
                        <center><h4 class="font-size-50 center">{{$total_claim}}</h4></center>
                        <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
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
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Latest Claim</h4>    
                <div class="table-responsive">
                    <table class="table table-striped mb-0">

                        <thead>
                            <tr>
                                <th>Intimation No</th>
                                <th>Claim Type</th>
                                <th>Claim Amount</th>
                                <th>Incident Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($claims as $claim)
                            <tr>
                                <td>{{$claim->intimation_number}}</td>
                                <td>{{$claim->claim_type}}</td>
                                <td>{{$claim->claimed_amount}}</td>
                                <td>{{$claim->incident_date}}</td>
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
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
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
                        <h6 class="font-size-14 mb-0 text-truncate"> Total Settled Claim </h6>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3 pt-1">
                    <div>
                        <center><h4 class="font-size-50 center">{{$settled}}</h4></center>
                        <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                    </div>
                    <div>
                        <div id="chart-sparkline1"></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endhasanyrole
<!-- end row -->
@hasanyrole('Super Admin|Account Admin|COO|CEO')
<div class="row">
    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="card">
                    <a href="{{ route('collection.due.death.payment') }}">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                        <i class='fas fa-users'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="font-size-15 mb-0 text-truncate">Due Death Payment</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-1">
                                <div>
                                    <center><h4 class="font-size-50 center">{{$countDeathPayment}}</h4></center>
                                    <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                </div>
                                <div>
                                    <div id="chart-sparkline1"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="card">
                    <a href="{{ route('collection.due.planA.payment') }}">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                        <i class='fas fa-users'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="font-size-14 mb-0 text-truncate">Due PlanA Payment</h6>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-1">
                                <div>
                                    <center><h4 class="font-size-50 center">{{$countPlanAPayment}}</h4></center>
                                    <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                </div>
                                <div>
                                    <div id="chart-sparkline1"></div>
                                </div>
                            </div>
                        </div>
                    </a>
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
                                <i class='fas fa-users'></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="font-size-15 mb-0 text-truncate">Total Due Payment</h5>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3 pt-1">
                        <div>
                            <center><h4 class="font-size-50 center">{{$totalPendingCount}}</h4></center>
                            <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
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
            <div class="col-md-6 col-xl-6">
                <div class="card">
                    <a href="{{route('collection.report')}}">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                        <i class='fas fa-users'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="font-size-15 mb-0 text-truncate">Total Death Payment</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-1">
                                <div>
                                    <center><h4 class="font-size-50 center">{{$countSubmitDeathPayment}}</h4></center>
                                    <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                </div>
                                <div>
                                    <div id="chart-sparkline1"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="card">
                    <a href="{{route('collection.report')}}">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                        <i class='fas fa-users'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="font-size-14 mb-0 text-truncate">Total PlanA Payment</h6>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-1">
                                <div>
                                    <center><h4 class="font-size-50 center">{{$countSubmitPlanAPayment}}</h4></center>
                                    <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                </div>
                                <div>
                                    <div id="chart-sparkline1"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <a href="{{route('collection.report')}}">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="avatar-sm">
                            <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                <i class='fas fa-users'></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="font-size-15 mb-0 text-truncate">Total  Payment</h5>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3 pt-1">
                        <div>
                            <center><h4 class="font-size-50 center">{{$totalSubmitCount}}</h4></center>
                            <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                        </div>
                        <div>
                            <div id="chart-sparkline1"></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="card">
                    <a href="{{ route('collection.claim.approved') }}">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                        <i class='fas fa-users'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="font-size-15 mb-0 text-truncate">Approved EFT Return </h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-1">
                                <div>
                                    <center><h4 class="font-size-50 center">{{$dueEftReturnCount}}</h4></center>
                                    <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                </div>
                                <div>
                                    <div id="chart-sparkline1"></div>
                                </div>
                            </div>
                        </div>
                    </a>    
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="card">
                    <a href="{{ route('collection.eft.underprocess') }}">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                        <i class='fas fa-users'></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="font-size-14 mb-0 text-truncate">Under Processing EFT Return</h6>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-1">
                                <div>
                                    <center><h4 class="font-size-50 center">{{$underProcessEftReturnCount}}</h4></center>
                                    <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                                </div>
                                <div>
                                    <div id="chart-sparkline1"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <a href="{{route('collection.report')}}">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="avatar-sm">
                            <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                <i class='fas fa-users'></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="font-size-15 mb-0 text-truncate">Total Payment Of Return EFT</h5>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3 pt-1">
                        <div>
                            <center><h4 class="font-size-50 center">{{$totalEftReturnCount}}</h4></center>
                            <p class="mb-0 text-success fw-semibold font-size-15">current year <i class="bx bx-trending-up align-middle font-size-18"></i></p>
                        </div>
                        <div>
                            <div id="chart-sparkline1"></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

@endhasanyrole
<!-- end row -->
@endsection

@push('custom_scripts')
<script src="{{asset('backend')}}/libs/select2/js/select2.min.js"></script>
<script src="{{asset('backend')}}/js/pages/form-advanced.init.js"></script>
<!--Quill js-->
<script src="{{asset('backend')}}/libs/quill/quill.min.js"></script>
<script src="{{asset('backend')}}/libs/flatpickr/flatpickr.min.js"></script>
@endpush
