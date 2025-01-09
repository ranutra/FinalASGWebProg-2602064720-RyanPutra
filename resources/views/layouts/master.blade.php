<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('customs.bootstrap5')
    <title>Connect Friend</title>
</head>

<body>
    <div class="container-fluid m-0 p-0 w-100 h-100">
        @include('layouts.navbar')

        <div>
            @yield('content')
        </div>

        @include('layouts.footer')
    </div>
</body>

</html>
