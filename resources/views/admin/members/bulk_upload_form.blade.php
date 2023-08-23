@extends('layouts.admin.admin_master', ['title' => 'Members - Bulk upload form'])

@push('custom_styles')
    <style>
        .form-group {
            margin-bottom: 10px;
        }

        .required-label::after {
            content: " *";
            color: red;
        }

        #employee_datas_table td,
        #employee_datas_table th {
            padding: 3px;
        }
    </style>
    <!-- DataTables -->
    <link href="{{ asset('backend') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend') }}/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
@endpush

@section('content')
    @include('messages')
    <form action="{{ route('organization.members.bulkUploadFieldmapping') }}" method="POST" enctype="multipart/form-data"
        id="bulk-upload-form">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <div class="form-group">
                    <label for="">@lang('Select organization')</label>
                    <select name="organization" id="select_organization" class="form-control">
                        <option value="">Select an Organization</option>
                        @foreach ($organizations as $index => $organization)
                            <option value="{{ $organization->id }}">{{ $organization->name }} - {{ $organization->phone }} -
                                {{ $organization->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">@lang('Select file') <small class="text-danger">(Ex : .xlsx, .csv)</small> </label>
                    <input type="file" name="member_list_file" id="input_member_list_file" class="form-control">
                </div>
                <div class="form-group">
                    <button type="button" id="mapping-btn" class="btn btn-success">Mapping the field</button>
                </div>
            </div>
        </div>
    </form>

    <div class="row justify-content-center">
        @if (isset($excelRows))
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('organization.members.bulkUpload') }}" method="POST">
                        <input type="hidden" name="organization_id" value="{{ $organizationId }}">
                        <div class="card-body" style="overflow-x:auto;">
                            @csrf
                            <table id="scroll-vertical-datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Maritial Status</th>
                                        <th>Salary</th>
                                        <th>Bank Name</th>
                                        <th>Bank Branch Name</th>
                                        <th>Routing Number</th>
                                        <th>Account Number</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>NID Number</th>
                                    </tr>
                                </thead>

                                <tbody class="overflow-hidden" style="height: 200px;">
                                    @foreach ($excelRows as $row)
                                        <tr>
                                            <td><input type="text" value="{{ $row['employee_id'] }}"
                                                    name="employee_id[]"></td>
                                            <td><input type="text" value="{{ $row['employee_name'] }}"
                                                    name="employee_names[]"></td>
                                            <td><input type="text" value="{{ $row['department'] }}"
                                                    name="departments[]"></td>
                                            <td><input type="text" value="{{ $row['designation'] }}"
                                                    name="designations[]"></td>
                                            <td><input type="date" name="date_of_births[]"
                                                    value="{{ \Carbon\Carbon::parse($row['date_of_birth'])->format('Y-m-d') }}">
                                            </td>
                                            <td><input type="text" value="{{ $row['gender'] }}" name="genders[]"></td>
                                            <td><input type="text" value="{{ $row['maritial_status'] }}"
                                                    name="maritial_statuses[]"></td>
                                            <td><input type="text" value="{{ $row['salary'] }}" name="salaries[]"></td>
                                            <td><input type="text" value="{{ $row['employee_bank_name'] }}"
                                                    name="bank_names[]"></td>
                                            <td><input type="text" value="{{ $row['bank_branch_name'] }}"
                                                    name="bank_branch_names[]"></td>
                                            <td><input type="text" value="{{ $row['bank_routing_number'] }}"
                                                    name="bank_routing_numbers[]"></td>
                                            <td><input type="text" value="{{ $row['bank_account_number'] }}"
                                                    name="bank_account_numbers[]"></td>
                                            <td><input type="text" value="{{ $row['mobile'] }}" name="mobiles[]"></td>
                                            <td><input type="text" value="{{ $row['email'] }}" name="emails[]"></td>
                                            <td><input type="text" value="{{ $row['nid_number'] }}"
                                                    name="nid_numbers[]"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12 card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success">Import Members</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        @endif
    </div>

@endsection

@push('custom_scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#mapping-btn', function(e) {
                e.preventDefault();
                let form = $("#bulk-upload-form");
                form.submit();
                // let formData = new FormData();
                // formData.append('_token', "{{ csrf_token() }}");
                // formData.append('organization', $("#select_organization").val());
                // formData.append('member_list_file', $("#input_member_list_file").val());
                // console.log(formData);

                // $.ajax({
                //     url: "{{ route('organization.members.bulkUploadFieldmapping') }}",
                //     data: formData,
                //     processData: false,
                //     contentType: false,
                //     type: 'POST',
                //     success: function(data){
                //         alert(data);
                //     }
                // });
            });
        });
    </script>
    <script src="{{ asset('backend') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('backend') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="{{ asset('backend') }}/js/pages/datatables.init.js"></script>
@endpush
