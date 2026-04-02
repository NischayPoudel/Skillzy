<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Skillzy') }}</title>

        <!-- Custom Bauhaus CSS - No Build Process Needed -->
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    </head>
    <body class="font-outfit antialiased bg-canvas text-foreground">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="section-divider py-6 lg:py-8">
                    <div class="section-container">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                <div class="section-container px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
                    {{ $slot }}
                </div>
            </main>

            @include('layouts.footer')
        </div>
    </body>
</html>
