
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            .form-group{
                margin-bottom: 10px;
            }
            .required-label::after {
                content: " *";
                color: red;
            }
        </style>
    </head>
    <body style="margin-top:110px;">
        <div style="margin-bottom:40px;">
            <span class="pull-left"><b>Ref: GLIL/HO/F&A/{{$advise_no}}</b></span>
            <p>Date:{{now()->format('d-m-Y')}}</p>
        </div>
        <div>
            The Manager<br>
            {{$payment_method->bank_name}}<br>
            {{$payment_method->branch}}<br>
            107 Motijheel C/A, Dhaka-1000<br>
        </div>
        <div style="margin-top:30px;">
            <p>Dear Sir,</p>
            <p>We would like to request you to transfer the amount of Tk.{{$total}} /= (Taka In Word: {{ ucfirst(strtolower($total_in_word)) }} Only.) as
                per attached sheet by debiting our bank a/c number: SND# {{$payment_method->account_no}} which is maintained with your branch.</p>
        </div>
        <div style="margin-top:80px;margin-bottom:30px;">
            <table style="border: 1px solid black;" id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <td style="border: 1px solid black;">@lang('Transfer from')</td>
                        <td style="border: 1px solid black;">@lang('Transfer to')</td>
                        <td style="border: 1px solid black;">@lang('Amount (Taka)')</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid black;">{{$payment_method->account_no}}</td>
                        <td style="border: 1px solid black;">As per attached sheet.</td>
                        <td style="border: 1px solid black;">{{$total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p><b>Taka In Word: {{ ucfirst(strtolower($total_in_word)) }} Only.</b></p>
        <div>
            Your early action and confirmation to the above will be appreciated.<br>
            Your faithfully,<br>
        </div>
        <div class="row"style="margin-top:150px;margin-bottom:60px;">
            <pre>
                <u>Authorized Signature</u>                    <u>Authorized Signature</u>
            </pre> 
        </div><br><br>
        <div>
            <h5>Advice Sheet for transferring the amount of taka showing below:</p>
                <table style="border: 1px solid black;"id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead style="border: 1px solid black;">
                        <tr >
                            <td style="border: 1px solid black;">@lang('Organization')</td>
                            <td style="border: 1px solid black;">@lang('Claim Payable To')</td>
                            <td style="border: 1px solid black;">@lang('Intimation No')</td>
                            <td style="border: 1px solid black;">@lang('Claim Type')</td>
                            <td style="border: 1px solid black;">@lang('Bank Name')</td>
                            <td style="border: 1px solid black;">@lang('Account No')</td>
                            <td style="border: 1px solid black;">@lang('routing No')</td>
                            <td style="border: 1px solid black;">@lang('Claimed Amount')</td>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($adviseInfo as $key=> $info)
                        <tr>
                            <td style="border: 1px solid black;">{{$info->organization->name}}</td>
                            <td style="border: 1px solid black;">{{$info->member->name}}</td>
                            <td style="border: 1px solid black;">{{$info->intimation_number}}</td>
                            <td style="border: 1px solid black;">{{$info->claim->claim_type}}</td>
                            <td style="border: 1px solid black;">{{$info->member->bank_name}}</td>
                            <td style="border: 1px solid black;">{{$info->member->bank_account_number}}</td>
                            <td style="border: 1px solid black;">{{$info->member->bank_branch_routing_number}}</td>
                            <td style="border: 1px solid black;">{{$info->claim->claimed_amount}}</td>
                        </tr>
                    @empty   
                    @endforelse
                    </tbody>
                </table>
        </div>

        <div class="row"style="margin-top:10px;">
            <p class="float-right"><b>Total Amount: {{ $total }} TK Only</b></p>
        </div>
        <div class="row"style="margin-top:150px;">
             <pre>
                <u>Authorized Signature</u>                    <u>Authorized Signature</u>
            </pre>        
        </div>
    </body>
    </html>


