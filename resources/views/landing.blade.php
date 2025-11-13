<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Discover Bangladesh like never before. Find, book, and explore authentic travel experiences across the country with Bdeshi Explorer.">
    <meta name="keywords"
        content="Bangladesh travel, tours, tourism, Cox's Bazar, Sundarbans, Sylhet, Bandarban, travel packages">
    <meta name="author" content="Bdeshi Explorer">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Bdeshi Explorer - Discover Bangladesh Like Never Before">
    <meta property="og:description" content="Find, book, and explore authentic travel experiences across Bangladesh">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <title>Bdeshi Explorer - Discover Bangladesh Like Never Before</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800,900|inter:300,400,500,600,700"
        rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-white">
    <div id="app"></div>
</body>

</html>
