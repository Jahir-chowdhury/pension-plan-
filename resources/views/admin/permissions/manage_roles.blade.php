@extends('layouts.admin_master', ['title'=>'Role & Permissions Manage'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">All Roles :  <button class="btn btn-sm btn-primary pull-right" data-bs-toggle="modal" data-bs-target="#role-adding-modal">Add Role</button></h4>
                
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Role Name</th>
                            <th>Count Permissions</th>
                            <th>Entry Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role) 
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td>{{count($role->permissions)}}</td>
                            <td>{{$role->created_at->format('Y-m-d')}}</td>
                            <td>
                                <a href="{{route('admin.permissions.revokePermissionsToRole', ['roleId'=>$role->id])}}"><i class="bx bx-edit-alt"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- end card-body -->
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div> <!-- end row -->

<!-- Role Adding Modal -->
<div class="modal fade" id="role-adding-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('admin.permissions.create.role')}}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group mt-3">
                <label for="">Role Name</label>
                <input type="text" class="form-control" name="role_name" required>
            </div>

            <div class="form-group mt-3">
                <label for="">Short description</label>
                <textarea name="short_description" id="" cols="30" rows="5" class="form-control" required></textarea>
            </div>

            <div class="form-group mt-3">
                <label for="">Status</label>
                <select name="role_status" id="" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add This role</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@include('admin.script_styles.data_table')

@push('custom_scripts')

@endpush

