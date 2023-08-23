<!doctype html>
<html lang="en">    
@include('layouts.admin.admin_header')

    <body data-sidebar="dark">
        <div id="layout-wrapper"> 
            
            @include('layouts.admin.admin_top_navbar')
            @include('layouts.admin.admin_left_sidebar')
            <div class="main-content">
                <div class="loader-wrapper">
                    <div class="loader-circle">
                        <div class="loader-wave"></div>
                    </div>
                </div>
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">{{ $title ?? '' }}</h4>
                                    {{--
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                            <li class="breadcrumb-item active">Starter Page</li>
                                        </ol>
                                    </div>
                                    --}}
                                </div>
                            </div>
                            <!--<div class="row">
                                <div class="card  form-group col-sm-12 col-md-3 shadow p-3 mb-5 bg-white rounded "style="margin-right: 60px;margin-left: 60px;">
                                    <div class="card-header">Header</div>
                                    <div class="card-body">Content</div> 
                                    <div class="card-footer">Footer</div>
                                </div>
                                <div class="card  form-group col-sm-12 col-md-3 shadow p-3 mb-5 bg-white rounded"style="margin-right: 60px;">
                                    <div class="card-body">Content</div> 
                                </div>
                                <div class="card  form-group col-sm-12 col-md-3 shadow p-3 mb-5 bg-white rounded">
                                    <div class="card-header">Header</div>
                                    <div class="card-body">Content</div> 
                                    <div class="card-footer">Footer</div>
                                </div>
                            </div>-->

                            <div class="col-12">
                                @yield('content')
                            </div>
                        </div>
                        <!-- end page title -->
                    </div><!-- container-fluid -->
                </div><!-- End Page-content -->

                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Guardian Life Insurance.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Developed by <span><a href="https://guardianlife.com.bd/en">Guardian Life Insurance</a></span> 
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>

            </div><!-- end main content-->

        </div><!-- END layout-wrapper -->
        
        @include('layouts.admin.admin_right_sidebar')
        
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{asset('backend')}}/libs/jquery/jquery.min.js"></script>
        <script src="{{asset('backend')}}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('backend')}}/libs/metismenu/metisMenu.min.js"></script>
        <script src="{{asset('backend')}}/libs/simplebar/simplebar.min.js"></script>
        <script src="{{asset('backend')}}/libs/node-waves/waves.min.js"></script>

        <!-- App js -->
        <script src="{{asset('backend/js/app.js')}}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    {{-- loading extra scripts --}}
    <script src="{{asset('backend/js/custom.js')}}"></script>
    <script>
        document.addEventListener('keypress', function (e) {
        if (e.keyCode === 13 || e.which === 13) {
            e.preventDefault();
            console.log('enter button disabled');
            return false;
        }
    });
    </script>
        @stack('custom_scripts')
    </body>
    
</html>