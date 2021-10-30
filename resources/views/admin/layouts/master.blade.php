<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <title>@yield('title','Admin -- Dashboard')</title>
    @include('admin.layouts.links')
    @stack('links')
</head>

<body class="sb-nav-fixed">
    {{-- navbar --}}
    @include('admin.layouts.header')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('admin.layouts.left-sidebar')
        </div>
        <div id="layoutSidenav_content">
            @yield('content')
            @include('admin.layouts.footer')
        </div>
    </div>
    @include('admin.layouts.scripts')
    @stack('scripts')
</body>

</html>
