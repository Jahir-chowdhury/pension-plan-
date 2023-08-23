@push('custom_styles')
    <!-- DataTables -->
    <link href="{{asset('backend')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable -->
    <link href="{{asset('backend')}}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

@push('custom_scripts')
    <!-- Required datatable js -->
    <script src="{{asset('backend')}}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('backend')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('backend')}}/js/pages/datatables.init.js"></script>
    <!-- Buttons examples -->
    <script src="{{asset('backend')}}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{asset('backend')}}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="{{asset('backend')}}/libs/jszip/jszip.min.js"></script>
        <script src="{{asset('backend')}}/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="{{asset('backend')}}/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="{{asset('backend')}}/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="{{asset('backend')}}/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="{{asset('backend')}}/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
@endpush