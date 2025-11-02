<div class="modal auth fade" id="resetModal" aria-hidden="true" aria-labelledby="resetModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pb-0">
            <div class="dark-name">
                <span class="d-none d-md-block">{{ SiteName() }}</span>
            </div>
            <div class="modal-header px-5">
                <h5 class="modal-title" id="resetModalLabel">{{ SiteName() }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <p>Please provide the email address linked to your {{ SiteName() }} account for password reset.
                </p>
                @include($activeTemplate . '.partials.alerts.alerts')
                <!-- Email Input -->
                <form action="{{ route('auth.password.reset') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token ?? '' }}">
                    <div class="mb-3">
                        <div class="position-relative">
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', isset($email) ? $email : '') }}" required
                                placeholder="Email Address" />
                            <svg class="icon" width="18" height="14" viewBox="0 0 18 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13 13H5C2.6 13 1 11.9412 1 9.47059V4.52941C1 2.05882 2.6 1 5 1H13C15.4 1 17 2.05882 17 4.52941V9.47059C17 11.9412 15.4 13 13 13Z"
                                    stroke="#CCCCCC" stroke-width="1.3" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M12.8876 5.35913L10.4069 7.34056C9.59052 7.99046 8.25107 7.99046 7.43473 7.34056L4.96191 5.35913"
                                    stroke="#CCCCCC" stroke-width="1.3" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="position-relative">
                            <input type="password" class="form-control" name="password" required
                                placeholder="Password" />
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
                    <div class="mb-3">
                        <div class="position-relative">
                            <input type="password" class="form-control" name="password_confirmation" required
                                placeholder="Confirm Password" />
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


                    <button type="submit" class="btn primary-btn fs-12 px-5 text-capitalize w-100">reset
                        password</button>
                </form>

            </div>
        </div>
    </div>
</div>
