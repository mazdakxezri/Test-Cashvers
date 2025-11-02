@extends($activeTemplate . '.layouts.app')
@section('title', 'Affiliates')

@section('content')

    <section class="cover affiliate px-3 px-xl-4">
        <div class="sec-title py-4 d-flex align-items-center justify-content-between">
            <h2 class="mb-0">
                <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/affiliate_grp.svg') }}" class="img-fluid"
                    alt="affiliates" />
                Invite to earn
            </h2>
        </div>
        <p>Earn {{ ReferralCommission() }}% commissions by referring more Friends</p>
        <div class="row mb-3">
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="my-balance h-100">
                    <h6>Your Referral Link</h6>
                    <input type="url" id="referralLink" class="form-control mb-3 ps-2"
                        value="{{ route('referral.code', $referral_code) }}" disabled />
                    <div class="copy-btn">
                        <button class="btn primary-btn px-5" id="copyButton">Copy Link</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="my-balance">
                    <h6>Your Current Comission</h6>
                    <p class="mb-0">
                        {{ ReferralCommission() }}%
                        <span> Comission</span>
                    </p>
                </div>
            </div>
            <div class="col-6 col-lg-2 mb-3">
                <div class="my-balance">
                    <h6>Users Referred</h6>
                    <p class="mb-0 d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            viewBox="0 0 24 24" aria-hidden="true" role="img">
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h4v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                        <span class="ps-2">{{ $total_user_referred }}</span>
                    </p>
                </div>

            </div>
            <div class="col-6 col-lg-2 mb-3">
                <div class="my-balance">
                    <h6>Total Earned</h6>
                    <p class="mb-0">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M7.5 0C3.35802 0 0 3.35802 0 7.5C0 11.642 3.35802 15 7.5 15C11.642 15 15 11.642 15 7.5C15 3.35802 11.642 0 7.5 0ZM9.65432 10.4568C9.32716 10.8549 8.90123 11.1235 8.40432 11.2593C8.18827 11.3179 8.08951 11.4321 8.10185 11.6574C8.11111 11.8796 8.10185 12.0988 8.09877 12.321C8.09877 12.5185 7.99691 12.6235 7.80247 12.6296C7.67593 12.6327 7.54938 12.6358 7.42284 12.6358C7.31173 12.6358 7.20062 12.6358 7.08951 12.6327C6.87963 12.6296 6.78086 12.5093 6.78086 12.3056C6.77778 12.1451 6.77778 11.9815 6.77778 11.821C6.77469 11.463 6.76235 11.4506 6.41975 11.3951C5.98148 11.3241 5.54938 11.2253 5.14815 11.0309C4.83333 10.8765 4.79938 10.7994 4.88889 10.466C4.95679 10.2191 5.02469 9.97222 5.10185 9.7284C5.15741 9.54938 5.20988 9.46914 5.30556 9.46914C5.36111 9.46914 5.4321 9.49691 5.52778 9.5463C5.97222 9.77778 6.44444 9.90741 6.94136 9.96914C7.02469 9.9784 7.10802 9.98457 7.19136 9.98457C7.42284 9.98457 7.64815 9.94136 7.86728 9.84568C8.41975 9.60494 8.50617 8.96605 8.04012 8.58333C7.88272 8.4537 7.70062 8.35802 7.51235 8.27469C7.02778 8.06173 6.52469 7.90123 6.0679 7.62654C5.32716 7.1821 4.85802 6.57407 4.91358 5.67284C4.97531 4.65432 5.55247 4.01852 6.48765 3.67901C6.87346 3.54012 6.87654 3.54321 6.87654 3.14198C6.87654 3.00617 6.87346 2.87037 6.87963 2.73148C6.88889 2.42901 6.93827 2.37654 7.24074 2.36728H7.59259C8.16667 2.36728 8.16667 2.39198 8.16975 3.01235C8.17284 3.46914 8.17284 3.46914 8.62654 3.54012C8.97531 3.59568 9.30556 3.69753 9.62654 3.83951C9.80247 3.91667 9.87037 4.04012 9.81481 4.22839C9.73457 4.50617 9.65741 4.78704 9.57099 5.06173C9.51543 5.22839 9.46296 5.30556 9.3642 5.30556C9.30864 5.30556 9.24074 5.28395 9.15432 5.24074C8.70988 5.02469 8.24383 4.91975 7.75617 4.91975C7.69444 4.91975 7.62963 4.92284 7.5679 4.92593C7.42284 4.93519 7.28086 4.9537 7.14506 5.01235C6.66358 5.22222 6.58642 5.75309 6.99691 6.08025C7.2037 6.24691 7.44136 6.3642 7.68519 6.46605C8.11111 6.64198 8.53704 6.81173 8.94136 7.03395C10.213 7.74383 10.5586 9.35802 9.65432 10.4568Z"
                                fill="white" />
                        </svg>
                        <span class="ps-2">{{ $ref_earning }}</span>
                    </p>
                </div>
            </div>
        </div>

        @if ($referralLogs->isNotEmpty())
            <div class="sec-title py-4 d-flex align-items-center justify-content-between">
                <h2 class="mb-0">
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/affiliate_grp.svg') }}"
                        class="img-fluid" alt="affiliate" />
                    Referral Earnings
                </h2>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <table class="affiliate-table text-center w-100">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Earning</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($referralLogs as $invite)
                                <tr class="fs-14">
                                    <td>{{ $invite['user'] }}</td>
                                    <td>{{ $invite['earnings'] . ' ' . siteSymbol() }}</td>
                                    <td>{{ $invite['created_at']->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </section>

@endsection

@section('scripts')
    <script>
        document.getElementById('copyButton').addEventListener('click', function() {
            const referralLinkInput = document.getElementById('referralLink');
            referralLinkInput.removeAttribute('disabled');
            referralLinkInput.select();
            document.execCommand('copy');
            referralLinkInput.setAttribute('disabled', 'disabled');

            const copyButton = this;
            const originalText = copyButton.textContent;
            copyButton.textContent = 'Copied!';

            setTimeout(() => copyButton.textContent = originalText, 5000);
        });
    </script>
@endsection
