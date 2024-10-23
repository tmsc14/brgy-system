<x-login.card-with-logo>
    <div class="col-12 align-items-center justify-content-center d-flex">
        <form class="w-100" wire:submit="login">
            @csrf
            <div class="d-flex flex-column gap-3">
                <x-form-text-input id="loginEmail" name="email" label="Email" type="email" wire:model="email"
                    placeholder="Enter your email here." :errors="$errors" propertyName="email" light />
                <x-form-password id="loginPassword" label="Password" propertyName="password" wire:model="password"
                    light />
                <div class="d-flex">
                    <div class="form-check justify-content-around text-light">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input" />
                        <label for="remember" class="form-check-label">
                            Remember Me
                        </label>
                    </div>
                    <a href="#" class="ms-auto">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-secondary-brown">Log In</button>
                <div class="signup-text-container text-center">
                    <span class="signup-text text-light">Don't have an account?</span>&nbsp;
                    <a href="{{ route('register.resident') }}" class="signup-link">Sign Up Here</a>
                </div>
            </div>
        </form>
    </div>
</x-login.card-with-logo>
