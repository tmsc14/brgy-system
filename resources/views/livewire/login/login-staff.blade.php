<x-login.card-with-logo>
    <div class="col-12 align-items-center justify-content-center d-flex">
        @if (session('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
        @endif
        <form class="w-100" action="{{ route('barangay_captain.login.post') }}" method="POST">
            @csrf
            <div class="d-flex flex-column gap-3">
                <x-form-text-input id="loginEmail" name="email" label="Email" type="email"
                    placeholder="Enter your email here." :errors="$errors" propertyName="email" light />
                <div class="form-group">
                    <label class="text-light" for="password">Password</label>
                    <div class="position-relative">
                        <input class="form-control" type="password" name="password" id="password"
                            placeholder="Enter your password here." required />
                        <img id="toggle-password" src="{{ url('resources/img/login-icons/hidepass.png') }}"
                            alt="Show Password"
                            class="icon position-absolute top-50 end-0 translate-middle-y me-2 pe-auto"
                            onclick="togglePassword()">
                    </div>
                    @if ($errors->has('password'))
                        <span class="error">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="text-light" for="barangay">Barangay</label>
                    <select class="form-select" id="barangay" name="barangay" required placeholder="Select your barangay here.">
                        @if (!empty($barangays))
                            @foreach ($barangays as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->barangay_name }}</option>
                            @endforeach
                        @else
                            <option>No barangays have been registered yet.</option>
                        @endif
                    </select>
                    @error('barangay')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
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
                    <a href="{{ route('register.barangay-captain') }}" class="signup-link">Sign Up Here</a>
                </div>
            </div>
        </form>
    </div>
</x-login.card-with-logo>
