@extends('layouts.admin_master', ['title' => 'User List'])

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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="pull-left">User List</span>

                </div>
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>User Type</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->user_type }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile_no }}</td>
                                    <td>{{ $user->created_at->format('M d Y , h:i a') }}</td>
                                    <td>
                                        <a href="">Edit</a>
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
    <!-- Buttons examples -->
    <script src="{{ asset('backend') }}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('backend') }}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('backend') }}/libs/jszip/jszip.min.js"></script>
    <script src="{{ asset('backend') }}/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{ asset('backend') }}/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="{{ asset('backend') }}/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('backend') }}/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('backend') }}/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('backend') }}/libs/datatables.net-keyTable/js/dataTables.keyTable.min.html"></script>
    <script src="{{ asset('backend') }}/libs/datatables.net-select/js/dataTables.select.min.js"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('backend') }}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('backend') }}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('backend') }}/js/pages/datatables.init.js"></script>
@endpush
