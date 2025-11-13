<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>{{ SiteName() }} | @yield('title', 'Home')</title>
<link rel="icon" type="image/png" href="{{ url(siteFav()) }}" />

<!-- SEO meta tags -->
<meta name="description" content="{{ seoDescription() }}" />
<meta name="keywords" content="{{ seoKeywords() }}" />

<!-- CSS files -->
<link rel="stylesheet"
    href="{{ asset('assets/' . $activeTemplate . '/css/bootstrap.min.css') }}?v={{ config('app.version') }}" />
<link rel="stylesheet"
    href="{{ asset('assets/' . $activeTemplate . '/css/clean-design-system.css') }}?v={{ config('app.version') }}" />
<link rel="stylesheet"
    href="{{ asset('assets/' . $activeTemplate . '/css/space-design-system.css') }}?v={{ config('app.version') }}" />
<link rel="stylesheet"
    href="{{ asset('assets/' . $activeTemplate . '/css/preloader.css') }}?v={{ config('app.version') }}" />
<link rel="stylesheet"
    href="{{ asset('assets/' . $activeTemplate . '/css/cookie-fix.css') }}?v={{ config('app.version') }}" />

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet" />
