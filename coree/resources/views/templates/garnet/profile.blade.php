@extends($activeTemplate . '.layouts.app')
@section('title', 'Profile')

@section('content')
    <section class="cover px-xl-4 mb-3">
        <div class="row mx-0 my-3">

            <div class="col-12 col-lg-6 mb-3">
                <div class="profile-card d-flex align-items-center">
                    <div class="avatar">
                        <img src="{{ asset('assets/' . $activeTemplate . '/images/avatars/' . (Auth::user()->gender === 'male' ? '1.png' : (Auth::user()->gender === 'female' ? '2.png' : '1.png'))) }}"
                            alt="Avatar" class="img-fluid rounded-circle" />
                    </div>
                    <div class="profile-details ms-3 w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="mb-1">{{ Auth::user()->name }}</h2>
                            <form id="logout-form" class="d-none" action="{{ route('auth.logout') }}" method="POST">@csrf
                            </form>
                            <div class="logout" style="cursor: pointer;"
                                onclick="document.getElementById('logout-form').submit();">
                                <svg width="45" height="45" viewBox="0 0 45 45" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <foreignObject x="-20" y="-20" width="85" height="85">
                                        <div xmlns="http://www.w3.org/1999/xhtml"
                                            style="backdrop-filter:blur(10px);clip-path:url(#bgblur_0_928_1958_clip_path);height:100%;width:100%">
                                        </div>
                                    </foreignObject>
                                    <path data-figma-bg-blur-radius="20"
                                        d="M7.24264 1.75736C8.36786 0.632139 9.89398 0 11.4853 0H39C42.3137 0 45 2.68629 45 6V33.5147C45 35.106 44.3679 36.6321 43.2426 37.7574L37.7574 43.2426C36.6321 44.3679 35.106 45 33.5147 45H6C2.68629 45 0 42.3137 0 39V11.4853C0 9.89398 0.632141 8.36786 1.75736 7.24264L7.24264 1.75736Z"
                                        fill="white" fill-opacity="0.2" />
                                    <path
                                        d="M27.5694 26.5L31.125 23M31.125 23L27.5694 19.5M31.125 23H18.6806M24.0139 26.5V27.375C24.0139 28.8248 22.82 30 21.3472 30H17.7917C16.3189 30 15.125 28.8248 15.125 27.375V18.625C15.125 17.1753 16.3189 16 17.7917 16H21.3472C22.82 16 24.0139 17.1753 24.0139 18.625V19.5"
                                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <defs>
                                        <clipPath id="bgblur_0_928_1958_clip_path" transform="translate(20 20)">
                                            <path
                                                d="M7.24264 1.75736C8.36786 0.632139 9.89398 0 11.4853 0H39C42.3137 0 45 2.68629 45 6V33.5147C45 35.106 44.3679 36.6321 43.2426 37.7574L37.7574 43.2426C36.6321 44.3679 35.106 45 33.5147 45H6C2.68629 45 0 42.3137 0 39V11.4853C0 9.89398 0.632141 8.36786 1.75736 7.24264L7.24264 1.75736Z" />
                                        </clipPath>
                                    </defs>
                                </svg>

                            </div>
                        </div>

                        <div class="country d-flex align-items-center">
                            <img src="{{ asset('assets/images/flags/' . strtolower(Auth::user()->country_code) . '.svg') }}"
                                class="img-fluid rounded-circle border border-white" width="20" height="20"
                                alt="">

                            <span class="ms-2 text-uppercase">{{ getFullCountryName(Auth::user()->country_code) }}</span>

                        </div>

                    </div>
                </div>
                <div class="statistics profile-card mt-4 pb-0">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="stat-item d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 11L12 14L22 4"></path>
                                    <path d="M22 4H12L9 7L4 12L1 15"></path>
                                </svg>
                                <div>
                                    <p class="stat-title mb-0">Offers Completed</p>
                                    <p class="stat-value">{{ $offers_completed }}</p>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="stat-item d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path
                                        d="M17 5H9C7.895 5 7 5.895 7 7C7 8.105 7.895 9 9 9H15C16.105 9 17 9.895 17 11C17 12.105 16.105 13 15 13H9">
                                    </path>
                                </svg>
                                <div>
                                    <p class="stat-title mb-0">Total Earned</p>
                                    <p class="stat-value">{{ $offers_earning . ' ' . siteSymbol() }}</p>

                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="stat-item d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                    <path d="M9 7l6 0" />
                                    <path d="M9 11l6 0" />
                                    <path d="M9 15l4 0" />
                                </svg>
                                <div>
                                    <p class="stat-title mb-0">Surveys Completed</p>
                                    <p class="stat-value">{{ $survey_completed }}</p>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="stat-item d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="6" x2="12" y2="12"></line>
                                    <line x1="12" y1="12" x2="16.5" y2="16.5"></line>
                                </svg>
                                <div>
                                    <p class="stat-title mb-0">Surveys Earned</p>
                                    <p class="stat-value">{{ $survey_earning . ' ' . siteSymbol() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 mv-3">
                <div class="account-info profile-card">
                    <div class="d-flex justify-content-between">
                        <h3>Account info</h3>
                        <p>Date Joined: <span>{{ date('F j, Y', strtotime(Auth::user()->created_at)) }}</span></p>

                    </div>
                    <form method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <div class="position-relative">
                                    <input type="email" name="email" class="form-control" id="email" required
                                        placeholder="Email Adresse" value="{{ old('email', Auth::user()->email) }}" />
                                    <svg class="icon" width="18" height="14" viewBox="0 0 18 14"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13 13H5C2.6 13 1 11.9412 1 9.47059V4.52941C1 2.05882 2.6 1 5 1H13C15.4 1 17 2.05882 17 4.52941V9.47059C17 11.9412 15.4 13 13 13Z"
                                            stroke="#CCCCCC" stroke-width="1.3" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M12.8876 5.35913L10.4069 7.34056C9.59052 7.99046 8.25107 7.99046 7.43473 7.34056L4.96191 5.35913"
                                            stroke="#CCCCCC" stroke-width="1.3" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="position-relative">
                                    <input type="password" name="oldpassword" class="form-control" id="oldpassword"
                                        placeholder="Old Password" />

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


                            <div class="col-12 col-md-6 mb-3">
                                <div class="position-relative">
                                    <input type="text" name="name" class="form-control" id="name" required
                                        placeholder="Full Name" value="{{ Auth::user()->name }}" />

                                    <svg class="icon" width="15" height="18" viewBox="0 0 15 18"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="7.53309" cy="4.55556" r="3.55556" stroke="#CCCCCC"
                                            stroke-width="1.3"></circle>
                                        <path
                                            d="M11.0888 17.0001H3.97765C2.01397 17.0001 0.279998 15.277 1.30366 13.6012C2.30459 11.9627 4.24182 10.7778 7.53321 10.7778C10.8246 10.7778 12.7618 11.9627 13.7628 13.6012C14.7864 15.277 13.0524 17.0001 11.0888 17.0001Z"
                                            stroke="#CCCCCC" stroke-width="1.3"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <div class="position-relative">
                                    <input type="password" name="newpassword" class="form-control" id="newpassword"
                                        placeholder="New Password" />

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

                            <div class="col-12 col-md-6 mb-3">
                                <div class="position-relative">
                                    <select name="gender" class="form-control" id="gender" required>
                                        <option value="" disabled {{ Auth::user()->gender ? '' : 'selected' }}>
                                            Select Gender
                                        </option>
                                        <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>
                                            Female</option>
                                    </select>

                                    <svg class="icon" width="18" height="18" viewBox="0 0 18 18"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M17.9998 0.814309C17.9997 0.788673 17.9985 0.763091 17.996 0.737618C17.9947 0.724636 17.9923 0.711982 17.9904 0.699164C17.9884 0.685636 17.9869 0.672 17.9842 0.658582C17.9813 0.644073 17.9774 0.63 17.9738 0.615764C17.9708 0.604145 17.9683 0.592473 17.9648 0.581018C17.9606 0.566945 17.9553 0.553364 17.9504 0.539618C17.9462 0.528218 17.9425 0.516709 17.9379 0.505473C17.9324 0.492382 17.9261 0.479782 17.92 0.467018C17.9146 0.455673 17.9096 0.444164 17.9036 0.433036C17.8969 0.420382 17.8892 0.408273 17.8817 0.396055C17.8754 0.385473 17.8694 0.374727 17.8625 0.364418C17.8531 0.350182 17.8425 0.336709 17.8322 0.323073C17.8263 0.315436 17.8211 0.307527 17.815 0.300109C17.7806 0.258034 17.742 0.219482 17.6999 0.185018C17.6927 0.179182 17.6852 0.174164 17.678 0.1686C17.6641 0.157964 17.6502 0.147218 17.6356 0.137455C17.6256 0.1308 17.6152 0.125073 17.6051 0.118909C17.5924 0.111218 17.58 0.103309 17.5669 0.0963273C17.5563 0.0906545 17.5453 0.0858546 17.5345 0.0807273C17.5211 0.0743455 17.508 0.0677455 17.4943 0.0620727C17.4838 0.0577636 17.4731 0.0543273 17.4626 0.0505091C17.448 0.0451636 17.4336 0.0396545 17.4187 0.0351273C17.4083 0.0320182 17.3979 0.0297818 17.3875 0.0271091C17.372 0.0231273 17.3567 0.0188727 17.341 0.0157636C17.3296 0.0135273 17.3181 0.0122727 17.3066 0.0105273C17.2917 0.00823636 17.277 0.00556364 17.2618 0.00409091C17.2433 0.00229091 17.2247 0.00185455 17.2061 0.00125455C17.198 0.00103636 17.1901 0 17.1819 0H14.5987C14.1468 0 13.7805 0.366327 13.7805 0.818182C13.7805 1.27004 14.1468 1.63636 14.5987 1.63636H15.2067L13.9741 2.86898C13.0226 2.15291 11.8401 1.72795 10.5603 1.72795C9.68924 1.72795 8.86353 1.92496 8.12476 2.27635C7.38605 1.92496 6.56029 1.72795 5.68926 1.72795C2.55218 1.72789 0 4.28013 0 7.41715C0 10.2764 2.12024 12.6493 4.87091 13.0473V14.1107H3.86247C3.41062 14.1107 3.04429 14.4771 3.04429 14.9289C3.04429 15.3808 3.41062 15.7471 3.86247 15.7471H4.87091V16.7555C4.87091 17.2075 5.23724 17.5737 5.68909 17.5737C6.141 17.5737 6.50727 17.2074 6.50727 16.7555V15.7471H7.51571C7.96756 15.7471 8.33389 15.3808 8.33389 14.9289C8.33389 14.4771 7.96756 14.1107 7.51571 14.1107H6.50727V13.0473C7.06792 12.9663 7.61318 12.8013 8.12471 12.5579C8.86347 12.9093 9.68918 13.1063 10.5602 13.1063C13.6972 13.1063 16.2494 10.5541 16.2494 7.41709C16.2494 6.1488 15.8321 4.97624 15.1279 4.02922L16.3636 2.79344V3.4014C16.3636 3.85325 16.73 4.21958 17.1818 4.21958C17.6337 4.21958 18 3.85325 18 3.4014V0.818127C18 0.816818 17.9998 0.815564 17.9998 0.814309ZM9.74198 7.41715C9.74198 8.73846 9.1062 9.91386 8.12465 10.6542C7.14311 9.91386 6.50733 8.73846 6.50733 7.41715C6.50733 6.09578 7.14311 4.92038 8.12465 4.18004C9.1062 4.92038 9.74198 6.09584 9.74198 7.41715ZM1.63636 7.41715C1.63636 5.18236 3.45442 3.36425 5.6892 3.36425C5.964 3.36425 6.23242 3.39202 6.49206 3.44444C5.48984 4.47055 4.87102 5.87286 4.87102 7.41715C4.87102 8.96144 5.48978 10.3637 6.49206 11.3898C6.23242 11.4422 5.964 11.47 5.6892 11.47C3.45442 11.47 1.63636 9.65187 1.63636 7.41715ZM10.5602 11.47C10.2854 11.47 10.0169 11.4422 9.75731 11.3898C10.7596 10.3636 11.3783 8.96144 11.3783 7.41715C11.3783 5.87286 10.7596 4.47055 9.75731 3.44444C10.0216 3.39107 10.2905 3.36421 10.5602 3.36425C12.7949 3.36425 14.613 5.18236 14.613 7.41715C14.613 9.65187 12.7949 11.47 10.5602 11.47Z"
                                            fill="#CCCCCC" />
                                    </svg>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="confirmnewpassword"
                                        placeholder="Confirm New Password" />
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
                        </div>

                        <button type="submit" class="btn primary-btn mt-3">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mx-0 mb-3">
            <div class="col-12">
                <div class="profile-card transaction">

                    <ul class="nav nav-tabs justify-content-center border-0" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active text-center bg-transparent text-white" id="offers-tab"
                                data-bs-toggle="tab" href="#offers" role="tab" aria-controls="offers"
                                aria-selected="true">Offers</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-center bg-transparent text-white" id="surveys-tab"
                                data-bs-toggle="tab" href="#surveys" role="tab" aria-controls="surveys"
                                aria-selected="false">Surveys</a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-center bg-transparent text-white" id="cashout-tab"
                                data-bs-toggle="tab" href="#cashout" role="tab" aria-controls="cashout"
                                aria-selected="false">Cashout</a>
                        </li>
                    </ul>


                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active mt-4" id="offers" role="tabpanel"
                            aria-labelledby="offers-tab">
                            <div class="row justify-content-center gap-3">
                                @foreach ($offers as $index => $offer)
                                    <div class="profile-transaction-card p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-start">
                                                <div class="transaction-icon">
                                                    <p class="mb-0">{{ substr($offer->partners, 0, 1) }}</p>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-0 text-capitalize">{{ $offer->offer_name ?? 'N/A' }}
                                                    </h6>

                                                    <span
                                                        class="small text-capitalize">{{ $offer->partners ?? 'Unknown Partner' }}</span>

                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="fw-bold me-2">{{ number_format($offer->reward, 2) . ' ' . siteSymbol() }}</span>

                                                <button class="btn btn-icon toggle-details" data-bs-toggle="collapse"
                                                    data-bs-target="#offers-details-{{ $index }}"
                                                    aria-expanded="false"
                                                    aria-controls="offers-details-{{ $index }}">
                                                    <div class="chevron-down"></div>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="offers-details mt-4 px-2 collapse"
                                            id="offers-details-{{ $index }}">
                                            <div class="all-info d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-capitalize">Reward</h5>
                                                <p class="mb-0">
                                                    {{ number_format($offer->reward, 2) . ' ' . siteSymbol() }}</p>

                                            </div>
                                            <div class="all-info d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-capitalize">Transaction ID</h5>
                                                <p class="mb-0">{{ $offer->transaction_id ?? 'N/A' }}</p>

                                            </div>
                                            <div class="all-info d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-capitalize">Date</h5>
                                                <p class="mb-0">
                                                    {{ $offer->created_at ? date('F j, Y', strtotime($offer->created_at)) : 'N/A' }}

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>



                        <div class="tab-pane fade mt-4" id="surveys" role="tabpanel" aria-labelledby="surveys-tab">
                            <div class="row justify-content-center gap-3">
                                @foreach ($surveys as $index => $survey)
                                    <div class="profile-transaction-card p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-start">
                                                <div class="transaction-icon">
                                                    <p class="mb-0">{{ substr($survey->partners, 0, 1) }}</p>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-0 text-capitalize">{{ $survey->offer_name ?? 'N/A' }}
                                                    </h6>
                                                    <span
                                                        class="small text-capitalize">{{ $survey->partners ?? 'Unknown Partner' }}</span>

                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="fw-bold me-2">{{ number_format($survey->reward, 2) . ' ' . siteSymbol() }}</span>

                                                <button class="btn btn-icon toggle-details" data-bs-toggle="collapse"
                                                    data-bs-target="#survey-details-{{ $index }}"
                                                    aria-expanded="false"
                                                    aria-controls="survey-details-{{ $index }}">
                                                    <div class="chevron-down"></div>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="offers-details mt-4 px-2 collapse"
                                            id="survey-details-{{ $index }}">
                                            <div class="all-info d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-capitalize">Reward</h5>
                                                <p class="mb-0">
                                                    {{ number_format($survey->reward, 2) . ' ' . siteSymbol() }}</p>

                                            </div>
                                            <div class="all-info d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-capitalize">Transaction ID</h5>
                                                <p class="mb-0">{{ $survey->transaction_id ?? 'N/A' }}</p>

                                            </div>
                                            <div class="all-info d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-capitalize">Date</h5>
                                                <p class="mb-0">
                                                    {{ $survey->created_at ? date('F j, Y', strtotime($survey->created_at)) : 'N/A' }}

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>



                        <div class="tab-pane fade mt-4" id="cashout" role="tabpanel" aria-labelledby="cashout-tab">
                            <div class="row justify-content-center gap-3">
                                @foreach ($cashouts as $cashout)
                                    <div class="profile-transaction-card p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-start">
                                                <div class="transaction-icon">
                                                    <p class="mb-0">{{ substr($cashout->category->name, 0, 1) }}</p>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-0">{{ $cashout->category->name }}</h6>

                                                    <span class="small">Cashout</span>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="fw-bold me-2">{{ number_format($cashout->amount, 2) . ' ' . siteSymbol() }}</span>

                                                <button class="btn btn-icon toggle-details" data-bs-toggle="collapse"
                                                    data-bs-target="#offers-details-{{ $cashout->id }}"
                                                    aria-expanded="false"
                                                    aria-controls="offers-details-{{ $cashout->id }}">
                                                    <div class="chevron-down"></div>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="offers-details mt-4 px-2 collapse"
                                            id="offers-details-{{ $cashout->id }}">
                                            <div class="all-info d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-capitalize">Status</h5>
                                                <p class="mb-0">{{ ucfirst($cashout->status) }}</p>

                                            </div>

                                            <div class="all-info d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-capitalize">Date</h5>
                                                <p class="mb-0 text-capitalize">
                                                    {{ date('m/d/Y', strtotime($cashout->created_at)) }}</p>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
