<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="icon"
        href="https://palangkaraya.go.id/wp-content/uploads/2015/10/1bb4e13af45cc5c480069da8670508c5.ico_.png"
        type="image/png">

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Public Sans", sans-serif;
            font-optical-sizing: auto;
        }
    </style>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="">
    @inertia
</body>

</html>
