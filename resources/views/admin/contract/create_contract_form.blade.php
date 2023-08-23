<form action="{{route('organization.contract.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <div class="row">
            <div class="form-group col-sm-12 col-md-6">
                <label for="" class="required-label">@lang('Organization')</label>
                <select name="organization_id" id="" class="form-control" value="{{old('organization_id')}}" required>
                    <option value="">Select Organization</option>
                    @foreach($organizations as $organization)
                    <option value="{{$organization->id}}">{{$organization->name}}</option>
                    @endforeach
                </select>
                @error('organization_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group col-sm-12 col-md-6">
                <label for="" class="required-label">@lang('Tittle')</label>
                <input type="text" class="form-control" name="contract_tittle" value="{{old('contract_tittle')}}" required >
                @error('contract_tittle') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group col-sm-12 col-md-6">
                <label for="" class="required-label">@lang('Version')</label>
                <input type="text" class="form-control" name="contract_version" value="{{old('contract_version')}}" required >
                @error('contract_version') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-sm-12 col-md-6">
                <label for="" class="required-label">@lang('Is Active')</label>
                <select name="active_status" id="" class="form-control" value="{{old('active_status')}}" required >
                    <option value="{{App\Enums::CONTRACT_STATUSES['ACTIVE']}}">Active</option>
                    <option value="{{App\Enums::CONTRACT_STATUSES['INACTIVE']}}">InActive</option>
                </select>
                @error('active_status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <hr />
                <h6 style="text-decoration: underline;">@lang('Document Section')</h6>
            </div>

            <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="">@lang('Contract File')</label>
                    <input type="file" class="form-control" name="contract_file">
                    @error('contract_file') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-12 col-md-4">
                <button type="submit" class="btn btn-primary">@lang('Create This Contract')</button>
            </div>
        </div>
    </div>
</form>