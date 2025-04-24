<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>Hand Over</title>
    <link rel="shortcut icon" href="{{ url("images/Logo.ico") }}">
    <link rel="stylesheet" type="text/css" href="{{ url("css/all.min.css") }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset("js/jquery.min.js") }}"></script>
    <script src="{{ asset("js/sweetalert2.js") }}"></script>
    @vite("resources/css/app.css")
</head>

<body class="relative bg-[#eafffa]">
    @yield("content")
</body>
@yield("scripts")

</html>
