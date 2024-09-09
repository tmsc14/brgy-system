@extends('layouts.create-barangay')

@section('css')
<link rel="stylesheet" href="{{ asset('resources/css/create_barangay/appearance-settings.css') }}">
@endsection

@section('content')
<div class="appearance-container">
    <h2>Appearance Settings</h2>
    <form action="{{ route('barangay_captain.appearance_settings.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="appearance-form-group">
            <label for="theme">Select Theme</label>
            <select name="theme" id="theme" class="appearance-form-control">
                <option value="">Custom</option>
                <option value="default">Default</option>
                <option value="dark">Dark</option>
                <option value="blue">Blue</option>
                <option value="green">Green</option>
            </select>
        </div>
        <div class="appearance-form-group">
            <label for="theme_color">Theme Color</label>
            <input type="color" name="theme_color" id="theme_color" class="appearance-form-control" value="{{ $appearanceSettings->theme_color }}" required>
            <span class="color-box" id="theme_color_box" style="background-color: {{ $appearanceSettings->theme_color }}"></span>
        </div>
        <div class="appearance-form-group">
            <label for="primary_color">Primary Color</label>
            <input type="color" name="primary_color" id="primary_color" class="appearance-form-control" value="{{ $appearanceSettings->primary_color }}" required>
            <span class="color-box" id="primary_color_box" style="background-color: {{ $appearanceSettings->primary_color }}"></span>
        </div>
        <div class="appearance-form-group">
            <label for="secondary_color">Secondary Color</label>
            <input type="color" name="secondary_color" id="secondary_color" class="appearance-form-control" value="{{ $appearanceSettings->secondary_color }}" required>
            <span class="color-box" id="secondary_color_box" style="background-color: {{ $appearanceSettings->secondary_color }}"></span>
        </div>
        <div class="appearance-form-group">
            <label for="text_color">Text Color</label>
            <input type="color" name="text_color" id="text_color" class="appearance-form-control" value="{{ $appearanceSettings->text_color }}" required>
            <span class="color-box" id="text_color_box" style="background-color: {{ $appearanceSettings->text_color }}"></span>
        </div>
        <div class="appearance-form-group">
            <label for="logo">Logo</label>
            <input type="file" name="logo" id="logo" class="appearance-form-control">
            @if($appearanceSettings->logo_path)
                <img src="{{ asset('storage/' . $appearanceSettings->logo_path) }}" alt="Logo" class="appearance-logo-preview">
            @endif
        </div>
        <button type="submit" class="appearance-btn-primary">Save</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const themes = {
            'default': {
                theme_color: '#FAEED8',
                primary_color: '#503C2F',
                secondary_color: '#FAFAFA',
                text_color: '#000000',
            },
            'dark': {
                theme_color: '#2E2E2E',
                primary_color: '#1A1A1A',
                secondary_color: '#FAFAFA',
                text_color: '#FFFFFF',
            },
            'blue': {
                theme_color: '#E3F2FD',
                primary_color: '#2196F3',
                secondary_color: '#BBDEFB',
                text_color: '#0D47A1',
            },
            'green': {
                theme_color: '#E8F5E9',
                primary_color: '#4CAF50',
                secondary_color: '#C8E6C9',
                text_color: '#1B5E20',
            },
        };

        const themeSelect = document.getElementById('theme');
        const themeColorInput = document.getElementById('theme_color');
        const primaryColorInput = document.getElementById('primary_color');
        const secondaryColorInput = document.getElementById('secondary_color');
        const textColorInput = document.getElementById('text_color');
        
        const themeColorBox = document.getElementById('theme_color_box');
        const primaryColorBox = document.getElementById('primary_color_box');
        const secondaryColorBox = document.getElementById('secondary_color_box');
        const textColorBox = document.getElementById('text_color_box');

        function updateColorBox(input, box) {
            box.style.backgroundColor = input.value;
        }

        function applyTheme(theme) {
            const colors = themes[theme];
            themeColorInput.value = colors.theme_color;
            primaryColorInput.value = colors.primary_color;
            secondaryColorInput.value = colors.secondary_color;
            textColorInput.value = colors.text_color;

            updateColorBox(themeColorInput, themeColorBox);
            updateColorBox(primaryColorInput, primaryColorBox);
            updateColorBox(secondaryColorInput, secondaryColorBox);
            updateColorBox(textColorInput, textColorBox);
        }

        themeSelect.addEventListener('change', function() {
            const selectedTheme = themeSelect.value;
            if (themes[selectedTheme]) {
                applyTheme(selectedTheme);
            }
        });

        themeColorInput.addEventListener('input', function() {
            updateColorBox(themeColorInput, themeColorBox);
        });

        primaryColorInput.addEventListener('input', function() {
            updateColorBox(primaryColorInput, primaryColorBox);
        });

        secondaryColorInput.addEventListener('input', function() {
            updateColorBox(secondaryColorInput, secondaryColorBox);
        });

        textColorInput.addEventListener('input', function() {
            updateColorBox(textColorInput, textColorBox);
        });
    });
</script>
@endsection


