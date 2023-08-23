@extends('layouts.admin.admin_master', ['title' => 'Create New User'])

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
                    <span class="pull-left">User Create Form</span>

                </div>
                <div class="card-body">
                    @include('messages')
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        placeholder="Enter name" value="{{ old('name') }}" required>
                                    {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="email"
                                        class="form-control @error('email') is-invalid @enderror" id="email"
                                        placeholder="Enter email address" value="{{ old('email') }}" required>
                                    {!! $errors->first('email', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        placeholder="Enter password" required>
                                    {!! $errors->first('password', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" placeholder="Enter confirm password" required>
                                    {!! $errors->first('password_confirmation', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile No.</label>
                                    <input type="text" name="mobile"
                                        class="form-control @error('mobile') is-invalid @enderror" id="mobile"
                                        placeholder="Enter mobile" value="{{ old('mobile') }}">
                                    {!! $errors->first('mobile', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="mb-3">
                                    <label for="staff_id" class="form-label">Staff ID</label>
                                    <input type="text" name="staff_id"
                                        class="form-control @error('staff_id') is-invalid @enderror" id="staff_id"
                                        placeholder="Enter staff ID" value="{{ old('staff_id') }}">
                                    {!! $errors->first('staff_id', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                            </div>

                            <div class="col-lg-5">

                                <div class="mb-3">
                                    <label for="roles" class="form-label">Role<span class="text-danger">*</span></label>
                                    <select id="roles" name="roles[]" multiple
                                        class="form-control select2 @error('roles.*') is-invalid @enderror"
                                        style="width:100%" required>
                                        @php
                                            $roles = Spatie\Permission\Models\Role::where('id', '!=', 1)->get();
                                        @endphp
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ collect(old('roles'))->contains($role->id) ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('roles.*', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="mb-3">
                                    <label id="status1" class="form-label">Status</label>
                                    <select name="status" style="width:100%" id="status1"
                                        class="form-control select2 @error('status') is-invalid @enderror">
                                        <option value="1">Enable</option>
                                        <option value="0">Disable
                                        </option>
                                    </select>
                                    {!! $errors->first('status', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="mb-0 mb-md-3">
                                    <label for="avatar" class="form-label">Photo</label>
                                    <input class="form-control form-control-lg @error('avatar') is-invalid @enderror"
                                        name="avatar" onchange="get_photo(event)" id="avatar" type="file">
                                    {!! $errors->first('avatar', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="mb-0 mb-md-3">
                                    <img id="avatar_output" style="width: 40% !important" src="" alt="photo"
                                        class="img-thumbnail">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <hr>
                            </div>

                            <div class="col-12">
                                <button type="reset" class="btn btn-warning waves-effect waves-light">Clear</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Create This
                                    User</button>
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

    <script>
        const get_photo = (e) => {
            const avatar = URL.createObjectURL(e.target.files[0]);
            $("#" + e.target.id + "_output").attr("src", avatar);
        }
    </script>
    @if ($errors->any())
        <script>
            const status = "{{ old('status') }}";
            $("#status1").val(status);
        </script>
    @endif
@endpush
