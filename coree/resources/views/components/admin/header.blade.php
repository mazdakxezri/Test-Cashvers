 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
 <meta http-equiv="X-UA-Compatible" content="ie=edge" />
 <title>{{ SiteName() }} | @yield('title', 'Home')</title>
 <link rel="icon" type="image/png" href="{{ url(siteFav()) }}" />

 <!-- CSS files -->
 <link href="{{ asset('assets/panel/dist/css/tabler.min.css') }}" rel="stylesheet" />
 <link href="{{ asset('assets/panel/dist/css/tabler-vendors.min.css') }}" rel="stylesheet" />
 <style>
     @import url("https://rsms.me/inter/inter.css");

     :root {
         --tblr-font-sans-serif: "Inter Var", -apple-system, BlinkMacSystemFont,
             San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
     }

     body {
         font-feature-settings: "cv03", "cv04", "cv11";
     }
 </style>
