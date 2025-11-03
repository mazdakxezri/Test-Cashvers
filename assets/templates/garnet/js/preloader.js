/**
 * Minimal Scanning Preloader
 * Simple and lightweight
 */

(function() {
    'use strict';
    
    const preloader = document.querySelector('.preloader');
    const brandText = document.querySelector('.brand-scanner');
    
    /**
     * Start the scanning sequence
     */
    function startScan() {
        // Mark as scanned when scanline finishes (1.5s)
        setTimeout(() => {
            if (brandText) {
                brandText.classList.add('scanned');
            }
        }, 1500);
    }
    
    /**
     * Hide preloader
     */
    function hidePreloader() {
        if (preloader) {
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    }
    
    /**
     * Initialize
     */
    function init() {
        startScan();
        setTimeout(hidePreloader, 2000);
    }
    
    // Start when ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    // Failsafe
    window.addEventListener('load', function() {
        setTimeout(() => {
            if (preloader && preloader.style.display !== 'none') {
                hidePreloader();
            }
        }, 3000);
    });
    
})();
