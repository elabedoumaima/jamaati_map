<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/logo.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'جماعتي')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @yield('content')
    
    <!-- JavaScript -->
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')
</body>
</html>