<!doctype html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;700&display=swap" rel="stylesheet">

    <script src="{{ mix('/js/app.js') }}" defer></script>

    @yield('title')
</head>
<body>
    <div class="py-4 pr-12 float-right">
        <a class="pr-4 text-lg" href="/">Home</a>
        <a class="text-lg" href="/top">Top 100</a>
    </div>
    <div class="clear-both"></div>
    @yield('content')
</body>
