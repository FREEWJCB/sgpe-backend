<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Reporte - @yield('title')</title>
    <!-- Bootstrap -->
    </head>
    <style>

        *, ::after, ::before {
            box-sizing: border-box;
        }

        @page {
            margin: 0cm 0cm;
            font-family: Arial;
	        page-break-after: always;
        }

        body {
            margin: 2cm 2cm 2cm;
            min-width: 100vh;
            min-height: 100vh;
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.5;
            position: relative;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.5cm;
            background-color: #76020d;
            color: white;
            text-align: center;
            line-height: 30px;
            margin: 0;
        }

        table {
            border-collapse: collapse;
            display: table;
            border-spacing: 2px;
            border-color: grey;
        }

        table thead th {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            text-align: center;
        }

        table td, table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            text-align: center;
        }

        th {
            text-align: inherit;
        }

        thead {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            background-color: color: #212529;
        }

        table tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.05);
        }

        .table {
            width: 650px;
        }
    </style>
    <body>
        <div class="table">
            <h1>@yield('encabezado')</h1>
            <table class="table">
                <thead class="thead-dark">
                    @yield('encabezados')
                </thead>
                <tbody>
                    @yield('contenido')
                </tbody>
            </table>
        </div>
    </body>
</html>
