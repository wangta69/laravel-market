<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    @hasSection('canonical')

    @endif
    @hasSection('base') <base href="@yield('base', '')"> @endif
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--Title and Meta--}}
    {{--@meta--}}
    @yield('meta')
    <title>@yield('title', config('app.name', '온스토리'))</title>

    <!-- Scripts -->

    {{--Common App Styles--}}
   
    <!-- Fonts -->
    <!-- <link rel="icon" type="image/png" href="/assets/images/favicon.png" /> -->
    <link rel="icon" type="image/ico" href="/market/assets/images/favicon.ico">
    {{--Styles--}}
    @yield('styles')
    <!-- Styles -->


    {{--Head--}}
    @yield('head')
    
</head>
<body class="@yield('body_class')" vocab="https://schema.org/">
    {{--Page--}}
    @yield('page')
</body>
{{--Laravel Js Variables--}}
{{--@tojs--}}
{{--Scripts--}}

@yield('scripts')
</html>
