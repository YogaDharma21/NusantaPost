<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @stack('before-styles')
    <link href="{{ asset('./css/output.css') }}" rel="stylesheet" />
    <link href="{{ asset('./css/main.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    @stack('after-styles')
</head>
@yield('content')
@stack('before-scripts')
@stack('after-scripts')

</html>
