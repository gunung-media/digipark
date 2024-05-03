<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title') Digital Palangka Raya Kreatif Kewirausahaan</title>
    @include('layouts.portal.partials.css')
    @yield('css')
</head>

<body>
    <a href="https://wa.me/{{ $dashboard?->phone_number }}?text={{ urlencode($dashboard?->default_text ?? '') }}"
        class="whatsapp-fab" target="_blank">
        <img src="{{ asset('images/WhatsApp.svg') }}" alt="WhatsApp Icon" class="whatsapp-icon">
    </a>
    <div id="home">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('layouts.portal.partials.header')
            @include('layouts.portal.partials.navbar')

            <div class="main-content">
                @yield('content')
            </div>

            @include('layouts.portal.partials.footer')
        </div>
    </div>
    @include('layouts.portal.partials.scripts')
    @yield('script')
</body>

</html>
