<div class="modal cashout fade" id="redeemModal-{{ $withdrawal->id }}" aria-hidden="true" aria-labelledby="redeemModalLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pb-0">
            <div class="modal-header">
                <h5 class="redeem-title" id="redeemModalLabel">{{ $withdrawal->name }}</h5>
                <button type="button" class="btn-close me-1" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    @csrf
                    @if($withdrawal->subCategories->isNotEmpty())
                     <div class="redeem-container mb-3">
                        @foreach ($withdrawal->subCategories as $item)
                            <div class="payment-card" style="background: {{ $withdrawal->bg_color }}"
                                data-card-value="{{ $item->id }}"
                                onclick="selectCard(this, {{ $withdrawal->id }}, {{ $item->id }})">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="position-absolute top-0 end-0 px-2 py-1">
                                        {{ floor($item->amount) == $item->amount
                                            ? number_format($item->amount, 0, '.', '') . ' ' . siteSymbol()
                                            : number_format($item->amount, 2, '.', '') . ' ' . siteSymbol() }}
                                    </p>

                                    @if (!empty($item->description))
                                        <p class="payment-card-text position-absolute top-0 start-0 px-2 py-1">
                                            {{ $item->description }}
                                        </p>
                                    @endif
                                </div>
                                <img src="{{ url($withdrawal->cover) }}" class="payment-card-img" />

                            </div>
                        @endforeach
                    </div>
                    @else
                    <div class="row redeem-container gap-0 mb-3">
                         <div class="{{ AdminRate() > 1 ? 'col-7 col-md-8' : 'col-12' }}">
                            <div class="position-relative mb-3">
                                <input type="number" id="amountInput" step="0.01" min="0" name="amount" class="form-control" required placeholder="Enter Amount {{ siteSymbol() }}">
                                <svg class="icon" viewBox="0,0,256,256"><g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M4,22h8c0.55228,0 1,-0.44772 1,-1c0,-0.55228 -0.44772,-1 -1,-1h-8c-0.55228,0 -1,-0.44772 -1,-1v-11.184c0.32026,0.11844 0.65856,0.18069 1,0.184h15v2c0,0.55228 0.44772,1 1,1c0.55228,0 1,-0.44772 1,-1v-3c0,-0.55228 -0.44772,-1 -1,-1h-16c-0.55228,0 -1,-0.44772 -1,-1c0,-0.55228 0.44772,-1 1,-1h16c0.55228,0 1,-0.44772 1,-1c0,-0.55228 -0.44772,-1 -1,-1h-16c-1.65685,0 -3,1.34315 -3,3v14c0,1.65685 1.34315,3 3,3z"></path><path d="M18,12c-2.76142,0 -5,2.23858 -5,5c0,2.76142 2.23858,5 5,5c2.76142,0 5,-2.23858 5,-5c-0.00331,-2.76005 -2.23995,-4.99669 -5,-5zM18,20c-1.65685,0 -3,-1.34315 -3,-3c0,-1.65685 1.34315,-3 3,-3c1.65685,0 3,1.34315 3,3c0,1.65685 -1.34315,3 -3,3z"></path></g></g></svg>
                            </div>
                        </div>
                       @if (AdminRate() > 1)
                        <div class="col-5 col-md-4">
                            <div class="position-relative mb-3">
                                <input type="text"  id="convertedValue" class="form-control" value="0 USD" disabled>
                                <svg class="icon" viewBox="0,0,256,256"><g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.33333,5.33333)"><path d="M24,4c-11.02793,0 -20,8.97207 -20,20c0,11.02793 8.97207,20 20,20c11.02793,0 20,-8.97207 20,-20c0,-11.02793 -8.97207,-20 -20,-20zM24,7c9.40662,0 17,7.59339 17,17c0,9.40661 -7.59338,17 -17,17c-9.40661,0 -17,-7.59339 -17,-17c0,-9.40661 7.59339,-17 17,-17zM23.47656,10.97852c-0.82766,0.01293 -1.48843,0.69381 -1.47656,1.52148v1.15234c-2.79221,0.386 -5,2.70524 -5,5.59766c0,3.15782 2.59218,5.75 5.75,5.75h2c1.8121,0 3.25,1.4379 3.25,3.25c0,1.8121 -1.4379,3.25 -3.25,3.25h-2.25c-1.17774,0 -2.14106,-0.79655 -2.41992,-1.86719c-0.12291,-0.53182 -0.52499,-0.95491 -1.04987,-1.10473c-0.52488,-0.14982 -1.08971,-0.00272 -1.47483,0.38409c-0.38512,0.38681 -0.52975,0.95228 -0.37764,1.4765c0.57468,2.20636 2.50862,3.80911 4.82227,4.02734v1.08398c-0.00765,0.54095 0.27656,1.04412 0.74381,1.31683c0.46725,0.27271 1.04514,0.27271 1.51238,0c0.46725,-0.27271 0.75146,-0.77588 0.74381,-1.31683v-1.05078c3.31301,-0.13994 6,-2.85378 6,-6.19922c0,-3.4339 -2.8161,-6.25 -6.25,-6.25h-2c-1.53618,0 -2.75,-1.21382 -2.75,-2.75c0,-1.53618 1.21382,-2.75 2.75,-2.75h0.50391c0.16103,0.02645 0.3253,0.02645 0.48633,0h0.75977c1.16914,0 2.12787,0.78679 2.41406,1.8457c0.13982,0.5175 0.54514,0.92108 1.06324,1.05868c0.5181,0.13759 1.07025,-0.01171 1.44841,-0.39165c0.37816,-0.37994 0.52486,-0.93279 0.38484,-1.45023c-0.58996,-2.18285 -2.51356,-3.76217 -4.81055,-3.97852v-1.08398c0.00582,-0.40562 -0.15288,-0.7963 -0.43991,-1.08296c-0.28703,-0.28666 -0.67792,-0.44486 -1.08353,-0.43852z"></path></g></g></svg>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    <input type="hidden" name="withdrawal_categories_id" value="{{ $withdrawal->id }}" />
                    <div class="row align-items-center mb-3">
                        <div class="col-12 col-md-4">
                            <p class="mb-0 d-none d-md-block">Your Wallet:</p>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="position-relative mb-3">
                                <input type="text" class="form-control" name="wallet" required
                                    placeholder="Enter Your Wallet" />
                                <input type="hidden" id="item-{{ $withdrawal->id }}" name="item_id" value="" />
                                <svg class="icon" width="512" height="512" viewBox="0 0 512 512" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path
                                            d="M457.262 89.821c-2.734-35.285-32.298-63.165-68.271-63.165H68.5c-37.771 0-68.5 30.729-68.5 68.5V412.09c0 37.771 30.729 68.5 68.5 68.5h370.247c37.771 0 68.5-30.729 68.5-68.5V155.757c-.001-31.354-21.184-57.836-49.985-65.936zM68.5 58.656h320.492c17.414 0 32.008 12.261 35.629 28.602H68.5c-13.411 0-25.924 3.889-36.5 10.577v-2.679c0-20.126 16.374-36.5 36.5-36.5zM438.746 448.59H68.5c-20.126 0-36.5-16.374-36.5-36.5V155.757c0-20.126 16.374-36.5 36.5-36.5h370.247c20.126 0 36.5 16.374 36.5 36.5v55.838H373.221c-40.43 0-73.322 32.893-73.322 73.323s32.893 73.323 73.322 73.323h102.025v53.849c0 20.126-16.374 36.5-36.5 36.5zm36.5-122.349H373.221c-22.785 0-41.322-18.537-41.322-41.323s18.537-41.323 41.322-41.323h102.025z"
                                            fill="#ffffff" opacity="1" data-original="#000000" class=""></path>
                                        <circle cx="379.16" cy="286.132" r="16.658" fill="#ffffff" opacity="1"
                                            data-original="#000000" class=""></circle>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end justify-content-md-end mx-auto">
                        <button type="submit" class="btn primary-btn px-5">Withdraw</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
