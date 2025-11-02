<!DOCTYPE html>
<html lang="en">

<head>
    <x-admin.header />
    @yield('styles')
</head>

<body>
    <div class="page">
        <x-admin.navbar />
        <div class="page-wrapper">

            @yield('content')

            <x-admin.footer />
        </div>

    </div>
    <script src="{{ asset('assets/panel/dist/js/tabler.min.js') }}" defer></script>
    @yield('scripts')
    @stack('scripts')
</body>

</html>
