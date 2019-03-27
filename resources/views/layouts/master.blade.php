<!doctype html>
<html lang='en'>
<head>
    <title>@yield('title')</title>
    <meta charset='utf-8'>

    <link href='/css/project-3.css' rel='stylesheet'>

    @yield('head')
</head>
<body>

<header>
    <a href='/'><img src='/images/project3-logo@2x.png' id='logo' alt='Project 3 Logo'></a>
</header>

<section>
    @yield('content')
</section>

<footer>
    &copy; {{ date('Y') }}
</footer>

</body>
</html>
