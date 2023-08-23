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
                    <form action="{{ isset($formSubmissionUrl) ? $formSubmissionUrl : route('collection.report') }}"id="payment-form"
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
                                    <label for="">Intimation No</label>
                                    <input type="text" name="intimation_number" value="{{ $request['intimation_number'] ?? '' }}"
                                        placeholder="Intimation No" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label for="">Return Type</label>
                                <select name="returnType" class="form-control">
                                    <option value="Without EFT Return" {{request()->returnType == 'Without EFT Return' ? 'selected' : 'Without EFT Return'}}> Without EFT Return</option>
                                    <option value="With EFT Return"{{request()->returnType == 'With EFT Return' ? 'selected' :'without EFT Return'}} > With EFT Return</option></option>
                                    <option value=""{{request()->returnType == '' ? 'selected' : 'Without EFT Return'}}>All</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <label for="">Select Claim Type</label>
                                <select name="claim_type" class="form-control">
                                    <option value="Withdrawal with plan A"{{request()->claim_type == 'Withdrawal with plan A' ? 'selected' : ''}} >Withdrawal with plan A</option>
                                    <option value="Death"{{request()->claim_type == 'Death' ? 'selected' : ''}} >Death</option>
                                    <option value=""{{request()->claim_type == '' ? 'selected' : ''}}>All</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label for="">Payment Type</label>
                                <select name="paymentType" class="form-control">
                                    <option value="FT" {{request()->paymentType == 'FT' ? 'selected' : 'FT'}}>FT</option>
                                    <option value="EFT"{{request()->paymentType == 'EFT' ? 'selected' : 'FT'}} >EFT</option></option>
                                    <option value=""{{request()->paymentType == '' ? 'selected' : 'FT'}}>All</option>
                                </select>
                            </div>
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
                                <button type="submit" name="submit" value="download_xcel"
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
                            <td>@lang('Intimation No')</td>
                            <td>@lang('Claim Type')</td>
                            <td>@lang('Paid Amount')</td>
                            <td>@lang('Bank Name')</td>
                            <td>@lang('Account No')</td>
                            <td>@lang('routing No')</td>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($claims as $key=> $claim)
                        <tr>
                            <td>{{$claim->organization->name}}</td>
                            <td>{{$claim->intimation_number}}</td>
                            <td>{{$claim->claim_type}}</td>
                            <td>{{$claim->paid_amount}} TK</td>
                            <td>{{$claim->member->bank_name}}</td>
                            <td>{{$claim->member->bank_account_number}}</td>
                            <td>{{$claim->member->bank_branch_routing_number}}</td>
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

