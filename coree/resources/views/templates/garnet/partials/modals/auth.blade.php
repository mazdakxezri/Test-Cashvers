<div class="modal auth fade" id="authModal" aria-hidden="true" aria-labelledby="authModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #0f0f15; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 20px; backdrop-filter: blur(20px); overflow: hidden;">
            
            <!-- Modal Header -->
            <div class="modal-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding: 28px 32px; background: rgba(0, 184, 212, 0.05);">
                <h5 class="modal-title" style="font-size: 24px; font-weight: 700; color: #ffffff; font-family: 'Inter', sans-serif;">{{ SiteName() }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: rgba(255, 255, 255, 0.1); opacity: 1; border-radius: 8px; width: 32px; height: 32px;"></button>
            </div>
            
            <div class="modal-body" style="padding: 0;">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs border-0" style="display: flex; background: rgba(0, 0, 0, 0.2);" id="authTab" role="tablist">
                    <li class="nav-item" style="flex: 1;" role="presentation">
                        <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab"
                            aria-controls="login" aria-selected="true"
                            style="text-align: center; padding: 20px; font-weight: 600; font-size: 15px; color: rgba(255, 255, 255, 0.6); border: none; background: transparent; border-bottom: 3px solid transparent; transition: all 0.3s ease; font-family: 'Inter', sans-serif;">
                            Login
                        </a>
                    </li>
                    <li class="nav-item" style="flex: 1;" role="presentation">
                        <a class="nav-link" id="create-account-tab" data-bs-toggle="tab" href="#create-account"
                            role="tab" aria-controls="create-account" aria-selected="false"
                            style="text-align: center; padding: 20px; font-weight: 600; font-size: 15px; color: rgba(255, 255, 255, 0.6); border: none; background: transparent; border-bottom: 3px solid transparent; transition: all 0.3s ease; font-family: 'Inter', sans-serif;">
                            Create Account
                        </a>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content" id="authTabContent" style="padding: 32px;">
                    
                    <!-- Login Form -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        @include($activeTemplate . '.partials.alerts.alerts')
                        <form action="{{ route('auth.signin') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label style="color: rgba(255, 255, 255, 0.8); font-size: 14px; font-weight: 500; margin-bottom: 8px; display: block; font-family: 'Inter', sans-serif;">Email Address</label>
                                <div class="position-relative">
                                    <input type="email" name="email" id="loginEmail"
                                        value="{{ old('email') }}" required placeholder="Enter your email"
                                        style="width: 100%; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 14px 48px 14px 16px; color: #ffffff; font-size: 15px; transition: all 0.3s ease; font-family: 'Inter', sans-serif;" />
                                    <svg class="icon" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); pointer-events: none;" width="18" height="14" viewBox="0 0 18 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13 13H5C2.6 13 1 11.9412 1 9.47059V4.52941C1 2.05882 2.6 1 5 1H13C15.4 1 17 2.05882 17 4.52941V9.47059C17 11.9412 15.4 13 13 13Z"
                                            stroke="#00B8D4" stroke-width="1.3" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M12.8876 5.35913L10.4069 7.34056C9.59052 7.99046 8.25107 7.99046 7.43473 7.34056L4.96191 5.35913"
                                            stroke="#00B8D4" stroke-width="1.3" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label style="color: rgba(255, 255, 255, 0.8); font-size: 14px; font-weight: 500; margin-bottom: 8px; display: block; font-family: 'Inter', sans-serif;">Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password" id="loginPassword"
                                        required placeholder="Enter your password"
                                        style="width: 100%; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 14px 48px 14px 16px; color: #ffffff; font-size: 15px; transition: all 0.3s ease; font-family: 'Inter', sans-serif;" />
                                    <svg class="icon" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); pointer-events: none;" width="17" height="17" viewBox="0 0 17 17" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3.99902 7V5.5C3.99902 3.0175 4.74902 1 8.49902 1C12.249 1 12.999 3.0175 12.999 5.5V7"
                                            stroke="#00B8D4" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M8.5 13.375C9.53553 13.375 10.375 12.5355 10.375 11.5C10.375 10.4645 9.53553 9.625 8.5 9.625C7.46447 9.625 6.625 10.4645 6.625 11.5C6.625 12.5355 7.46447 13.375 8.5 13.375Z"
                                            stroke="#00B8D4" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M12.25 16H4.75C1.75 16 1 15.25 1 12.25V10.75C1 7.75 1.75 7 4.75 7H12.25C15.25 7 16 7.75 16 10.75V12.25C16 15.25 15.25 16 12.25 16Z"
                                            stroke="#00B8D4" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#forgotModal"
                                   style="color: #00B8D4; font-size: 14px; font-weight: 500; text-decoration: none; font-family: 'Inter', sans-serif;">
                                    Forgot your password?
                                </a>
                            </div>
                            
                            {!! renderCaptcha() !!}

                            <button type="submit"
                                    style="width: 100%; background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); color: white; padding: 16px; border-radius: 12px; font-weight: 600; font-size: 16px; border: none; cursor: pointer; transition: all 0.3s ease; font-family: 'Inter', sans-serif; box-shadow: 0 4px 20px rgba(0, 184, 212, 0.3);">
                                Login
                            </button>
                        </form>

                        <div style="margin: 24px 0; text-align: center;">
                            <span style="color: rgba(255, 255, 255, 0.4); font-size: 14px; font-family: 'Inter', sans-serif;">OR</span>
                        </div>
                        
                        <a href="{{ route('auth.google.redirect') }}"
                           style="width: 100%; background: rgba(255, 255, 255, 0.05); color: white; padding: 14px; border-radius: 12px; font-weight: 500; font-size: 15px; border: 1px solid rgba(255, 255, 255, 0.1); display: flex; align-items: center; justify-content: center; gap: 12px; text-decoration: none; transition: all 0.3s ease; font-family: 'Inter', sans-serif;">
                            <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/google.svg') }}"
                                alt="google" style="width: 20px; height: 20px;" />
                            Sign in with Google
                        </a>
                    </div>

                    <!-- Create Account Form -->
                    <div class="tab-pane fade" id="create-account" role="tabpanel" aria-labelledby="create-account-tab">
                        @include($activeTemplate . '.partials.alerts.alerts')

                        <form action="{{ route('auth.signup.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label style="color: rgba(255, 255, 255, 0.8); font-size: 14px; font-weight: 500; margin-bottom: 8px; display: block; font-family: 'Inter', sans-serif;">Full Name</label>
                                <div class="position-relative">
                                    <input type="text" name="name" id="fullname"
                                        value="{{ old('name') }}" required placeholder="John Doe"
                                        style="width: 100%; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 14px 48px 14px 16px; color: #ffffff; font-size: 15px; transition: all 0.3s ease; font-family: 'Inter', sans-serif;" />
                                    <svg class="icon" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); pointer-events: none;" width="15" height="18" viewBox="0 0 15 18"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="7.53309" cy="4.55556" r="3.55556" stroke="#00B8D4"
                                            stroke-width="1.3" />
                                        <path
                                            d="M11.0888 17.0001H3.97765C2.01397 17.0001 0.279998 15.277 1.30366 13.6012C2.30459 11.9627 4.24182 10.7778 7.53321 10.7778C10.8246 10.7778 12.7618 11.9627 13.7628 13.6012C14.7864 15.277 13.0524 17.0001 11.0888 17.0001Z"
                                            stroke="#00B8D4" stroke-width="1.3" />
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label style="color: rgba(255, 255, 255, 0.8); font-size: 14px; font-weight: 500; margin-bottom: 8px; display: block; font-family: 'Inter', sans-serif;">Email Address</label>
                                <div class="position-relative">
                                    <input type="email" name="email" id="createEmail"
                                        value="{{ old('email') }}" required placeholder="Enter your email"
                                        style="width: 100%; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 14px 48px 14px 16px; color: #ffffff; font-size: 15px; transition: all 0.3s ease; font-family: 'Inter', sans-serif;" />
                                    <svg class="icon" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); pointer-events: none;" width="18" height="14" viewBox="0 0 18 14"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13 13H5C2.6 13 1 11.9412 1 9.47059V4.52941C1 2.05882 2.6 1 5 1H13C15.4 1 17 2.05882 17 4.52941V9.47059C17 11.9412 15.4 13 13 13Z"
                                            stroke="#00B8D4" stroke-width="1.3" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M12.8876 5.35913L10.4069 7.34056C9.59052 7.99046 8.25107 7.99046 7.43473 7.34056L4.96191 5.35913"
                                            stroke="#00B8D4" stroke-width="1.3" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label style="color: rgba(255, 255, 255, 0.8); font-size: 14px; font-weight: 500; margin-bottom: 8px; display: block; font-family: 'Inter', sans-serif;">Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password" id="createPassword"
                                        required placeholder="Create a password"
                                        style="width: 100%; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 14px 48px 14px 16px; color: #ffffff; font-size: 15px; transition: all 0.3s ease; font-family: 'Inter', sans-serif;" />
                                    <svg class="icon" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); pointer-events: none;" width="17" height="17" viewBox="0 0 17 17"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3.99902 7V5.5C3.99902 3.0175 4.74902 1 8.49902 1C12.249 1 12.999 3.0175 12.999 5.5V7"
                                            stroke="#00B8D4" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M8.5 13.375C9.53553 13.375 10.375 12.5355 10.375 11.5C10.375 10.4645 9.53553 9.625 8.5 9.625C7.46447 9.625 6.625 10.4645 6.625 11.5C6.625 12.5355 7.46447 13.375 8.5 13.375Z"
                                            stroke="#00B8D4" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M12.25 16H4.75C1.75 16 1 15.25 1 12.25V10.75C1 7.75 1.75 7 4.75 7H12.25C15.25 7 16 7.75 16 10.75V12.25C16 15.25 15.25 16 12.25 16Z"
                                            stroke="#00B8D4" stroke-width="1.3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <span style="color: rgba(255, 255, 255, 0.6); font-size: 13px; line-height: 1.6; font-family: 'Inter', sans-serif;">
                                    By signing up you agree to our
                                    <a href="{{ route('terms.service') }}" target="_blank"
                                        style="color: #00B8D4; text-decoration: none;">
                                        terms and conditions
                                    </a>
                                    as well as
                                    <a href="{{ route('privacy.policy') }}" target="_blank"
                                        style="color: #00B8D4; text-decoration: none;">
                                        Privacy Policy
                                    </a>.
                                </span>
                            </div>
                            
                            {!! renderCaptcha() !!}
                            
                            <button type="submit"
                                    style="width: 100%; background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); color: white; padding: 16px; border-radius: 12px; font-weight: 600; font-size: 16px; border: none; cursor: pointer; transition: all 0.3s ease; font-family: 'Inter', sans-serif; box-shadow: 0 4px 20px rgba(0, 184, 212, 0.3);">
                                Create Account
                            </button>
                        </form>
                        
                        <div style="margin: 24px 0; text-align: center;">
                            <span style="color: rgba(255, 255, 255, 0.4); font-size: 14px; font-family: 'Inter', sans-serif;">OR</span>
                        </div>
                        
                        <a href="{{ route('auth.google.redirect') }}"
                           style="width: 100%; background: rgba(255, 255, 255, 0.05); color: white; padding: 14px; border-radius: 12px; font-weight: 500; font-size: 15px; border: 1px solid rgba(255, 255, 255, 0.1); display: flex; align-items: center; justify-content: center; gap: 12px; text-decoration: none; transition: all 0.3s ease; font-family: 'Inter', sans-serif;">
                            <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/google.svg') }}"
                                alt="google" style="width: 20px; height: 20px;" />
                            Sign up with Google
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Tab Active State */
#authTab .nav-link.active {
    color: #00B8D4 !important;
    border-bottom-color: #00B8D4 !important;
}

#authTab .nav-link:hover {
    color: #00B8D4 !important;
}

/* Input Focus States */
input:focus {
    outline: none !important;
    border-color: #00B8D4 !important;
    box-shadow: 0 0 0 3px rgba(0, 184, 212, 0.1) !important;
}

/* Button Hover */
button[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(0, 184, 212, 0.4) !important;
}

a[href*="google"]:hover {
    background: rgba(255, 255, 255, 0.08) !important;
    border-color: rgba(255, 255, 255, 0.2) !important;
}
</style>
