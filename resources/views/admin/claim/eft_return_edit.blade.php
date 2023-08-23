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
    <h5 class="mb-3"><strong>Please update member information concern with remarks </strong></h5>
    <div class="row p-3">
        @include('messages')
    </div>
    <form action="{{route('claims.eft.cancel')}}" method="get" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Organization Name</label>
                    <input class="form-control" name="organizatio" type="text" value="{{$claims->organization->name}}" disabled>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Member Name</label>
                    <input class="form-control" name="member" type="text" value="{{$claims->member->name}}" disabled>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Intimation No</label>
                    <input class="form-control" name="intimation_number" type="text" value="{{$claims->claim->intimation_number}}"readonly>
                </div>


                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Settled Amount</label>
                    <input class="form-control" name="settled_amount" type="number"value="{{$claims->claim->claimed_amount}}"  readonly>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Advise OR Check No <span class="text text-danger text-bold" style="font-weight-bold"></span></label>
                    <input class="form-control" name="advise" type="text"value="{{$claims->advise_no}}" readonly>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Remarks  <span class="text text-danger text-bold" style="font-weight-bold"></span></label>
                    <input class="form-control" value="{{$claims->remarks}}"name="remarks" type="text" readonly>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Bank Name<span class="text text-danger text-bold" style="font-weight-bold"></span></label>
                    <input class="form-control" value="{{$claims->member->bank_name}}"name="bank_name" type="text"required>
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Account Number<span class="text text-danger text-bold" style="font-weight-bold" required></span></label>
                    <input class="form-control"value="{{$claims->member->bank_account_number}}" name="account_no" type="number">
                </div>
                <div class="mb-3 col-sm-12 col-md-4">
                    <label for="" class="form-label">Routing No<span class="text text-danger text-bold" style="font-weight-bold" required></span></label>
                    <input class="form-control"value="{{$claims->member->bank_branch_routing_number}}" name="routing_no" type="number">
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-sm-12 col-md-4">
                    <button class="btn btn-primary" type="submit" name="submit" value="cancel">Submit</button>
                </div>
            </div>                    
        </form>
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

