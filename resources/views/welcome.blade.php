<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel FullStack Blog</title>

    <link rel="stylesheet" href="/css/all.css">

</head>

<body>
    <div id="app">

        <mainapp></mainapp>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>