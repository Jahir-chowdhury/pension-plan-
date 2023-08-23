<form action="{{ route('role.create') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label for="name" class="form-label">Role name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    id="name" placeholder="Role name" value="{{ old('name') }}" required>
                {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
            </div>
        </div>
    </div>
    @if ($group_permissions->count() > 0)
        <div class="row">
            <div class="col-md-12">
                <hr>
                <div class="form-group all">
                    <label for="name">Permisions</label>
                    <div class="form-check">
                        <input readonly type="checkbox" readonly class="form-check-input" id="checkPermissionAll"
                            value="1">
                        <label class="form-check-label" for="checkPermissionAll">All</label>
                    </div>
                    <hr>
                    @php $i=1; @endphp
                    @foreach ($group_permissions as $key => $group_permission)
                        <div class="row">
                            <div class="col-3">
                                <div class="form-check">
                                    <input readonly type="checkbox" class="form-check-input"
                                        id="{{ $i }}management" value="{{ $key }}"
                                        onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                    <label class="form-check-label" for="checkPermission">{{ ucwords($key) }}</label>
                                </div>
                            </div>

                            <div class="col-9 role-{{ $i }}-management-checkbox">
                                <div class="row">
                                    @foreach ($group_permission as $permission)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input readonly type="checkbox" class="form-check-input"
                                                    name="permissions[]" id="checkPermission{{ $permission->id }}"
                                                    value="{{ $permission->name }}"
                                                    onclick="checkSinglePermission('role-{{ $i }}-management-checkbox','{{ $i }}management','{{ count($group_permission) }}')">
                                                <label class="form-check-label badge badge-lg bg-info"
                                                    for="checkPermission{{ $permission->id }}">
                                                    @php
                                                        $permision_name = isset(explode('.', $permission->name)[1]) ? explode('.', $permission->name)[1] : '';
                                                    @endphp
                                                    {{ ucwords($permision_name) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                        @php  $i++; @endphp
                    @endforeach

                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <hr>
        </div>

        <div class="col-12">
            <button type="reset" class="btn btn-warning waves-effect waves-light">@lang('Clear')</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('Create this Role')</button>
        </div>
    </div>
</form>
