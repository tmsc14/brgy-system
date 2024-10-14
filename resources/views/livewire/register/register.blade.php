<div class="signup-container">
    <div class="signup-header">
        <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo" class="logo">
        <div class="line"></div>
    </div>
    <h2>{{ $title }}</h2>
    <form wire:submit="register">
    @livewire('register-wizard')
    </form>
</div>
