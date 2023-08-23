@extends('layouts.admin.admin_master', ['title' => 'User'])

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
                    <span class="pull-left">@lang($user->name)</span>
                </div>
                <div class="card-body">
                    @include('messages')
                    <div class="row mb-4">
                        <div class="col-xl-4">

                            <div class="card h-100">

                                <div class="card-body">
                                    <div>
                                        {{-- <div class="dropdown float-end">
                                            <a class="text-body dropdown-toggle font-size-18" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Edit</a>
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Remove</a>
                                            </div>
                                        </div> --}}
                                        <div class="clearfix"></div>

                                        <div class="text-center bg-pattern">
                                            <img src="{{ parse_url($user->avatar, PHP_URL_SCHEME) == 'https' || parse_url($user->avatar, PHP_URL_SCHEME) == 'http'
                                                ? $user->avatar
                                                : Storage::url($user->avatar) }}"
                                                alt="avatar-4" class="avatar-xl img-thumbnail rounded-circle mb-3">
                                            <h4 class="text-primary mb-2">{{ $user->name }}</h4>
                                            <h5 class="text-muted font-size-13 mb-3">
                                                {{ implode(', ', $user->roles->pluck('name')->toArray()) }}</h5>
                                            <div class="text-center">
                                                <a href="mailto:{{ $user->email }}"
                                                    class="btn btn-success me-2 waves-effect waves-light btn-sm"><i
                                                        class="mdi mdi-email-outline me-1"></i>Send Mail</a>
                                                <a href="tel:{{ $user->mobile }}"
                                                    class="btn btn-primary waves-effect waves-light btn-sm"><i
                                                        class="mdi mdi-phone-outline me-1"></i>PhoneCall</a>
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        {{-- <h5 class="font-size-16">About</h5>
                                        <p>Hi I'm Marcus,has been the industry's standard dummy text To an English person,
                                            it will seem like
                                            simplified.</p>
                                        <ul class="ps-3">
                                            <li>it will seem like simplified.</li>
                                            <li>To achieve this, it would be necessary to have uniform pronunciation</li>
                                        </ul> --}}
                                    </div>

                                    <hr class="my-4">

                                    {{-- <div>
                                        <h5 class="font-size-16">My Skills</h5>
                                        <div class="mt-3">
                                            <span class="badge badge-soft-dark font-size-12 me-2">Javascript</span>
                                            <span class="badge badge-soft-dark font-size-12 me-2">HTML</span>
                                            <span class="badge badge-soft-dark font-size-12 me-2">Laravel</span>
                                            <span class="badge badge-soft-dark font-size-12 me-2">Angular</span>
                                            <span class="badge badge-soft-dark font-size-12 me-2">Android</span>
                                            <span class="badge badge-soft-dark font-size-12 me-2">Bootstrap</span>
                                        </div>
                                    </div> --}}

                                    <hr class="my-4">
                                    <div class="table-responsive">
                                        <h5 class="font-size-16">Personal Information</h5>

                                        <div>
                                            <p class="mb-1 text-muted">Mobile :</p>
                                            <h5 class="font-size-14">{{ $user->mobile ?? 'No Number' }}</h5>
                                        </div>
                                        <div class="mt-3">
                                            <p class="mb-1 text-muted">E-mail :</p>
                                            <h5 class="font-size-14">{{ $user->email ?? 'No Email' }}</h5>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8">
                            <div class="card mb-0">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tasks" role="tab">
                                            <i class="mdi mdi-clipboard-text-outline font-size-20"></i>
                                            <span class="d-none d-sm-block">Roles</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#about" role="tab">
                                            <i class="mdi mdi-account-circle-outline font-size-20"></i>
                                            <span class="d-none d-sm-block">About</span>
                                        </a>
                                    </li>

                                    {{-- <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                                            <i class="mdi mdi-email-outline font-size-20"></i>
                                            <span class="d-none d-sm-block">Messages</span>
                                        </a>
                                    </li> --}}
                                </ul>
                                <!-- Tab content -->
                                <div class="tab-content p-4">
                                    <div class="tab-pane" id="about" role="tabpanel">

                                        <div>
                                            {{-- <div class="dropdown float-end">
                                            <a class="text-body dropdown-toggle font-size-18" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Edit</a>
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Remove</a>
                                            </div>
                                        </div> --}}
                                            <div class="clearfix"></div>

                                            <div class="text-center bg-pattern">
                                                <img src="{{ parse_url($user->avatar, PHP_URL_SCHEME) == 'https' || parse_url($user->avatar, PHP_URL_SCHEME) == 'http'
                                                    ? $user->avatar
                                                    : Storage::url($user->avatar) }}"
                                                    alt="avatar-4" class="avatar-xl img-thumbnail rounded-circle mb-3">
                                                <h4 class="text-primary mb-2">{{ $user->name }}</h4>
                                                <h5 class="text-muted font-size-13 mb-3">
                                                    {{ implode(', ', $user->roles->pluck('name')->toArray()) }}
                                                </h5>
                                                <div class="text-center">
                                                    <a href="mailto:{{ $user->email }}"
                                                        class="btn btn-success me-2 waves-effect waves-light btn-sm"><i
                                                            class="mdi mdi-email-outline me-1"></i>Send Mail</a>
                                                    <a href="tel:{{ $user->mobile }}"
                                                        class="btn btn-primary waves-effect waves-light btn-sm"><i
                                                            class="mdi mdi-phone-outline me-1"></i>PhoneCall</a>
                                                </div>
                                            </div>

                                            <hr class="my-4">

                                            {{-- <h5 class="font-size-16">About</h5>
                                        <p>Hi I'm Marcus,has been the industry's standard dummy text To an English person,
                                            it will seem like
                                            simplified.</p>
                                        <ul class="ps-3">
                                            <li>it will seem like simplified.</li>
                                            <li>To achieve this, it would be necessary to have uniform pronunciation</li>
                                        </ul> --}}
                                        </div>

                                        <hr class="my-4">

                                        {{-- <div>
                                        <h5 class="font-size-16">My Skills</h5>
                                        <div class="mt-3">
                                            <span class="badge badge-soft-dark font-size-12 me-2">Javascript</span>
                                            <span class="badge badge-soft-dark font-size-12 me-2">HTML</span>
                                            <span class="badge badge-soft-dark font-size-12 me-2">Laravel</span>
                                            <span class="badge badge-soft-dark font-size-12 me-2">Angular</span>
                                            <span class="badge badge-soft-dark font-size-12 me-2">Android</span>
                                            <span class="badge badge-soft-dark font-size-12 me-2">Bootstrap</span>
                                        </div>
                                    </div> --}}

                                        <hr class="my-4">
                                        <div class="table-responsive">
                                            <h5 class="font-size-16">Personal Information</h5>

                                            <div>
                                                <p class="mb-1 text-muted">Mobile :</p>
                                                <h5 class="font-size-14">{{ $user->mobile ?? 'No Number' }}</h5>
                                            </div>
                                            <div class="mt-3">
                                                <p class="mb-1 text-muted">E-mail :</p>
                                                <h5 class="font-size-14">{{ $user->email ?? 'No Email' }}</h5>
                                            </div>
                                        </div>


                                    </div>

                                    {{-- roles tab --}}
                                    <div class="tab-pane active" id="tasks" role="tabpanel">
                                        <div>
                                            <h5 class="font-size-16 mb-3">Active</h5>

                                            <div class="table-responsive">
                                                <table class="table table-nowrap table-centered">
                                                    <tbody>
                                                        @foreach ($user->roles as $role)
                                                            <tr>
                                                                <td style="width: 60px;">
                                                                    <div class="form-check font-size-16 text-center">
                                                                        <label class="form-check-label"
                                                                            for="tasks-activeCheck2">{{ $loop->index + 1 }}</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a href="#"
                                                                        class="fw-bold text-dark">{{ ucwords($role->name) }}</a>
                                                                </td>

                                                                <td>{{ $user->created_at->format('d-M-Y') }}</td>
                                                                <td style="width: 160px;"><span
                                                                        class="badge badge-soft-primary font-size-12">Active</span>
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end row -->

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
