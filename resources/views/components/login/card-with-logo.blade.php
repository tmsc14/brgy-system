<div class="row g-0 align-items-center justify-content-center bg-brown-secondary flex-fill solo-card-container">
    <div class="col-12 col-sm-8 col-lg-6 h-100 align-items-center justify-content-center d-flex">
        <div class="card bg-brown-primary mobile-full-height solo-card w-100">
            <div class="card-body d-flex flex-column justify-content-center mb-4 align-items-center position-relative">
                @if (!isset($hideBackButton))
                    <a href="/">
                        <button type="button"
                            class="position-absolute top-0 start-0 mt-2 mx-2 btn btn-primary-brown d-flex align-items-center"><x-gmdi-arrow-back
                                class="icon me-2" />Home</button>
                    </a>
                @endif
                <img class="img-fluid" src="{{ url('resources/img/logo.png') }}" alt="" />
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
