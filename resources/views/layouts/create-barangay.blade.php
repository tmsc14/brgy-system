<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Barangay - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('resources/css/create_barangay/create-barangay.css') }}">

    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('css')
</head>
<body>
    <div class="create-barangay-container">
        <div class="header">
            <h1 class="title">Create your own <img src="{{ asset('resources/img/logo2.png') }}" alt="Brgy+ Logo" class="brgy-logo"></h1>
        </div>
        
        <div class="tabs">
            <!-- The links will be disabled if the form is incomplete -->
            <a href="{{ route('barangay_captain.create_barangay_info_form') }}" 
               class="{{ request()->is('barangay_info') ? 'active' : '' }}" 
               id="barangay-info-link">Barangay Info</a>

            <a href="{{ route('barangay_captain.appearance_settings') }}" 
               class="{{ request()->is('barangay_appearance') ? 'active' : '' }}" 
               id="appearance-settings-link">Appearances</a>

            <a href="{{ route('barangay_captain.features_settings') }}" 
               class="{{ request()->is('barangay_features') ? 'active' : '' }}" 
               id="features-settings-link">Features</a>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

    @yield('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const appearanceLink = document.getElementById('appearance-settings-link');
            const featuresLink = document.getElementById('features-settings-link');
            const form = document.getElementById('barangay-info-form'); // This assumes you're on the Barangay Info page

            // Check if the current page is Barangay Info (since only there we need to submit the form before navigation)
            const isBarangayInfoPage = form !== null;

            // Disable navigation links if the form is incomplete (for Barangay Info)
            function updateNavState(isFormComplete) {
                if (isFormComplete) {
                    appearanceLink.classList.remove('disabled');
                    featuresLink.classList.remove('disabled');
                } else {
                    appearanceLink.classList.add('disabled');
                    featuresLink.classList.add('disabled');
                }
            }

            // Check if the required form fields are complete
            function isFormComplete() {
                if (!isBarangayInfoPage) return true; // If we're not on Barangay Info, allow free navigation
                const requiredFields = document.querySelectorAll('[required]');
                for (let field of requiredFields) {
                    if (!field.value.trim()) {
                        return false;
                    }
                }
                return true;
            }

            // Initially update the navigation state
            updateNavState(isFormComplete());

            // Auto-save the form via AJAX when navigating to Appearance or Features (only on Barangay Info page)
            function submitFormAndNavigate(nextPageUrl) {
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = nextPageUrl;
                    } else {
                        alert('Please complete all required fields before proceeding.');
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // Add event listeners to navigation links
            appearanceLink.addEventListener('click', function(event) {
                if (isBarangayInfoPage && !isFormComplete()) {
                    event.preventDefault();
                    alert('Please complete the Barangay Info before proceeding.');
                } else if (isBarangayInfoPage) {
                    event.preventDefault();
                    submitFormAndNavigate(this.href);  // Save the form and navigate to Appearance
                }
            });

            featuresLink.addEventListener('click', function(event) {
                if (isBarangayInfoPage && !isFormComplete()) {
                    event.preventDefault();
                    alert('Please complete the Barangay Info before proceeding.');
                } else if (isBarangayInfoPage) {
                    event.preventDefault();
                    submitFormAndNavigate(this.href);  // Save the form and navigate to Features
                }
            });

            // Listen to changes in the form fields to recheck form completeness
            const formFields = document.querySelectorAll('input, textarea');
            formFields.forEach(field => {
                field.addEventListener('input', function () {
                    updateNavState(isFormComplete());
                });
            });
        });
    </script>
</body>
</html>
