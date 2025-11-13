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
                            <span style="color: rgba(255, 255, 255, 0.4); font-size: 14px; font-family: 'Inter', sans-serif;">OR CONTINUE WITH</span>
                        </div>
                        
                        <div style="display: grid; gap: 12px;">
                            <a href="{{ route('discord.redirect') }}" class="oauth-btn oauth-discord">
                                <svg width="20" height="20" viewBox="0 0 71 55" fill="currentColor">
                                    <path d="M60.1045 4.8978C55.5792 2.8214 50.7265 1.2916 45.6527 0.41542C45.5603 0.39851 45.468 0.440769 45.4204 0.525289C44.7963 1.6353 44.105 3.0834 43.6209 4.2216C38.1637 3.4046 32.7345 3.4046 27.3892 4.2216C26.905 3.0581 26.1886 1.6353 25.5617 0.525289C25.5141 0.443589 25.4218 0.40133 25.3294 0.41542C20.2584 1.2888 15.4057 2.8186 10.8776 4.8978C10.8384 4.9147 10.8048 4.9429 10.7825 4.9795C1.57795 18.7309 -0.943561 32.1443 0.293408 45.3914C0.299005 45.4562 0.335386 45.5182 0.385761 45.5576C6.45866 50.0174 12.3413 52.7249 18.1147 54.5195C18.2071 54.5477 18.305 54.5139 18.3638 54.4378C19.7295 52.5728 20.9469 50.6063 21.9907 48.5383C22.0523 48.4172 21.9935 48.2735 21.8676 48.2256C19.9366 47.4931 18.0979 46.6 16.3292 45.5858C16.1893 45.5041 16.1781 45.304 16.3068 45.2082C16.679 44.9293 17.0513 44.6391 17.4067 44.3461C17.471 44.2926 17.5606 44.2813 17.6362 44.3151C29.2558 49.6202 41.8354 49.6202 53.3179 44.3151C53.3935 44.2785 53.4831 44.2898 53.5502 44.3433C53.9057 44.6363 54.2779 44.9293 54.6529 45.2082C54.7816 45.304 54.7732 45.5041 54.6333 45.5858C52.8646 46.6197 51.0259 47.4931 49.0921 48.2228C48.9662 48.2707 48.9102 48.4172 48.9718 48.5383C50.038 50.6034 51.2554 52.5699 52.5959 54.435C52.6519 54.5139 52.7526 54.5477 52.845 54.5195C58.6464 52.7249 64.529 50.0174 70.6019 45.5576C70.6551 45.5182 70.6887 45.459 70.6943 45.3942C72.1747 30.0791 68.2147 16.7757 60.1968 4.9823C60.1772 4.9429 60.1437 4.9147 60.1045 4.8978ZM23.7259 37.3253C20.2276 37.3253 17.3451 34.1136 17.3451 30.1693C17.3451 26.225 20.1717 23.0133 23.7259 23.0133C27.308 23.0133 30.1626 26.2532 30.1066 30.1693C30.1066 34.1136 27.28 37.3253 23.7259 37.3253ZM47.3178 37.3253C43.8196 37.3253 40.9371 34.1136 40.9371 30.1693C40.9371 26.225 43.7636 23.0133 47.3178 23.0133C50.9 23.0133 53.7545 26.2532 53.6986 30.1693C53.6986 34.1136 50.9 37.3253 47.3178 37.3253Z"/>
                                </svg>
                                Sign in with Discord
                            </a>
                            
                            <a href="{{ route('steam.redirect') }}" class="oauth-btn oauth-steam">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2a10 10 0 0 1 10 10 10 10 0 0 1-10 10C6.48 22 2 17.52 2 12L11.36 15.62a2.996 2.996 0 0 0 4.16-2.78c0-1.65-1.35-3-3-3-.63 0-1.22.21-1.7.54L7.27 8.14A4.498 4.498 0 0 1 16.5 10.5c0 2.48-2.02 4.5-4.5 4.5-.8 0-1.54-.21-2.19-.57L2 12a10 10 0 0 1 10-10m0-2C6.48 0 2 4.48 2 10c0 5.52 4.48 10 10 10s10-4.48 10-10S17.52 0 12 0z"/>
                                </svg>
                                Sign in with Steam
                            </a>
                            
                            <a href="{{ route('google.redirect') }}" class="oauth-btn oauth-google">
                                <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/google.svg') }}"
                                    alt="google" style="width: 20px; height: 20px;" />
                                Sign in with Google
                            </a>
                        </div>
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
                            <span style="color: rgba(255, 255, 255, 0.4); font-size: 14px; font-family: 'Inter', sans-serif;">OR CONTINUE WITH</span>
                        </div>
                        
                        <div style="display: grid; gap: 12px;">
                            <a href="{{ route('discord.redirect') }}" class="oauth-btn oauth-discord">
                                <svg width="20" height="20" viewBox="0 0 71 55" fill="currentColor">
                                    <path d="M60.1045 4.8978C55.5792 2.8214 50.7265 1.2916 45.6527 0.41542C45.5603 0.39851 45.468 0.440769 45.4204 0.525289C44.7963 1.6353 44.105 3.0834 43.6209 4.2216C38.1637 3.4046 32.7345 3.4046 27.3892 4.2216C26.905 3.0581 26.1886 1.6353 25.5617 0.525289C25.5141 0.443589 25.4218 0.40133 25.3294 0.41542C20.2584 1.2888 15.4057 2.8186 10.8776 4.8978C10.8384 4.9147 10.8048 4.9429 10.7825 4.9795C1.57795 18.7309 -0.943561 32.1443 0.293408 45.3914C0.299005 45.4562 0.335386 45.5182 0.385761 45.5576C6.45866 50.0174 12.3413 52.7249 18.1147 54.5195C18.2071 54.5477 18.305 54.5139 18.3638 54.4378C19.7295 52.5728 20.9469 50.6063 21.9907 48.5383C22.0523 48.4172 21.9935 48.2735 21.8676 48.2256C19.9366 47.4931 18.0979 46.6 16.3292 45.5858C16.1893 45.5041 16.1781 45.304 16.3068 45.2082C16.679 44.9293 17.0513 44.6391 17.4067 44.3461C17.471 44.2926 17.5606 44.2813 17.6362 44.3151C29.2558 49.6202 41.8354 49.6202 53.3179 44.3151C53.3935 44.2785 53.4831 44.2898 53.5502 44.3433C53.9057 44.6363 54.2779 44.9293 54.6529 45.2082C54.7816 45.304 54.7732 45.5041 54.6333 45.5858C52.8646 46.6197 51.0259 47.4931 49.0921 48.2228C48.9662 48.2707 48.9102 48.4172 48.9718 48.5383C50.038 50.6034 51.2554 52.5699 52.5959 54.435C52.6519 54.5139 52.7526 54.5477 52.845 54.5195C58.6464 52.7249 64.529 50.0174 70.6019 45.5576C70.6551 45.5182 70.6887 45.459 70.6943 45.3942C72.1747 30.0791 68.2147 16.7757 60.1968 4.9823C60.1772 4.9429 60.1437 4.9147 60.1045 4.8978ZM23.7259 37.3253C20.2276 37.3253 17.3451 34.1136 17.3451 30.1693C17.3451 26.225 20.1717 23.0133 23.7259 23.0133C27.308 23.0133 30.1626 26.2532 30.1066 30.1693C30.1066 34.1136 27.28 37.3253 23.7259 37.3253ZM47.3178 37.3253C43.8196 37.3253 40.9371 34.1136 40.9371 30.1693C40.9371 26.225 43.7636 23.0133 47.3178 23.0133C50.9 23.0133 53.7545 26.2532 53.6986 30.1693C53.6986 34.1136 50.9 37.3253 47.3178 37.3253Z"/>
                                </svg>
                                Sign up with Discord
                            </a>
                            
                            <a href="{{ route('steam.redirect') }}" class="oauth-btn oauth-steam">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2a10 10 0 0 1 10 10 10 10 0 0 1-10 10C6.48 22 2 17.52 2 12L11.36 15.62a2.996 2.996 0 0 0 4.16-2.78c0-1.65-1.35-3-3-3-.63 0-1.22.21-1.7.54L7.27 8.14A4.498 4.498 0 0 1 16.5 10.5c0 2.48-2.02 4.5-4.5 4.5-.8 0-1.54-.21-2.19-.57L2 12a10 10 0 0 1 10-10m0-2C6.48 0 2 4.48 2 10c0 5.52 4.48 10 10 10s10-4.48 10-10S17.52 0 12 0z"/>
                                </svg>
                                Sign up with Steam
                            </a>
                            
                            <a href="{{ route('google.redirect') }}" class="oauth-btn oauth-google">
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

