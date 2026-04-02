@props(['header'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Skillzy') }} - Staff</title>

    <!-- Custom Bauhaus CSS - No Build Process Needed -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="font-sans antialiased" style="margin: 0; padding: 0;">
    <div class="admin-layout" style="display: flex; min-height: 100vh; background-color: #f5f5f5; width: 100%;">
        @include('layouts.staff-navigation')

        <div class="admin-main" style="flex: 1; margin-left: 260px; background-color: #f5f5f5; width: calc(100% - 260px); min-height: 100vh; display: flex; flex-direction: column;">
            <!-- Page Heading -->
            @isset($header)
                <header class="admin-header" style="background-color: white; border-bottom: 1px solid #e3e3e0; padding: 1.5rem 0; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); margin-bottom: 2rem;">
                    <div class="container" style="max-width: 100%; margin: 0 auto; padding: 0 1.5rem; width: 100%;">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="container py-8" style="flex: 1; width: 100%; max-width: 100%; margin: 0 auto; padding: 2rem 1.5rem; background-color: white; border-radius: 8px; margin: 0 1.5rem 2rem 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
