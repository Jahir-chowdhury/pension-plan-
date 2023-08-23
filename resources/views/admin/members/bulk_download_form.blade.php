@extends('layouts.admin.admin_master', ['title' => 'Bulk Download'])

@push('custom_styles')
    <style>
        .form-group {
            margin-top: 5px;
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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="pull-left">Organization List</span>
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
                                        <a href="{{ route('organization.members.export', ['id' => $organization->id]) }}">
                                            <span data-obj="{{ $organization }}"
                                                class="badge bg-info  organization-update-btn" style="cursor: pointer;">
                                                <b>Download</b>
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
        </div>
    </div>
@endsection

@push('custom_scripts')
    <script src="{{ asset('backend') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('backend') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="{{ asset('backend') }}/js/pages/datatables.init.js"></script>
@endpush
