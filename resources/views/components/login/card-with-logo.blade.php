<div class="row g-0 align-items-center justify-content-center h-100 bg-brown-secondary px-4">
    <div class="col-12 col-md-8 col-lg-6 col-xl-4 ">
        <div class="card bg-brown-primary h-sm-100" style="border-radius: 1rem;">
            <div class="card-body d-flex flex-column align-items-center mb-4">
                <img class="img-fluid" src="{{ url('resources/img/logo.png') }}" alt="" />
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
