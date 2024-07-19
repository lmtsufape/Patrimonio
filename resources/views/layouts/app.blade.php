<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- title -->
        <title>{{ config('app.name', 'Laravel') }}</title>

         <!-- script -->
        <script defer="defer" src="//barra.brasil.gov.br/barra_2.0.js" type="text/javascript"></script>

        <!-- styles-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/layouts/footer.css">
        <link rel="stylesheet" href="/css/layouts/navbar.css">
        <link rel="stylesheet" href="/css/layouts/app.css">
        <link rel="stylesheet" href="/css/layouts/sidebar.css">
        @stack('styles')
    </head>

    <body class="d-flex flex-column min-vh-100 bg-light">

        <div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px;display:block;">
            <ul id="menu-barra-temp" style="list-style:none;">
                <li
                    style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED">
                    <a href="http://brasil.gov.br"
                        style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal
                        do Governo Brasileiro</a>
                </li>
            </ul>
        </div>

        @if (session('success'))
            <div class="text-md-center align-middle alert alert-success">
                {{ session('success') }}
            </div>

        @elseif(session('fail'))
            <div class="text-md-center align-middle alert alert-danger">
                {{ session('fail') }}
            </div>
        @endif

        @includeUnless(in_array(Route::currentRouteName(), ['login', 'register', 'password.request']), 'layouts.components.sidebar')

        <main class="flex-grow-1 container">
            @yield('content')
        </main>

        @include('layouts.components.footer')


        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        @stack('scripts')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#telefone-create, #telefone-edit').mask('(00) 00000-0000');
                $('#cpf').mask('000.000.000-00');
            });
        </script>
    </body>
</html>
