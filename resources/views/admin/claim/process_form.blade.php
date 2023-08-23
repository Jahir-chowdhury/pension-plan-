@extends('layouts.admin.admin_master', ['title'=>'Member Information To Process A Claim'])

@push('custom_styles')
    <style>
        .form-group{
            margin-bottom: 10px;
        }
        .required-label::after {
            content: " *";
            color: red;
        }
    </style>
    <!-- DataTables -->
    <link href="{{asset('backend')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
@include('messages')
<form action="{{route('claims.process_store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <div class="form-group">
            <div class="row">
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input_employee_name" >@lang('Employee name')</label>
                    <input type="text" class="form-control" name="employee_name" value="{{$member->name}}" id="input_employee_name" readonly="readonly">
                    @error('employee_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-member-department" >@lang('Department')</label>
                    <input type="text" class="form-control" name="department" value="{{$member->department}}" id="input-member-department" readonly="readonly">
                    @error('department') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4" >
                    <label for="input-member-designation" >@lang('Designation')</label>
                    <input type="text" class="form-control" name="designation" value="{{$member->designation}}" id="input-member-designation" readonly="readonly">
                    @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-member_id" >@lang('Member ID')</label>
                    <input type="text" class="form-control" name="member_id" value="{{$member->member_id}}" id="input-member_id" readonly="readonly">
                    @error('member_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-intimation_no" >@lang('Intimation No')</label>
                    <input type="text" class="form-control" name="intimation_number" value="{{$claim->intimation_number}}" id="input-intimation_number" readonly="readonly">
                    @error('intimation_number') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-nid" >@lang('NID No.')</label>
                    <input type="text" class="form-control" id="input-employee-nid" value="{{$member->nid_number}}" maxlength="20" name="employee_nid" readonly="readonly" >
                    @error('employee_nid') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-dob" >@lang('Date of birth')</label>
                    <input type="date" class="form-control" name="date_of_birth" value="{{$member->date_of_birth}}" id="input-employee-dob" readonly="readonly">
                    @error('date_of_birth') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" >@lang('Membership Date')</label>
                    <input type="date" class="form-control" name="membership_date" value="{{$member->membership_date}}" id="input-membership-date" readonly="readonly">
                    @error('membership_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-mobile" >@lang('Employee mobile')</label>
                    <input type="text" class="form-control" name="employee_mobile" value="{{$member->mobile}}" id="input-employee-mobile" readonly="readonly">
                    @error('employee_mobile') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-email" class="">@lang('Employee Email')</label>
                    <input type="email" class="form-control" name="employee_email" value="{{$member->email}}" id="input-employee-email" readonly="readonly">
                    @error('employee_email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-salary" >@lang('Employee Salary')</label>
                    <input type="number" class="form-control" name="employee_salary" value="{{$member->salary}}" id="input-employee-salary" readonly="readonly">
                    @error('employee_salary') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-sum_at_risk" >@lang('Employee Sum At Risk')</label>
                    <input type="number" class="form-control" name="employee_sum_at_risk" value="{{$member->sum_at_risk}}" id="input-employee-sum_at_risk" readonly="readonly">
                    @error('employee_sum_at_risk') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-bank-account-name" >@lang('Epployee Bank Name')</label>
                    <input type="text" class="form-control" name="employee_bank_account_name" value="{{$member->bank_name}}" id="input-employee-bank-account-name" readonly="readonly">
                    @error('employee_bank_account_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-bank-account-number" >@lang('Employee bank account number')</label>
                    <input type="text" class="form-control" name="employee_bank_account_number" value="{{$member->bank_account_number}}" id="input-bank-account-number" readonly="readonly">
                    @error('employee_bank_account_number') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-bank-account-number" >@lang('Claimed amount')</label>
                    <input type="text" class="form-control" name="claimed_amount" value="{{$claim->claimed_amount}}" id="claimed_amount" readonly="readonly">
                    @error('claimed_amount') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <label for="" >@lang('Incident Date')</label>
                    <input type="date" class="form-control" name="incident_date" value="{{$claim->incident_date}}" id="input-membership-date" readonly="readonly">
                    @error('incident_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-4" >
                    <label for="input-incident_remarks" >@lang('Incident Remarks')</label>
                    <input type="text" class="form-control" name="incident_remarks" value="{{$claim->incident_remarks}}" id="input-member-designation" readonly="readonly">
                    @error('incident_remarks') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="row">
                <h5>Claim Process </h5>
                <div class="form-group col-sm-12 col-md-6" >
                    <label for="input-claim_officer_remarks" >@lang('Claim Officer Remarks')</label>
                    <input type="text" class="form-control" name="claim_officer_remarks" value="{{old('claim_officer_remarks')}}" id="input-member-designation" required>
                    @error('claim_officer_remarks') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="" >@lang('Claim Status')</label>
                    <select name="claim_status" id="" class="form-control" value="{{old('claim_status')}}">
                        <option value="">Select Claim Status</option>
                        @foreach($statuses as $status)
                        <option value="{{$status->id}}">{{$status->name}}</option>
                        @endforeach
                    </select>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="row">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Documents Show')</h5>            
                @foreach($documents as $document)   
                <div class="form-group col-sm-12 col-md-4">
                    <div class="controls">
                        @php
                        $x=pathinfo($document->claim_files, PATHINFO_EXTENSION);
                        //$pathToFile=storage_path("app/public/upload/{$document->claim_files}")
                        @endphp
                        @switch($x)
                            @case('pdf')
                            <div class="entry input-group upload-input-group ">
                                <a href="{{asset('storage/upload/claim_documents/'.$document->claim_files)}}" target="blank">
                                <img src="{{ asset('thumnail/pdf.png') }}" alt="" class="img-thumbnail"width="100" height="100">
                                <h6>{{$document->claim_files}}</h6>
                            </div>
                                @break
                    
                            @case('jpg')
                            <div class="entry input-group upload-input-group">
                               <a href="{{asset('storage/upload/claim_documents/'.$document->claim_files)}}" target="blank">
                                <img src="{{asset('storage/upload/claim_documents/'.$document->claim_files)}}" alt="Attachment not available" class="img-thumbnail"width="100" height="100">
                                <h6>{{$document->claim_files}}</h6>
                            </div>
                                @break
                            @case('docx')
                            <div class="entry input-group upload-input-group">
                                <a href="{{asset('storage/upload/claim_documents/'.$document->claim_files)}}" target="blank">
                                <img src="{{ asset('thumnail/word.png') }}" alt="" class="img-thumbnail"width="100" height="100">
                                <h6>{{$document->claim_files}}</h6>
                            </div>
                                @break

                            @default
                            <div class="entry input-group upload-input-group">
                                <a href="{{asset('storage/upload/claim_documents/'.$document->claim_files)}}" target="blank">
                                <img src="{{ asset('thumnail/document.png') }}" alt="" class="img-thumbnail"width="100" height="100">
                                <h6>{{$document->claim_files}}</h6>
                            </div>
                        @endswitch

                    </div>
                </div>
                @endforeach
            </div>
            {{--
            <div class="row">
                <div class="col-sm-12">
                    <hr />
                    <h6 style="text-decoration: underline;">@lang('Document Section')</h6>
                </div>
    
                <div class="form-group col-sm-12 col-md-4">
                        <label for="" class="">@lang('Employee Photo')</label>
                        <input type="file" class="form-control" name="file_employee_photo">
                        @error('file_employee_photo') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
    
                <div class="form-group col-sm-12 col-md-4">
                        <label for="" class="">@lang('Employee NID Card Photo')</label>
                        <input type="file" class="form-control" name="file_nid">
                        @error('file_nid') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            --}}
            <div class="row">
                <div class="form-group col-sm-12 col-md-4">
                    <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                </div>
            </div>
        </div>
</form>
@push('custom_scripts')
    <script type="text/javascript">
        
        $(function () {
            $(document).on('click', '.btn-add', function (e) {
                e.preventDefault();

                var controlForm = $('.controls:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                controlForm.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });
        });



    </script>
@endpush
@endsection