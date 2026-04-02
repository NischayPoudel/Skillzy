@props(['header'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Skillzy') }} - Admin</title>

    <!-- Custom Bauhaus CSS - No Build Process Needed -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="font-sans antialiased">
    <div class="admin-layout">
        @include('layouts.admin-navigation')

        <div class="admin-main">
            <!-- Page Heading -->
            @isset($header)
                <header class="admin-header">
                    <div class="container">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="container py-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
