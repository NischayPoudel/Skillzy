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
        <!-- Bauhaus Auth Layout -->
        <div class="min-h-screen flex flex-col auth-container">
            <!-- Left Panel - Brand & Info -->
            <div class="auth-left">
                <!-- Geometric decorations -->
                <div class="shape-circle shape-red"></div>
                <div class="shape-triangle shape-yellow"></div>
                
                <div class="auth-brand">
                    <div class="brand-shapes">
                        <div class="shape-red-circle"></div>
                        <div class="shape-yellow-square"></div>
                        <div class="shape-white-triangle"></div>
                    </div>
                    <h1 class="text-5xl font-black uppercase tracking-tighter leading-tight mb-4">Skillzy</h1>
                    <p class="text-lg font-bold opacity-90">Exchange Skills. Build Community.</p>
                </div>
            </div>

            <!-- Right Panel - Auth Form -->
            <div class="auth-right">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
