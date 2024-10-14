<div class="row g-0 align-items-center justify-content-center h-100 bg-brown-secondary">
    <div class="col-12 col-sm-8 col-lg-6 col-xl-4 h-100 align-items-center justify-content-center d-flex">
        <div class="card bg-brown-primary mobile-full-height solo-card w-100">
            <div class="card-body d-flex flex-column justify-content-center mb-4 align-items-center">
                <img class="img-fluid" src="{{ url('resources/img/logo.png') }}" alt="" />
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
