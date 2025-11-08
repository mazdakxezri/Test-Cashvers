<div class="modal auth fade px-0" id="contactModal" aria-hidden="true" aria-labelledby="contactModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pb-0">
            <div class="dark-name">
                <span class="d-none d-md-block">{{ SiteName() }}</span>
            </div>
            <div class="modal-header px-5">
                <h5 class="modal-title" id="contactModalLabel">{{ SiteName() }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include($activeTemplate . '.partials.alerts.alerts')
                <p>We’d love to hear from you. Fill out the form below and we'll get back to you soon.</p>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class="position-relative">
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" required
                                placeholder="Full Name">
                            <svg class="icon" width="15" height="18" viewBox="0 0 15 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="7.53309" cy="4.55556" r="3.55556" stroke="#CCCCCC" stroke-width="1.3" />
                                <path
                                    d="M11.0888 17.0001H3.97765C2.01397 17.0001 0.279998 15.277 1.30366 13.6012C2.30459 11.9627 4.24182 10.7778 7.53321 10.7778C10.8246 10.7778 12.7618 11.9627 13.7628 13.6012C14.7864 15.277 13.0524 17.0001 11.0888 17.0001Z"
                                    stroke="#CCCCCC" stroke-width="1.3" />
                            </svg>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="position-relative">
                            <input type="text" class="form-control" name="email"
                                value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" required
                                placeholder="Email Address">
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
                            <input type="text" class="form-control" name="subject" value="{{ old('subject') }}"
                                required placeholder="Subject">
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
                            <textarea name="message" class="form-control" rows="4" required placeholder="Your message...">{{ old('message') }}</textarea>
                            <svg class="icon" width="18" height="14" viewBox="0 0 18 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13 13H5C2.6 13 1 11.9412 1 9.47059V4.52941C1 2.05882 2.6 1 5 1H13C15.4 1 17 2.05882 17 4.52941V9.47059C17 11.9412 15.4 13 13 13Z"
                                    stroke="#CCCCCC" stroke-width="1.3" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M12.8876 5.35913L10.4069 7.34056C9.59052 7.99046 8.25107 7.99046 7.43473 7.34056L4.96191 5.35913"
                                    stroke="#CCCCCC" stroke-width="1.3" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>


                    {!! renderCaptcha() !!}


                    <div class="d-flex justify-content-between contact">
                        <button type="submit" class="btn primary-btn fs-12 px-5 text-capitalize w-100">send</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
