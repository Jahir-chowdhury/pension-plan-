@extends('layouts.admin.admin_master', ['title'=>'Payment Methods'])

@push('custom_styles')
    <!-- DataTables -->
    <link href="{{asset('backend')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Select datatable -->
    <link href="{{asset('backend')}}/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable -->
    <link href="{{asset('backend')}}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
@include('messages')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"> 
                    <span class="pull-left">Payment Methods</span>    
                    <button class="btn btn-sm btn-primary pull-right" id="add-payment-method-btn">@lang('Add payment Method')</button>
                </h4>

                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>Sl.</th>
                        <th>@lang('Method Name')</th>
                        <th>@lang('Bank Name')</th>
                        <th>@lang('Accout No')</th>
                        <th>@lang('Branch')</th>
                        <th>@lang('Routing No')</th>
                        <th>@lang('Active Status')</th>
                        <th>@lang('Transaction No')</th>
                        <th>@lang('Address')</th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach($paymentMethods as $paymentMethod)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$paymentMethod->method_name}}</td>
                        <td>{{$paymentMethod->bank_name}}</td>
                        <td>{{$paymentMethod->account_no}}</td>
                        <td>{{$paymentMethod->branch}}</td>
                        <td>{{$paymentMethod->branch_routing_no}}</td>
                        <td>
                            @if($paymentMethod->active_status)
                                <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-warning">Inactive</span>
                            @endif
                        </td>
                        <td>
                          @if($paymentMethod->transaction_id_required)
                              <span class="badge bg-success">Yes</span>
                          @else
                              <span class="badge bg-warning">No</span>
                          @endif
                      </td>
                        <td>
                          {{$paymentMethod->address}}
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary payment-method-update-btn" data-obj="{{$paymentMethod}}">Update</button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <!-- end card-body -->
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div> <!-- end row -->

<!-- Payment method ADD modal -->
<div class="modal fade" id="paymentMethodAddModal" tabindex="-1" aria-labelledby="paymentMethodAddModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentMethodAddModalLabel">Add Payment Method</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('setting.payment-methods.store')}}" method="POST" id="paymentMethodAddForm">
          @csrf
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Method Name')</label>
            <input type="text" class="form-control" name="method_name">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Bank Name')</label>
            <input type="text" class="form-control" name="bank_name">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Account No')</label>
            <input type="text" class="form-control" name="account_no">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Branch Name')</label>
            <input type="text" class="form-control" name="branch">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Routing No')</label>
            <input type="text" class="form-control" name="branch_routing_no">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Adress')</label>
            <input type="text" class="form-control" name="address">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Active Status')</label>
            <select name="active_status" class="form-control">
                <option value="{{App\Enums::PAYMENT_METHOD_STATUSES['ACTIVE']}}">Active</option>
                <option value="{{App\Enums::PAYMENT_METHOD_STATUSES['INACTIVE']}}">InActive</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Transaction Id Required')</label>
            <select name="transaction_id_required" class="form-control">
                <option value="{{App\Enums::PAYMENT_TRANSACTION_ID_REQUIRED['YES']}}">Yes</option>
                <option value="{{App\Enums::PAYMENT_TRANSACTION_ID_REQUIRED['NO']}}">No</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submit-btn-add-payment">@lang('Add Payment Method')</button>
      </div>
    </div>
  </div>
</div>


<!-- Payment method EDIT modal -->
<div class="modal fade" id="paymentMethodEditModal" tabindex="-1" aria-labelledby="paymentMethodAddModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentMethodAddModalLabel">Update Payment Method Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="paymentMethodEditForm">
          @csrf
          @method('PUT')
          <input type="hidden" name="payment_method_id" id="inputMethodId">
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Method Name')</label>
            <input type="text" class="form-control" name="method_name" id="editInputMethodName">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Bank Name')</label>
            <input type="text" class="form-control" name="bank_name" id="editInputBankName">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Account No')</label>
            <input type="text" class="form-control" name="account_no" id="editAccountNo">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Branch')</label>
            <input type="text" class="form-control" name="branch" id="editInputBranch">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Route No')</label>
            <input type="text" class="form-control" name="branch_routing_no" id="editInputBranchRoutingNo">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Adress')</label>
            <input type="text" class="form-control" name="address"id="editInputAdress">
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Active Status')</label>
            <select name="active_status" class="form-control" id="editInputPaymentActiveStatus">
                <option value="{{App\Enums::PAYMENT_METHOD_STATUSES['ACTIVE']}}">Active</option>
                <option value="{{App\Enums::PAYMENT_METHOD_STATUSES['INACTIVE']}}">InActive</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="" class="col-form-label">@lang('Transaction Id Required')</label>
            <select name="transaction_id_required" class="form-control" id="editInputTransactionIdRequired">
                <option value="{{App\Enums::PAYMENT_TRANSACTION_ID_REQUIRED['YES']}}">Yes</option>
                <option value="{{App\Enums::PAYMENT_TRANSACTION_ID_REQUIRED['NO']}}">No</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editPaymentMethodSubmitBtn">Save Changes</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('custom_scripts')
    <!-- Required datatable js -->
    <script src="{{asset('backend')}}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('backend')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="{{asset('backend')}}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('backend')}}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="{{asset('backend')}}/js/pages/datatables.init.js"></script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '#add-payment-method-btn', function () {
                $('#paymentMethodAddModal').modal('show');
            });

            $(document).on('click', '#submit-btn-add-payment', function () {
                $('#paymentMethodAddForm').submit();
            })

            $(document).on('click', '.payment-method-update-btn', function () {
                let obj = $(this).data('obj');
                $("#inputMethodId").val(obj.id);
                $("#editInputMethodName").val(obj.method_name);
                $("#editInputBankName").val(obj.bank_name);
                $("#editAccountNo").val(obj.account_no);
                $("#editInputBranch").val(obj.branch);
                $("#editInputBranchRoutingNo").val(obj.branch_routing_no);
                $("#editInputAdress").val(obj.address);
                $("#editInputPaymentActiveStatus").val(obj.active_status);
                $("#editInputTransactionIdRequired").val(obj.transaction_id_required);
                let id = $("#inputMethodId").val();
                let targetUrl = "{{route('setting.payment-methods.update', ':id')}}";
                targetUrl = targetUrl.replace(":id", id);
                $("#paymentMethodEditForm").attr('action', targetUrl);

                $("#paymentMethodEditModal").modal('show');
            })

            $(document).on('click', '#editPaymentMethodSubmitBtn', function (){
                
                $("#paymentMethodEditForm").submit();
            })
        });
    </script>
@endpush
