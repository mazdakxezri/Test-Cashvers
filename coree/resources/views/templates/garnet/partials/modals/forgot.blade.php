<div class="modal auth fade" id="forgotModal" aria-hidden="true" aria-labelledby="forgotModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pb-0">
            <div class="dark-name">
                <span class="d-none d-md-block">{{ SiteName() }}</span>
            </div>
            <div class="modal-header px-5">
                <h5 class="modal-title" id="forgotModalLabel">{{ SiteName() }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-5">
                    @include($activeTemplate . '.partials.alerts.alerts')
                    <p>Enter your email address associated with
                        your {{ SiteName() }} account.</p>

                    <form action="{{ route('auth.password.forgot') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div class="position-relative">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    required placeholder="Email Address" />
                                <svg class="icon" width="18" height="14" viewBox="0 0 18 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13 13H5C2.6 13 1 11.9412 1 9.47059V4.52941C1 2.05882 2.6 1 5 1H13C15.4 1 17 2.05882 17 4.52941V9.47059C17 11.9412 15.4 13 13 13Z"
                                        stroke="#CCCCCC" stroke-width="1.3" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M12.8876 5.35913L10.4069 7.34056C9.59052 7.99046 8.25107 7.99046 7.43473 7.34056L4.96191 5.35913"
                                        stroke="#CCCCCC" stroke-width="1.3" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>


                        <div class="d-flex justify-content-between forgot">
                            <button type="submit" class="btn primary-btn fs-12 px-5 text-capitalize">send</button>
                            <button type="button" class="btn secondary-btn text-center fs-12 px-5 text-capitalize"
                                data-bs-dismiss="modal">return
                                back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
