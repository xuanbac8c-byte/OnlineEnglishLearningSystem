<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite([
    'resources/scss/app.scss',
    'resources/js/app.js'
])
</head>
<body>
    @include('components.navbar')
        <main>
            @yield('content')
        </main>
    @include('components.footer')
</body>
</html>