<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel FullStack Blog</title>

    <link rel="stylesheet" href="/css/all.css">
    <script>
        (function() {
            window.Laravel = {
            csrfToken: '{{ csrf_token()}}'
        };
        })();

    </script>

</head>

<body>
   <h1 class="_text_center">You are not authorized to access this page</h1>
</body>

</html>