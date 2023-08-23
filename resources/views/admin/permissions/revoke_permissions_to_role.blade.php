@extends('layouts.admin_master', ['title'=>'Permission Revoke'])

@section('content')
    <form action="{{route('admin.permissions.revokePermissionsToRole')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="roleId" id="input-selected-role" value="{{$selectedRoleId}}">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="" class="form-label">Select Role</label>
                    <select name="role_id" id="select-role-field" class="form-control" required>
                        <option value="">Select a role</option>
                        @foreach ($roles as $role)
                            <option value="{{$role->id}}" {{$role->id == $selectedRoleId ? 'selected' : ''}}>{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 m-3">
                <h3>Select Permissions which will be revoked</h3>
            </div>
        </div>

        <div class="row">
            @foreach ($permissions as $permission)
                <div class="col-sm-6 col-md-3 my-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="permissions[]" type="checkbox" id="check{{$permission->id}}" value="{{$permission->id}}" {{in_array($permission->id, $selectedPermissions) ? 'checked' : ''}}>
                        <label class="form-check-label" for="check{{$permission->id}}">{{$permission->name}}</label>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12 my-2">
                <button type="submit" class="btn btn-sm btn-primary ">Save Changes</button>
            </div>
        </div>
    </form>
@endsection

@push('custom_scripts')
    <script>
        $(document).on('change', '#select-role-field', function () {
            let url = "{{route('admin.permissions.revokePermissionsToRole')}}"+'/'+$(this).val();
            window.location.href = url;
        })
    </script>
@endpush