@if (session('message'))
    <p class="alert alert-success">{{ session('message') }}</p>
@endif
