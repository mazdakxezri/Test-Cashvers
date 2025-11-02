 <!-- Modal -->
 <div class="modal api fade px-0" id="ApiModal" aria-hidden="true" aria-labelledby="ApiModalLabel" tabindex="-1">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content rounded-0 pb-4">
             <div class="modal-header">
                 <div class="header-offer-img d-flex w-100">
                     <img src="" alt="Game Image" class="img-fluid" id="data-creative" />
                     <div class="ms-3 d-flex flex-grow-1">
                         <div>
                             <div class="d-flex">
                                 <div class="offer-title">
                                     <h4 class="mb-0 text-white fw-semibold text-capitalize" id="modal-game-name"></h4>
                                 </div>

                                 <div class="os ms-2">
                                     <img src="" alt="android" id="game-device" />
                                 </div>
                             </div>
                             <small>Game</small>
                             <div class="d-flex align-items-center gap-2">
                                 <p class="mb-0 fw-bold" style="color: var(--primary-color)">Earn</p>
                                 <p class="fs-5 mb-0 fw-semibold" id="game-payout"></p>
                             </div>
                         </div>
                     </div>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
             </div>

             <div class="modal-body">
                 <div class="event mb-3 px-2 overflow-y-scroll">
                     <div class="event-info">
                         <div class="description py-3 px-4 mb-4 mt-3">
                             <h6 class="mb-3">Description</h6>
                             <p class="mb-0" id="game-description"></p>
                         </div>
                         <div id="modal-events">

                         </div>
                         <div class="requirement mt-3">
                             <h6>Requirement</h6>
                             <p id="game-requirement"></p>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="modal-footer border-0">
                 <a class="btn primary-btn border-0 w-100" href="#" target="_blank" id="game-link"><span
                         id="link-payout"></span></a>
             </div>
         </div>
     </div>
 </div>
