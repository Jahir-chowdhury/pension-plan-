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
    <h5 class="mb-3"><strong>Search by intimation number to return an EFT. </strong></h5>
    <div class="row p-3">
        @include('messages')
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-hear">
                    Search by intimation no.
                </div>
                <div class="card-body">
                    <form action="{{ isset($formSubmissionUrl) ? $formSubmissionUrl : route('collection.eft.return') }}"id="payment-form"
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
    @if(!empty($return_eft))
    <form action="{{route('collection.eft.return')}}" method="get" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Organization Name</label>
                    <input class="form-control" name="organizatio" type="text" value="{{$return_eft->organization->name}}" disabled>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Member Name</label>
                    <input class="form-control" name="member" type="text" value="{{$return_eft->member->name}}" disabled>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Intimation No</label>
                    <input class="form-control" name="intimation_number" type="text" value="{{$return_eft->claim->intimation_number}}"readonly>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Bank Account No</label>
                    <input class="form-control" name="bank_account_number" type="text" value="{{$return_eft->member->bank_account_number}}"readonly>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Branch Name</label>
                    <input class="form-control" name="bank_branch_name" type="text" value="{{$return_eft->member->bank_branch_name}}"readonly>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Bank Routing No</label>
                    <input class="form-control" name="bank_branch_routing_number" type="text" value="{{$return_eft->member->bank_branch_routing_number}}"readonly>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Settled Amount</label>
                    <input class="form-control" name="settled_amount" type="number"value="{{$return_eft->claim->claimed_amount}}"  readonly>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Advise OR Check No <span class="text text-danger text-bold" style="font-weight-bold" id="short-amount-message"></span></label>
                    <input class="form-control" name="advise" type="text"value="{{$return_eft->advise_no}}" readonly>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Remarks  <span class="text text-danger text-bold" style="font-weight-bold" id="short-amount-message"></span></label>
                    <input class="form-control" name="remarks" type="text" required>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-sm-12 col-md-4">
                    <button class="btn btn-primary" type="submit" name="submit" value="cancel">Cancel</button>
                </div>
            </div>                    
        </form>
    @endif

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

