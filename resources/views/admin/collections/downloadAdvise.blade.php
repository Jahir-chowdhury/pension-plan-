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
    <h5 class="mb-3"><strong>Search Advise </strong></h5>
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
                    <form action="{{ isset($formSubmissionUrl) ? $formSubmissionUrl : route('collection.advise.download') }}"id="payment-form"
                        method="get">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <label for="">Advise No Or Check No</label>
                                    <input type="text" name="advise_no" value="{{$advise_no??''}}"
                                        placeholder="Advise No" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-sm">Search</button>
                                <button type="submit" name="submit" value="download_xcel"
                                class="btn btn-success btn-sm">Download As Excel</button>
                                <button type="submit" name="submit" value="download_pdf"
                                class="btn btn-success btn-sm">Download As Pdf</button>
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
                <span class="pull-left"><b>Advise No:{{$advise_no}}</b></span>
            </div>
            <div class="card-body">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <td>@lang('Organization')</td>
                            <td>@lang('Name')</td>
                            <td>@lang('Intimation No')</td>
                            <td>@lang('Claim Type')</td>
                            <td>@lang('Claimed Amount')</td>
                            <td>@lang('Bank Name')</td>
                            <td>@lang('Account No')</td>
                            <td>@lang('routing No')</td>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($adviseInfo as $key=> $info)
                        <tr>
                            <td>{{$info->organization->name}}</td>
                            <td>{{$info->member->name}}</td>
                            <td>{{$info->intimation_number}}</td>
                            <td>{{$info->claim->claim_type}}</td>
                            <td>{{$info->claim->claimed_amount}} TK</td>
                            <td>{{$info->member->bank_name}}</td>
                            <td>{{$info->member->bank_account_number}}</td>
                            <td>{{$info->member->bank_branch_routing_number}}</td>
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

