@extends('layouts.admin.admin_master', ['title'=>'Organizations'])

@push('custom_styles')
    <style>
        .form-group{
            margin-top: 5px;
        }
    </style>
    <!-- DataTables -->
    <link href="{{asset('backend')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
@include('messages')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="pull-left">Organization List</span>
                <a href="{{route('organization.create_form')}}">
                    <button type="button" class="pull-right btn btn-sm btn-success waves-effect waves-light">Add Organization</button>
                </a>
            </div>

            <div class="card-body">
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Contract Date</th>
                        <th>Commencement Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>


                <tbody>
                @forelse($organizations as $organization)
                    <tr>
                        <td>{{ $organization->code }}</td>
                        <td>{{ $organization->name }}</td>
                        <td>{{ $organization->phone }}</td>
                        <td>{{ $organization->email }}</td>
                        <td>{{ $organization->contract_date }}</td>
                        <td>{{ $organization->commencement_date }}</td>
                        <td>
                            @if ($organization->is_active) 
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <span data-obj="{{$organization}}" class="badge bg-info  organization-update-btn" style="cursor: pointer;">
                                <b>Update</b>
                            </span>
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


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="organization-update-modal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="card border border-seconday mb-0">
            <div class="card-header bg-transparent border-success">
                <h5 class="my-0 text-success text-truncate">Update Organization</h5>
            </div>
            <div class="card-body">
                @include('admin.organizations.update_form')
            </div>
        </div>
    </div>
  </div>
</div>

@endsection

@push('custom_scripts')
<script src="{{asset('backend')}}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('backend')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="{{asset('backend')}}/js/pages/datatables.init.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.organization-update-btn', function () {
            let orgObj = $(this).data('obj');
            let id = orgObj.id;
            let updateUrl = '{{route("organization.update",":id")}}';
            updateUrl = updateUrl.replace(":id", id);


            $("#input_code").val(orgObj.code);
            $("#input_name").val(orgObj.name);
            $("#input_payable_to").val(orgObj.payable_to);
            $("#input_phone").val(orgObj.phone);
            $("#input_email").val(orgObj.email);
            $("#input_contract_date").val(orgObj.contract_date);
            $("#input_commencement_date").val(orgObj.commencement_date);
            $("#input_profit_commision").val(orgObj.profit_commision);
            $("#input_management_expenses").val(orgObj.management_expenses);
            $("#input_employer_protion").val(orgObj.employer_protion);
            $("#input_employee_protion").val(orgObj.employee_protion);
            $("#input_sold_by").val(orgObj.sold_by);
            $("#input_sold_as").val(orgObj.sold_as);
            $("#input_bank_name").val(orgObj.bank_name);
            $("#input_bank_branch_name").val(orgObj.bank_branch_name);
            $("#input_bank_branch_routing_number").val(orgObj.bank_branch_routing_number);
            $("#input_bank_account_number").val(orgObj.bank_account_number);
            $("#input_bank_account_name").val(orgObj.bank_account_name);
            $("#input_marketed_by").val(orgObj.marketed_by);
            $("#input_address").val(orgObj.address);
//


            $("#organization-update-form").attr('action', updateUrl);
            $("#organization-update-modal").modal('show');
        })

    });
</script>
@endpush
