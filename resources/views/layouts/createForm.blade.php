<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/datepicker.min.js"></script>
        <script src="{{ asset('js/utils.js') }}"></script>
        
    </head>
    @routes
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            {{-- @include('layouts.navigation') --}}

            <!-- Page Heading -->
            <header>
                @yield('header')
            </header>
            <!-- Page Content -->
            <main class="px-4 lg:px-8">
                @yield('content')
            </main>
        </div>
    </body>
</html>
