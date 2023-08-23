<form action="{{ route('role.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label for="name" class="form-label">Role name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    id="name" placeholder="Role name" value="{{ old('name', $role->name) }}" required>
                {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
            </div>
        </div>
    </div>
    @if ($group_permissions->count() > 0)
        <div class="row">
            <div class="col-md-12">
                <hr>
                <div class="form-group edit_all">
                    <label for="name">Permisions</label>
                    <div class="form-check">
                        <input readonly type="checkbox" readonly class="form-check-input" id="edit_checkPermissionAll"
                            value="1" {{ HasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_checkPermissionAll">All</label>
                    </div>
                    <hr>
                    @php $i=1; @endphp
                    @foreach ($group_permissions as $key => $group_permission)
                        <div class="row">
                            <div class="col-3">
                                <div class="form-check">
                                    <input readonly type="checkbox" class="form-check-input"
                                        id="edit_{{ $i }}management" value="{{ $key }}"
                                        onclick="edit_checkPermissionByGroup('edit_role-{{ $i }}-management-checkbox', this)"
                                        {{ HasPermissions($role, $group_permission) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="edit_checkPermission">{{ ucwords($key) }}</label>
                                </div>
                            </div>

                            <div class="col-9 edit_role-{{ $i }}-management-checkbox">
                                <div class="row">
                                    @foreach ($group_permission as $permission)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input readonly type="checkbox" class="form-check-input"
                                                    name="permissions[]" id="edit_checkPermission{{ $permission->id }}"
                                                    value="{{ $permission->name }}"
                                                    onclick="edit_checkSinglePermission('edit_role-{{ $i }}-management-checkbox','edit_{{ $i }}management','{{ count($group_permission) }}')"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="edit_checkPermission{{ $permission->id }}">
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
            <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('Update this Role')</button>
        </div>
    </div>
</form>
