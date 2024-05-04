<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Digipark adalah situs dari Dinas Ketenagakerjaan Palangkaraya yang bertujuan untuk membantu masyarakat dan perusahaan dalam mencari dan menawarkan lowongan pekerjaan.">
    <meta name="keywords"
        content="digipark, dinas ketenagakerjaan, palangkaraya, lowongan kerja, mencari kerja, pekerjaan, karir">
    <meta name="author" content="gunungmedia.com">
    <meta property="og:title" content="Digipark - Situs Dinas Ketenagakerjaan Palangkaraya">
    <meta property="og:description"
        content="Digipark adalah situs dari Dinas Ketenagakerjaan Palangkaraya yang bertujuan untuk membantu masyarakat dan perusahaan dalam mencari dan menawarkan lowongan pekerjaan.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://digipark.palangkaraya.go.id">
    <meta property="og:image"
        content="https://digipark.palangkaraya.go.id/storage/dashboard_images/01HTFN04GVF2N2KCRNVEPXYFP9.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Digipark">

    <title>@yield('title') Digital Palangka Raya Kreatif Kewirausahaan</title>
    <link rel="icon"
        href="https://palangkaraya.go.id/wp-content/uploads/2015/10/1bb4e13af45cc5c480069da8670508c5.ico_.png"
        type="image/png">
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
