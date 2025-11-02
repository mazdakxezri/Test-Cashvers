<div class="modal fade offerwall-modal" id="WallModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content pb-0">
            <div class="modal-header border-0">
                <h5 class="modal-title mx-0">
                    <a href="#" class="bg-transparent text-white" data-bs-dismiss="modal" aria-label="Close">
                        <svg class="ms-4" width="18" height="15" viewBox="0 0 18 15"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18 6.52686H3.74194L8.91593 1.37602L7.53372 0L0 7.5L7.53372 15L8.91593 13.624L3.74194 8.47314H18V6.52686Z"
                                fill="var(--primary-color)"></path>
                        </svg>
                        @include($activeTemplate . '.partials.logo')
                    </a>
                </h5>
            </div>
            <div class="iframe-container position-relative h-100">
                <div id="offerwall-preloader"
                    class="position-absolute w-100 h-100 d-flex justify-content-center align-items-center">
                    <div class="loader"></div>
                </div>
                <iframe id="offerwallIframe" src="" frameborder="0"
                    class="position-absolute w-100 h-100"></iframe>
            </div>
        </div>
    </div>
</div>
