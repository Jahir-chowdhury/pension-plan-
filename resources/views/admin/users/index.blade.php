@extends('layouts.admin.admin_master', ['title' => 'Users'])

@push('custom_styles')
    <style>
        .form-group {
            margin-top: 5px;
        }
    </style>
    <link href="{{ asset('backend') }}/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('backend') }}/libs/%40chenfengyuan/datepicker/datepicker.min.css" type="text/css">
    <link href="{{ asset('backend') }}/libs/%40chenfengyuan/datepicker/datepicker.min.css" rel="stylesheet" type="text/css">
    <style>
        .avatar-xl {
            height: 2.5rem;
            width: 2.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="pull-left">@lang('User Lists')</span>
                </div>
                <div class="card-body">
                    @include('messages')

                    <table class="table table-bordered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Status</th>
                                <th>action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($users as $user)
                                <tr class="text-center">
                                    <td>{{ __('#' . $user->staff_id) }}</td>
                                    <td>
                                        <div class="text-center">
                                            <img src="{{ parse_url($user->avatar, PHP_URL_SCHEME) == 'https' || parse_url($user->avatar, PHP_URL_SCHEME) == 'http'
                                                ? $user->avatar
                                                : Storage::url($user->avatar) }}"
                                                alt="avatar-4" class="avatar-xl img-thumbnail rounded-circle">
                                            <h4 class="text-primary" style="font-size: 16px !important;">
                                                {{ $user->name }}</h4>
                                            <h5 class="text-muted font-size-13">
                                                {{ implode(', ', $user->roles->pluck('name')->toArray()) }}</h5>

                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>
                                        @if ($user->status)
                                            <a class="btn btn-danger" onclick="return confirm('Are you sure desable this?')"
                                                href="{{ route('user.status', $user->id) }}"
                                                class="btn btn-info">Disable</a>
                                        @else
                                            <a class="btn btn-success" onclick="return confirm('Are you sure enable this?')"
                                                href="{{ route('user.status', $user->id) }}"
                                                class="btn btn-info">Enable</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.show', $user->id) }}" class="btn btn-info"><i
                                                class="fas fa-eye"></i></a>
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning"><i
                                                class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            {{ $users->links() }}
                        </div>
                    </div>
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
