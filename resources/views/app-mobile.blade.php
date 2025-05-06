<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=0">
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
            font-family: "Public Sans", sans-serif;
            font-optical-sizing: auto;
        }
    </style>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue", 'resources/css/app.css'])
    @inertiaHead
</head>

<body class="bg-gray-50 flex justify-center items-center min-h-screen">
    <div
        class="w-[450px] max-w-[450px] bg-white shadow-lg overflow-hidden my-0 mx-auto min-h-screen overflow-x-hidden bg-white pb-[66px]">
        @inertia
    </div>
</body>

</html>
