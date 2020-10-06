<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
        
        <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/docs.css')}}">
        <link rel="stylesheet" href="{{asset('css/highlighter.css')}}">
        <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">

        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('js/adminlte.min.js')}}"></script>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
        <div class="wrapper">
            @yield('navbar', View::make('admin.layout.navbar'))
            @yield('sidebar', View::make('admin.layout.sidebar'))
            @yield('content')
            @yield('footer', View::make('admin.layout.footer'))
        </div>                
    </body>
</html>