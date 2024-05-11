<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ressources Relationnelles</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @viteReactRefresh
    @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
    @inertiaHead

    <link rel="apple-touch-icon" href="/dsfr/favicon/apple-touch-icon.png" />
    <link rel="icon" href="/dsfr/favicon/favicon.svg" type="image/svg+xml" />
    <link rel="shortcut icon" href="/dsfr/favicon/favicon.ico" type="image/x-icon" />
    <link rel="manifest" href="/dsfr/favicon/manifest.webmanifest" crossorigin="use-credentials" />

    <!--<link rel="preload" href="/dsfr/fonts/Marianne-Light.woff2" as="font" crossorigin="anonymous" />-->
    <!--<link rel="preload" href="/dsfr/fonts/Marianne-Light_Italic.woff2" as="font" crossorigin="anonymous" />-->
    <link rel="preload" href="/dsfr/fonts/Marianne-Regular.woff2" as="font" crossorigin="anonymous" />
    <!--<link rel="preload" href="/dsfr/fonts/Marianne-Regular_Italic.woff2" as="font" crossorigin="anonymous" />-->
    <link rel="preload" href="/dsfr/fonts/Marianne-Medium.woff2" as="font" crossorigin="anonymous" />
    <!--<link rel="preload" href="/dsfr/fonts/Marianne-Medium_Italic.woff2" as="font" crossorigin="anonymous" />-->
    <link rel="preload" href="/dsfr/fonts/Marianne-Bold.woff2" as="font" crossorigin="anonymous" />
    <!--<link rel="preload" href="/dsfr/fonts/Marianne-Bold_Italic.woff2" as="font" crossorigin="anonymous" />-->
    <!--<link rel="preload" href="/dsfr/fonts/Spectral-Regular.woff2" as="font" crossorigin="anonymous" />-->
    <!--<link rel="preload" href="/dsfr/fonts/Spectral-ExtraBold.woff2" as="font" crossorigin="anonymous" />-->
    <link rel="stylesheet" href="/dsfr/utility/icons/icons.min.css" />
    <link rel="stylesheet" href="/dsfr/dsfr.min.css" />
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>