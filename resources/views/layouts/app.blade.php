
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    @include('layouts.style')
</head>

<body>
    @include('layouts.sidebar')
    @include('layouts.header')

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                @yield('content')
                @include('layouts.footer')
            </div>
        </div>
    </div>

    @include('layouts.script')
    @include('sweetalert::alert')

</body>

</html>
