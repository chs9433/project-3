<!doctype html>
<html lang='en'>
<head>
    <title>@yield('title')</title>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href='/css/project-3.css' rel='stylesheet'>
    @yield('head')
</head>
<body>
<div class="container">
    <section>
        @yield('content')
    </section>

    <section>
        @yield('results')
    </section>
    <footer>
        &copy; {{ date('Y') }}
    </footer>
</div>
</body>
</html>
