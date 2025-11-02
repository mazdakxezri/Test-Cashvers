      <footer class="footer-sticky">
          <div class="container-fluid">
              <div class="row align-items-center text-center text-xl-start pt-4 pb-2">
                  <div class="col-12 col-xl-6 mb-3 mb-xl-0">
                      <a href="{{ auth()->check() ? route('earnings.index') : route('home') }}" class="footer-logo">
                          @include($activeTemplate . '.partials.logo')
                      </a>
                  </div>
                  <div class="col-12 col-xl-6 d-flex justify-content-center justify-content-xl-end">
                      <div class="footer-social d-flex gap-3">
                          @php
                              $socialLinks = json_decode(socialMediaLink(), true) ?? [];
                          @endphp

                          @foreach ($socialLinks as $social)
                              <a href="{{ $social['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer">
                                  <img src="{{ asset($social['icon']) }}" alt="{{ ucfirst($social['name']) }}"
                                      class="img-fluid" />
                              </a>
                          @endforeach
                      </div>
                  </div>
              </div>
              <hr />
              <div class="row pt-3 text-center text-xl-start">
                  <div class="col-12 col-xl-6 mb-3 mb-xl-0">
                      <p class="opacity-50 mb-0">
                          © {{ date('Y') }} {{ SiteName() }}. All rights reserved.
                      </p>
                  </div>
                  <div
                      class="col-12 col-xl-6 d-flex flex-column flex-xl-row justify-content-center justify-content-xl-end gap-3 footer-links">
                      <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#contactModal">contact us</a>
                      <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                      <a href="{{ route('terms.of.use') }}">Terms of Services</a>
                      <a href="/academy">Academy</a>
                  </div>
              </div>
          </div>
      </footer>
