 @if (siteLogo())
     <img src="{{ url(siteLogo()) }}" alt="{{ siteName() }}" class="img-fluid logo">
 @else
     {{ siteName() }}
 @endif
