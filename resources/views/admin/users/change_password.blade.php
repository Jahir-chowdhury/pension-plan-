@extends('layouts.admin.admin_master', ['title' => 'Change Password'])

@push('custom_styles')
    <style>
        .form-group {
            margin-top: 5px;
        }
    </style>
    <link href="{{ asset('backend') }}/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('backend') }}/libs/%40chenfengyuan/datepicker/datepicker.min.css" type="text/css">
    <link href="{{ asset('backend') }}/libs/%40chenfengyuan/datepicker/datepicker.min.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="pull-left">Change Password</span>

                </div>
                <div class="card-body">
                    @include('messages')
                    <form method="POST" action="{{ route('user.update.password', $id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        id="current_password" placeholder="Enter current password" required>
                                    {!! $errors->first('current_password', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="new_password"
                                        class="form-control @error('new_password') is-invalid @enderror" id="new_password"
                                        placeholder="Enter new password" required>
                                    {!! $errors->first('new_password', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" placeholder="Enter confirm password" required>
                                    {!! $errors->first('password_confirmation', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <hr>
                            </div>

                            <div class="col-12">
                                <button type="reset" class="btn btn-warning waves-effect waves-light">Clear</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Change
                                    Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_scripts')
    <script src="{{ asset('backend') }}/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('backend') }}/js/pages/form-advanced.init.js"></script>
    <!--Quill js-->
    <script src="{{ asset('backend') }}/libs/quill/quill.min.js"></script>
    <script src="{{ asset('backend') }}/libs/flatpickr/flatpickr.min.js"></script>
@endpush
