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
        if (colors) {
            themeColorInput.value = colors.theme_color;
            primaryColorInput.value = colors.primary_color;
            secondaryColorInput.value = colors.secondary_color;
            textColorInput.value = colors.text_color;

            updateColorBox(themeColorInput, themeColorBox);
            updateColorBox(primaryColorInput, primaryColorBox);
            updateColorBox(secondaryColorInput, secondaryColorBox);
            updateColorBox(textColorInput, textColorBox);
        }
    }

    themeSelect.addEventListener('change', function() {
        const selectedTheme = themeSelect.value;
        applyTheme(selectedTheme);
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

document.getElementById('logo').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.appearance-logo-preview').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(file);
    }
});
