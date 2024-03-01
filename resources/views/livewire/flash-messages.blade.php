<div class="content">

    <div class="row">
        <div class="col">

            @if(session()->has('error'))
                <div class="alert alert-warning mt-3">
                    {{ session('error') }}
                </div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
            
        </div>
    </div>
</div>
