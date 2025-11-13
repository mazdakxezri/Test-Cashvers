<!-- Offer Details Modal -->
<div class="modal api fade" id="ApiModal" aria-hidden="true" aria-labelledby="ApiModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: #0f0f15; border: 1px solid rgba(0, 184, 212, 0.2); border-radius: 20px; backdrop-filter: blur(20px); overflow: hidden;">
            
            <!-- Modal Header -->
            <div class="modal-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding: 24px 32px; background: linear-gradient(135deg, rgba(0, 184, 212, 0.1) 0%, rgba(13, 71, 161, 0.1) 100%);">
                <div class="d-flex align-items-center gap-3 w-100">
                    <img src="" alt="Offer Image" id="data-creative" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; border: 2px solid rgba(0, 184, 212, 0.3);" />
                    <div class="flex-grow-1">
                        <h4 class="mb-1" id="modal-game-name" style="color: #ffffff; font-weight: 700; font-size: 20px; font-family: 'Inter', sans-serif;"></h4>
                        <div class="d-flex align-items-center gap-3">
                            <span style="color: rgba(255, 255, 255, 0.6); font-size: 14px; font-family: 'Inter', sans-serif;">Offer</span>
                            <div class="d-flex align-items-center gap-2">
                                <span style="color: #00B8D4; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif;">Earn</span>
                                <span id="game-payout" style="color: #ffffff; font-size: 18px; font-weight: 700; font-family: 'Inter', sans-serif;"></span>
                            </div>
                            <img src="" alt="device" id="game-device" style="width: 20px; height: 20px; opacity: 0.7;" />
                        </div>
                    </div>
                </div>
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 32px; max-height: 60vh; overflow-y: auto;">
                
                <!-- Description -->
                <div style="background: rgba(18, 18, 26, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
                    <h6 style="color: #00B8D4; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; font-family: 'Inter', sans-serif;">Description</h6>
                    <p id="game-description" style="color: rgba(255, 255, 255, 0.8); line-height: 1.7; margin: 0; font-size: 15px; font-family: 'Inter', sans-serif;"></p>
                </div>

                <!-- Events/Milestones -->
                <div id="modal-events" style="margin-bottom: 24px;"></div>

                <!-- Requirements -->
                <div style="background: rgba(18, 18, 26, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 24px;">
                    <h6 style="color: #00B8D4; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; font-family: 'Inter', sans-serif;">Requirements</h6>
                    <p id="game-requirement" style="color: rgba(255, 255, 255, 0.8); line-height: 1.7; margin: 0; font-size: 15px; font-family: 'Inter', sans-serif;"></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.08); padding: 24px 32px; background: rgba(0, 0, 0, 0.2);">
                <a href="#" target="_blank" id="game-link" 
                   style="width: 100%; background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); color: white; padding: 16px; border-radius: 12px; font-weight: 600; font-size: 16px; text-decoration: none; text-align: center; transition: all 0.3s ease; font-family: 'Inter', sans-serif; box-shadow: 0 4px 20px rgba(0, 184, 212, 0.3); display: block;">
                    <span id="link-payout"></span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Modal custom scrollbar */
.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: rgba(0, 184, 212, 0.3);
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 184, 212, 0.5);
}

/* Button hover effect */
#game-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(0, 184, 212, 0.5) !important;
}

/* Modal backdrop */
.modal.api .modal-backdrop {
    backdrop-filter: blur(10px);
}

/* Custom close button */
.modal-close-btn {
    position: relative;
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255, 255, 255, 0.7);
    padding: 0;
}

.modal-close-btn:hover {
    background: rgba(255, 61, 61, 0.15);
    border-color: rgba(255, 61, 61, 0.4);
    color: #FF3D3D;
    transform: rotate(90deg);
}

.modal-close-btn:active {
    transform: rotate(90deg) scale(0.95);
}

.modal-close-btn svg {
    pointer-events: none;
}
</style>
