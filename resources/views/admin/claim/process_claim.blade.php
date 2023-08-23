@extends('layouts.admin.admin_master', ['title'=>'Claim Process'])

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
    @include('messages')
    <div class="row justify-content-center">
        <form action="{{route('claims.process')}}">
        <div class="col-md-12 justify-content-center row">
            <div class="col-sm-12 col-md-5">
                <select name="organization_id" class="form-control">
                    <option value="">Select an Organization</option>
                    @foreach($organizations as $org)
                    <option value="{{$org->id}}" {{request()->organization_id == $org->id ? 'selected' : ''}} >{{$org->name}}</option>
                    @endforeach
                </select>
            </div>
            
            
            <div class="col-sm-12 col-md-3">
                <button type="submit" class="btn btn-md btn-primary">Search</button>
            </div>

            <div class="col-sm-12"><hr /></div>
        </div>
        </form>

        @if( $selectedOrganization )
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="pull-left">Claim List</span>
            </div>
            <div class="card-body">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <td>@lang('Organization Name')</td>
                            <td>@lang('Member ID')</td>
                            <td>@lang('Intimation No')</td>
                            <td>@lang('Claim Type')</td>
                            <td>@lang('Incident Date')</td>
                            <td>@lang('Claimed Amount')</td>
                            <td>@lang('Rivew')</td>
                            <td>@lang('Status')</td>
                            <td>@lang('Action')</td>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($claims as $claim)

                        <tr>
                            <td>{{$selectedOrganization->name}}</td>
                            <td>{{$claim->member_id}}</td>
                            <td>{{$claim->intimation_number}}</td>
                            <td>{{$claim->claim_type}}</td>
                            <td>{{$claim->incident_date}}</td>
                            <td>{{$claim->claimed_amount}} TK</td>
                            <td><span class="badge bg-warning">{{$claim->doctor_remarks?? 'No Rivew'}}</span></td>
                            <td><span class="badge bg-danger">{{$claim->claimsStatus->name}}</span></td>
                            <td>
                                <a href="{{route('claims.process_create', ['id' => $claim->id])}}">
                                    <span  class="badge bg-info  member-update-btn" style="cursor: pointer;">
                                        <b>Process</b>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @empty   
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="member-update-model">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">@lang('Member Information')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @include('admin.claim.intimate_form')
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
        $(document).on('click', '.member-update-btn', function () {
            let memberObj = $(this).data('obj');
            let id = memberObj.id;
            let updateUrl = '{{route("organization.members.update",":id")}}';
            updateUrl = updateUrl.replace(":id", id);


            $("#select_org_name").val(memberObj.org_id);
            $("#input_employee_name").val(memberObj.name);
            $("#input-member-department").val(memberObj.department);
            $("#input-member-designation").val(memberObj.designation);
            $("#input-member_id").val(memberObj.member_id);
            $("#input-emp_id").val(memberObj.emp_id);
            $("#input-employee-nid").val(memberObj.nid_number);
            $("#input-employee-dob").val(memberObj.date_of_birth);
            $("#input-membership-date").val(memberObj.membership_date);
            $("#select-employee-gender").val(memberObj.sex);
            $("#select-employee-maritial-status").val(memberObj.maritial_status);
            $("#input-employee-mobile").val(memberObj.mobile);
            $("#input-employee-email").val(memberObj.email);
            $("#input-employee-salary").val(memberObj.salary);
            $("#input-employee-sum_at_risk").val(memberObj.sum_at_risk);
            $("#input-employee-bank-account-name").val(memberObj.bank_name);
            $("#input-bank-branch-name").val(memberObj.bank_branch_name);
            $("#input-bank-branch-routing-number").val(memberObj.bank_branch_routing_number);
            $("#input-bank-account-number").val(memberObj.bank_account_number);
            $("#member-update-form").attr('action', updateUrl);
            $("#member-update-model").modal('show');
        })

    });
</script>
@endpush
