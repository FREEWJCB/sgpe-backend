<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Panel de control') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    {{--<link rel="stylesheet" href="{{ mix('css/app.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ mix('css/sapp.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ mix('css/custom.css') }}">--}}
    <style>
        @page {
            font-family: Nunito !important;
        }

        body {
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            background-color: #fff;
        }

        .font-sans {
            font-family: Nunito;
        }

        .card {
            word-wrap: break-word;
        }

        .divide-gray-200 td {
            border: 1px solid rgba(229, 231, 235, 1)
        }

        .divide-x {
            border-right-width: calc(1px * 0);
            border-left-width: calc(1px * calc(1 - 0));
        }

        .bg-gray-50 {
            background-color: rgba(229, 231, 235, 0.5);
        }

        .py-2 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        .px-3 {
            padding-right: 1rem !important;
            padding-left: 1rem !important;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .text-gray-900 {
            color: rgba(17, 24, 39, 0.5);
        }

        .fs-4 {
            font-size: 1.5rem !important;
        }

        .fw-bold {
            font-style: bold;
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }

        .text-xs {
            font-size: 0.75rem !important;
            line-height: 1rem !important;
        }

        .text-left {
            text-align: left;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .font-medium {
            font-weight: 500;
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .d-flex {
            display: flex !important;
        }

        table {
            border-collapse: collapse;
        }

        textarea {
            background-color: rgba(229, 231, 235, 0.5);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .d-inline-block {
            display: inline-block;
        }

        .p-relative {
            position: relative;
        }

        .fs-4 {
            font-size: 1.5rem !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .text-white {
            color: #fff !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-gray-900 {
            color: rgba(17, 24, 39, 1);
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body class="font-sans" width="100vh">

    <!-- Page Content -->
    <main class="container-xl container-fluid">
        @yield('contenido')
    </main>

</body>

</html>
