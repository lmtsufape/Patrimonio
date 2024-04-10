<div class="d-flex justify-content-center">
    @if(session()->has('fail'))
        <div class="alert alert-danger rounded-3 border border-danger shadow alert-dismissible fade show text-center mt-3 w-75" role="alert">
            <strong class="font-size-lg">{{ session('fail') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session()->has('success'))
        <div class="alert alert-success rounded-3 border border-success shadow alert-dismissible fade show text-center mt-3 w-75" role="alert">
            <strong class="font-size-lg">{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
