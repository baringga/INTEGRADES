<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'App')</title>
    @vite('resources/css/app.css')
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body>
    @include('partials.navbar')
    <main>
        @yield('content')
    </main>
</body>
</html>
