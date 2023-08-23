@extends('layouts.admin.admin_master', ['title'=>'Collection - add'])

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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="pull-left">@lang('Add collection form')</span>
                </div>
                <div class="card-body">
                    @include('messages')

                    <form action="" action="" method="POST"> 
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Select Organization</label>
                            <select name="organization" id="field_organization" class="form-control" required>
                                <option value="">Select an Organization</option>
                                @foreach($organizations as $org)
                                    <option value="{{$org->id}}">{{$org->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Payment Date</label>
                            <input class="form-control" name="payment_date" type="date" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Due Amount</label>
                            <input class="form-control" name="due_amount" type="number" disabled required>
                        </div>

                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Amount <span class="text text-danger text-bold" style="font-weight-bold" id="short-amount-message"></span></label>
                            <input class="form-control" name="amount" type="number" required>
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
                            <label for="" class="form-label">Transaction No</label>
                            <input class="form-control" name="transaction_no" type="text" >
                        </div>

                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Suspense</label>
                            <input class="form-control" name="suspense" type="number" value="0">
                        </div>

                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">New Suspence</label>
                            <input class="form-control" name="new_suspense" type="number" value="0">
                        </div>

                        <div class="mb-3 col-sm-12 col-md-4">
                            <label for="" class="form-label">Member Coverage</label>
                            <input class="form-control" name="member_coverage" type="number" value="0" disabled required>
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
@endsection

@push('custom_scripts')

<script>
    $(document).ready(function () {

        // After selecting organization 
        $(document).on('change', '#field_organization', function () {    
            let orgId = $(this).val() ?? null;
            if (orgId == null)  return 0;

            let targetUrl = "{{route('collection.collectionOrganizationDetails', ':id')}}".replace(':id', orgId);
            
            $.ajax({
                url: targetUrl,
                method: 'GET',
                success: function (response) {
                    let data = response;
                    $("input[name=due_amount]").val(data.due_premium);
                    $("input[name=member_coverage]").val(data.active_members);
                    if ( data.last_payment !== 0) {
                        $("input[name=suspense]").val(data.last_payment.suspence_amount);
                    } else {
                        $("input[name=suspense]").val(0);
                    }

                    console.log(data);
                }
            });
        });

        // After putting amount
        $(document).on('change', 'input[name=amount]', function () {
            if ( $('#field_organization').val() == '' ) {
                alert('Select organization first.');
                return 0;
            } else {
                let suspense = parseInt( $("input[name=suspense]").val() );
                let dueAmount = parseInt( $("input[name=due_amount]").val() );
                let amount = parseInt( $(this).val() );
                let totalPayment = parseInt( amount + suspense );
                let newSuspense = totalPayment - dueAmount;
                newSuspense = newSuspense > 0 ? newSuspense : 0;
                $("input[name=new_suspense]").val(newSuspense);

                if ( totalPayment < dueAmount ) {
                    let shortAmount = dueAmount - totalPayment;
                    $("#short-amount-message").text(" *("+shortAmount+" Tk short.)");
                    $("button[name=submit]").attr('disabled', true);
                } else {
                    $("#short-amount-message").text("");
                    $("button[name=submit]").attr('disabled', false);
                }

            }

        })

        // After selecting payment method
        $(document).on('change', "select[name=payment-method]", function () {
            let isTrxRequired = $(this).find("option:selected").data('trx-required');
            if ( isTrxRequired == 1 ) {
                $("input[name=transaction_id]").attr('disabled', false).attr('required', true);
            } else {
                $("input[name=transaction_id]").attr('disabled', true).attr('required', false);
            }
        });


    });
</script>


<script src="{{asset('backend')}}/js/pages/form-advanced.init.js"></script>
<script src="{{asset('backend')}}/libs/select2/js/select2.min.js"></script>

<!--Quill js-->
<script src="{{asset('backend')}}/libs/quill/quill.min.js"></script>
<script src="{{asset('backend')}}/libs/flatpickr/flatpickr.min.js"></script>
@endpush

