@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-all me-2"></i>
        {{ session()->get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-all me-2"></i>
        {{ session()->get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif



<!-- 
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-2"></i>
    A simple success alert—check it out!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->