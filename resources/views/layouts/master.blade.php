<!doctype html>
<html lang='en'>
<head>
    <title>@yield('title')</title>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
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
        &copy; {{ date('Y') }} Christopher Sheppard (DWA15)
    </footer>
</div>
</body>
</html>
