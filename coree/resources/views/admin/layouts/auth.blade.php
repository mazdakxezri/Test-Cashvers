<!DOCTYPE html>
<html lang="en">

<head>
    <x-admin.header />
    @yield('styles')
</head>

<body class="d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">

            @yield('content')

        </div>
    </div>

    @yield('scripts')


</body>

</html>
