<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    @include('template.partials.loader')
    <link href="{{ asset('adminator/assets/static/fonts/themify-icons.css') }}" rel="stylesheet">

    {{-- Đường dẫn CSS --}}
    <link href="{{ asset('adminator/style.css') }}" rel="stylesheet">
</head>

<body class="app">
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <script>
        window.addEventListener('load', function load() {
            const loader = document.getElementById('loader');
            setTimeout(function () {
                loader.classList.add('fadeOut');
            }, 300);
        });
    </script>

    <div>
        {{-- Sidebar --}}
        @include('template.partials.sidebar')

        <div class="page-container">
            {{-- Navbar --}}
            @include('template.partials.navbar')

            <main class="main-content bgc-grey-100">
                <div id="mainContent">
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            @include('template.partials.footer')
        </div>
    </div>

    {{-- Đường dẫn JS --}}
    <script src="{{ asset('adminator/vendor.js') }}"></script>
    <script src="{{ asset('adminator/bundle.js') }}"></script>
</body>

</html>
