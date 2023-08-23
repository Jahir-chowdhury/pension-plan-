@extends('layouts.admin_master', ['title'=>'Contacts details and creation'])

@push('custom_styles')
<!-- DataTables -->
<link href="{{asset('backend')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('backend')}}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('backend')}}/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('backend')}}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
@include('messages')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="pull-left">Contact List</span>
                <span class="">
                    <button type="button" class="pull-right btn btn-sm btn-success waves-effect waves-light" id="contact-create-btn">Add Contact</button>
                </span>
            </div>

            <div class="card-body">
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>


                <tbody>
                @forelse($contacts as $contact)
                    <tr>
                        <td>{{$contact->name}}</td>
                        <td>{{$contact->designation}}</td>
                        <td>{{$contact->phone}}</td>
                        <td>{{$contact->email}}</td>
                        <td>{{$contact->status ? 'Active' : 'Inactive'}}</td>
                        <td>{{$contact->created_at}}</td>
                        <td>
                            <span class="badge bg-primary contact-edit-btn" style="cursor: pointer;"
                                data-id="{{$contact->id}}" 
                                data-name="{{$contact->name}}"
                                data-designation="{{$contact->designation}}"
                                data-phone="{{$contact->phone}}"
                                data-email="{{$contact->email}}">Edit
                            </span>
                        </td>
                    </tr>
                @empty
                    
                @endforelse
                </tbody>
            </table>
                

            </div>
        </div>
    </div>
</div>


<!-- Add Modal -->
<div class="modal fade" id="contactCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('Create Contact')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{route('admin.organization.contact.create')}}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-sm-12 col-md-6">
                    <label for="input_contact_name" class="form-label">@lang('Name')</label>
                    <input type="text" class="form-control" id="input_contact_name" name="name" required>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="input_contact_designation">@lang('Designation')</label>
                    <input type="text" class="form-control" id="input_contact_designation" name="designation" required>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="input_contact_phone">@lang('Phone')</label>
                    <input type="text" class="form-control" id="input_contact_phone" name="phone" required>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="input_contact_email">@lang('Email')</label>
                    <input type="text" class="form-control" id="input_contact_email" name="email" required>
                </div>
            </div>
        </div>
      

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" class="modal-close-btn">Close</button>
            <button type="submit" class="btn btn-primary" id="input_contact_submit">Create this Contact</button>
        </div>
      </form>

    </div>
  </div>
</div>





<!-- Edit Modal -->
<div class="modal fade" id="contactEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Update Contact')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
  
        <form action="{{route('admin.organization.contact.update')}}" method="POST">
          @csrf
          <input type="hidden" name="contact_id" value="" id="input_edit_contact_id">
          <div class="modal-body">
              <div class="row">
                  <div class="form-group col-sm-12 col-md-6">
                      <label for="input_edit_contact_name" class="form-label">@lang('Name')</label>
                      <input type="text" class="form-control" id="input_edit_contact_name" name="name" required>
                  </div>
  
                  <div class="form-group col-sm-12 col-md-6">
                      <label for="input_edit_contact_designation">@lang('Designation')</label>
                      <input type="text" class="form-control" id="input_edit_contact_designation" name="designation" required>
                  </div>
  
                  <div class="form-group col-sm-12 col-md-6">
                      <label for="input_edit_contact_phone">@lang('Phone')</label>
                      <input type="text" class="form-control" id="input_edit_contact_phone" name="phone" required>
                  </div>
  
                  <div class="form-group col-sm-12 col-md-6">
                      <label for="input_edit_contact_email">@lang('Email')</label>
                      <input type="text" class="form-control" id="input_edit_contact_email" name="email" required>
                  </div>
              </div>
          </div>
        
  
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" class="modal-close-btn">Close</button>
              <button type="submit" class="btn btn-primary" id="input_edit_contact_submit">Save Changes</button>
          </div>
        </form>
  
      </div>
    </div>
  </div>
@endsection

@push('custom_scripts')
<script src="{{asset('backend')}}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('backend')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="{{asset('backend')}}/js/pages/datatables.init.js"></script>

<script>
    $(document).ready(function () {
        $(document).on('click', '#contact-create-btn', function () {
            $("#contactCreateModal").modal('show');
        });

        $(document).on('click', '.contact-edit-btn', function () {
            var name = $(this).data('name');
            var phone = $(this).data('phone');
            var email = $(this).data('email');
            var id = $(this).data('id');
            var designation = $(this).data('designation');

            $("#input_edit_contact_name").val(name);
            $("#input_edit_contact_designation").val(designation);
            $("#input_edit_contact_id").val(id);
            $("#input_edit_contact_phone").val(phone);
            $("#input_edit_contact_email").val(email);

            $("#contactEditModal").modal('show');

        });
    });
</script>
@endpush