/* OAuth Buttons */
.oauth-btn {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    font-weight: 500;
    font-size: 15px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-family: 'Inter', sans-serif;
}

.oauth-discord {
    background: rgba(88, 101, 242, 0.1);
    color: #5865F2;
    border-color: rgba(88, 101, 242, 0.3);
}

.oauth-discord:hover {
    background: rgba(88, 101, 242, 0.2);
    border-color: #5865F2;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(88, 101, 242, 0.3);
}

.oauth-steam {
    background: rgba(23, 26, 33, 0.3);
    color: #c7d5e0;
    border-color: rgba(199, 213, 224, 0.2);
}

.oauth-steam:hover {
    background: rgba(23, 26, 33, 0.5);
    border-color: #c7d5e0;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(199, 213, 224, 0.2);
}

.oauth-google {
    background: rgba(255, 255, 255, 0.05);
    color: white;
    border-color: rgba(255, 255, 255, 0.1);
}

.oauth-google:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}
</style>

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

/* OAuth Buttons */
.oauth-btn {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    font-weight: 500;
    font-size: 15px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-family: 'Inter', sans-serif;
}

.oauth-discord {
    background: rgba(88, 101, 242, 0.1);
    color: #5865F2;
    border-color: rgba(88, 101, 242, 0.3);
}

.oauth-discord:hover {
    background: rgba(88, 101, 242, 0.2);
    border-color: #5865F2;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(88, 101, 242, 0.3);
}

.oauth-steam {
    background: rgba(23, 26, 33, 0.3);
    color: #c7d5e0;
    border-color: rgba(199, 213, 224, 0.2);
}

.oauth-steam:hover {
    background: rgba(23, 26, 33, 0.5);
    border-color: #c7d5e0;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(199, 213, 224, 0.2);
}

.oauth-google {
    background: rgba(255, 255, 255, 0.05);
    color: white;
    border-color: rgba(255, 255, 255, 0.1);
}

.oauth-google:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}
</style>
