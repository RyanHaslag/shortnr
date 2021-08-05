<!doctype html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200,400;600;700&display=swap" rel="stylesheet">

    <script src="{{ mix('/js/app.js') }}" defer></script>

    @yield('title')
</head>
<body>
        @yield('content')
</body>
