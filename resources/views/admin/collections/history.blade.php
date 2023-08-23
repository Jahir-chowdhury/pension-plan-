@extends('layouts.admin.admin_master', ['title'=>'Collection - History'])

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
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="pull-left">@lang('Collection History')</span>
                </div>
                <div class="card-body">
                    @include('messages')
                    <form action="{{ Request::url() }}" method="GET" id="request_form">
                    <div class="row justify-content-center">
                        
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="">Organization</label>
                                <select name="org_id" class="form-control">
                                    <option value="">Select Organization</option>
                                    @foreach($organizations as $org)
                                    <option value="{{$org->id}}" {{ request()->org_id == $org->id ? 'selected' : ''}}>{{$org->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="">Year</label>
                                <select name="year" id="" class="form-control">
                                    <option value="">Select Year</option>
                                    @foreach($years as $year)
                                    <option value="{{$year}}">{{$year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="">Month</label>
                                <select name="month" id="" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach($months as $key=>$month)
                                    <option value="{{$key}}">{{$month}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="form-group">
                            <button class="btn btn-success" name="submit" type="submit">Search</button>
                        </div>
                    </div>
                    </form>
                    <hr>
                    @if( $collections != null )
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Code - Name</th>
                                        <th>Payment Method</th>
                                        <th>Amount</th>
                                        <th>Suspense</th>
                                        <th>Payment Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $collections as $collection )
                                    <tr>
                                        <td><b>{{$collection->organization->code}}</b> - {{$collection->organization->name}}</td>
                                        <td>{{$collection->paymentMethod->method_name.''.($collection->transaction_no ? ' - '.$collection->transaction_no : '') }}</td>
                                        <td><b>{{$collection->amount}}</b></td>
                                        <td>{{$collection->suspence_amount}}</td>
                                        <td>{{$collection->payment_recieved_date}}</td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div>
                        <h5 class="text-center">-No collections Available-</h5>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_scripts')

<script>
    $(document).ready(function () {
        $(document).on('change', 'select[name=org_id]', function () {
            let orgId = $(this).val();
            if ( orgId == '' ) {
            } else {
                $("#request_form").submit();
            }
        });
    });
</script>

@endpush

