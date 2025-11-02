<div class="modal auth fade" id="authModal" aria-hidden="true" aria-labelledby="authModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pb-0">
            <div class="dark-name">
                <span class="d-none d-md-block">{{ SiteName() }}</span>
            </div>
            <div class="modal-header px-5">
                <h5 class="modal-title" id="authModalLabel">{{ SiteName() }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-0 pt-0">
                <!-- Navs for switching between forms -->
                <ul class="nav nav-tabs mb-4 border-0" id="authTab" role="tablist">
                    <li class="nav-item col-6" role="presentation">
                        <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab"
                            aria-controls="login" aria-selected="true">Login</a>
                    </li>
                    <li class="nav-item col-6" role="presentation">
                        <a class="nav-link" id="create-account-tab" data-bs-toggle="tab" href="#create-account"
                            role="tab" aria-controls="create-account" aria-selected="false">Create
                            Account</a>
                    </li>
                </ul>
                <!-- Tab content -->
                <div class="tab-content" id="authTabContent">
                    <!-- Login Form -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        @include($activeTemplate . '.partials.alerts.alerts')
                        <form action="{{ route('auth.signin') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <div class="position-relative">
                                    <input type="email" class="form-control" name="email" id="loginEmail"
                                        value="{{ old('email') }}" required placeholder="Email Address" />
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
                            <div class="mb-2">
                                <div class="position-relative">
                                    <input type="password" class="form-control" name="password" id="loginPassword"
                                        required placeholder="Password" />
                                    <svg class="icon" width="17" height="17" viewBox="0 0 17 17" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3.99902 7V5.5C3.99902 3.0175 4.74902 1 8.49902 1C12.249 1 12.999 3.0175 12.999 5.5V7"
                                            stroke="#CCCCCC" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M8.5 13.375C9.53553 13.375 10.375 12.5355 10.375 11.5C10.375 10.4645 9.53553 9.625 8.5 9.625C7.46447 9.625 6.625 10.4645 6.625 11.5C6.625 12.5355 7.46447 13.375 8.5 13.375Z"
                                            stroke="#CCCCCC" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M12.25 16H4.75C1.75 16 1 15.25 1 12.25V10.75C1 7.75 1.75 7 4.75 7H12.25C15.25 7 16 7.75 16 10.75V12.25C16 15.25 15.25 16 12.25 16Z"
                                            stroke="#CCCCCC" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="javascript:void(0)" class="text-white fs-12 fw-light forget"
                                    data-bs-toggle="modal" data-bs-target="#forgotModal">Forgot your
                                    password?</a>
                            </div>
                            {!! renderCaptcha() !!}

                            <button type="submit" class="btn primary-btn w-100 fs-12">
                                Login
                            </button>
                        </form>

                        <div class="other-auth my-3">
                            <div class="mb-3">
                                <span class="separator">OR</span>
                            </div>
                            <a href="{{ route('auth.google.redirect') }}" class="google-btn w-100 fs-12"><img
                                    src="{{ asset('assets/' . $activeTemplate . '/images/icons/google.svg') }}"
                                    alt="google" class="img-fluid pe-2" />Sign in with Google</a>
                        </div>
                    </div>

                    <!-- Create Account Form -->
                    <div class="tab-pane fade" id="create-account" role="tabpanel"
                        aria-labelledby="create-account-tab">
                        @include($activeTemplate . '.partials.alerts.alerts')

                        <form action="{{ route('auth.signup.store') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <div class="position-relative">
                                    <input type="text" class="form-control" name="name" id="fullname"
                                        value="{{ old('name') }}" required placeholder="John Doe" />

                                    <svg class="icon" width="15" height="18" viewBox="0 0 15 18"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="7.53309" cy="4.55556" r="3.55556" stroke="#CCCCCC"
                                            stroke-width="1.3" />
                                        <path
                                            d="M11.0888 17.0001H3.97765C2.01397 17.0001 0.279998 15.277 1.30366 13.6012C2.30459 11.9627 4.24182 10.7778 7.53321 10.7778C10.8246 10.7778 12.7618 11.9627 13.7628 13.6012C14.7864 15.277 13.0524 17.0001 11.0888 17.0001Z"
                                            stroke="#CCCCCC" stroke-width="1.3" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="position-relative">
                                    <input type="email" class="form-control" name="email" id="createEmail"
                                        value="{{ old('email') }}" required placeholder="Email Address" />
                                    <svg class="icon" width="18" height="14" viewBox="0 0 18 14"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
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
                            <div class="mb-2">
                                <div class="position-relative">
                                    <input type="password" class="form-control" name="password" id="createPassword"
                                        required placeholder="Password" />
                                    <svg class="icon" width="17" height="17" viewBox="0 0 17 17"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3.99902 7V5.5C3.99902 3.0175 4.74902 1 8.49902 1C12.249 1 12.999 3.0175 12.999 5.5V7"
                                            stroke="#CCCCCC" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M8.5 13.375C9.53553 13.375 10.375 12.5355 10.375 11.5C10.375 10.4645 9.53553 9.625 8.5 9.625C7.46447 9.625 6.625 10.4645 6.625 11.5C6.625 12.5355 7.46447 13.375 8.5 13.375Z"
                                            stroke="#CCCCCC" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M12.25 16H4.75C1.75 16 1 15.25 1 12.25V10.75C1 7.75 1.75 7 4.75 7H12.25C15.25 7 16 7.75 16 10.75V12.25C16 15.25 15.25 16 12.25 16Z"
                                            stroke="#CCCCCC" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mb-2">
                                <span class="text-white fs-12 fw-light forget text-decoration-none">
                                    By signing up you agree to our

                                    <a href="{{ route('terms.of.use') }}" target="_blank"
                                        class="text-decoration-underline text-white fs-12 fw-light">
                                        terms and conditions
                                    </a>
                                    as well as
                                    <a href="{{ route('privacy.policy') }}" target="_blank"
                                        class="text-decoration-underline text-white fs-12 fw-light">
                                        Privacy Policy </a>.
                                </span>
                            </div>
                            {!! renderCaptcha() !!}
                            <button type="submit" class="btn primary-btn w-100 fs-12">
                                Create Account
                            </button>
                        </form>
                        <div class="other-auth my-3">
                            <div class="mb-3">
                                <span class="separator">OR</span>
                            </div>
                            <a href="{{ route('auth.google.redirect') }}" class="google-btn w-100 fs-12"><img
                                    src="{{ asset('assets/' . $activeTemplate . '/images/icons/google.svg') }}"
                                    alt="google" class="img-fluid pe-2" />Sign
                                up with Google</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
