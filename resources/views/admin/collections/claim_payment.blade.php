@extends('layouts.admin.admin_master', ['title'=>'Claim Payments'])

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
    <link href="{{asset('backend')}}/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{asset('backend')}}/libs/%40chenfengyuan/datepicker/datepicker.min.css" type="text/css">
    <link href="{{asset('backend')}}/libs/%40chenfengyuan/datepicker/datepicker.min.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
<form action="{{route('collection.claim_payment.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="pull-left">@lang('Claim payment form')</span>
                </div>
                <div class="card-body">
                    @include('messages')

                    <form action="" action="" method="POST"> 
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Organization Name</label>
                            <input class="form-control" name="organization_id" type="text" value="{{$organization->name}}" disabled>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Member Name</label>
                            <input class="form-control" name="organization_id" type="text" value="{{$claim->member->name}}" disabled>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Intimation No</label>
                            <input class="form-control" name="intimation_number" type="text" value="{{$claim->intimation_number}}"readonly>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Bank Name</label>
                            <input class="form-control" name="bank_name" type="text" value="{{$claim->member->bank_name}}"readonly>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Bank Account No</label>
                            <input class="form-control" name="bank_account_number" type="text" value="{{$claim->member->bank_account_number}}"readonly>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Branch Name</label>
                            <input class="form-control" name="bank_branch_name" type="text" value="{{$claim->member->bank_branch_name}}"readonly>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Bank Routing No</label>
                            <input class="form-control" name="bank_branch_routing_number" type="text" value="{{$claim->member->bank_branch_routing_number}}"readonly>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Payment Date</label>
                            <input class="form-control" name="payment_date" type="date" value="<?= date('Y-m-d') ?>"readonly >
                        </div>

                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Settled Amount</label>
                            <input class="form-control" name="settled_amount" type="number"value="{{$claim->claimed_amount}}"  readonly>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Advise OR Check No <span class="text text-danger text-bold" style="font-weight-bold" id="short-amount-message"></span></label>
                            <input class="form-control" name="advise" type="text" required>
                        </div>

                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Payment Chanel</label>
                            <select name="payment_chanel" class="form-control" required>
                                <option value="BFTIN">BFTIN</option>
                                <option value="BKASH">BKASH</option>
                                <option value="CHECK">CHECK</option>
                            </select>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="">Select one</option>
                                @foreach($paymentMethods as $p_method)
                                <option value="{{$p_method->id}}" data-trx-required="{{$p_method->transaction_id_required}}">{{$p_method->method_name}}-{{$p_method->bank_name}}-{{$p_method->account_no}}-{{$p_method->branch}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Remarks  <span class="text text-danger text-bold" style="font-weight-bold" id="short-amount-message"></span></label>
                            <input class="form-control" name="remarks" type="text" >
                        </div>

                    </div>

                    <div class="row">
                        <div class="mb-3 col-sm-12 col-md-4">
                            <button class="btn btn-primary" type="submit" name="submit" value="submit">Submit</button>
                        </div>
                    </div>

                    </form>
                </div>
                
                
            </div>
        </div>
    </div>
</form>
@endsection


