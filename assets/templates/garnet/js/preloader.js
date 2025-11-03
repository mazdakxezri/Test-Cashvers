/**
 * Cyberpunk Scanning Preloader
 * Clean, focused scanning animation with glitch effects
 */

(function() {
    'use strict';
    
    const preloader = document.querySelector('.preloader');
    const brandText = document.querySelector('.brand-scanner');
    
    /**
     * Trigger random glitch during scanning
     */
    function randomGlitch() {
        if (!brandText) return;
        
        const glitchType = Math.random();
        
        if (glitchType < 0.4) {
            // RGB chromatic aberration
            brandText.classList.add('rgb-split');
            setTimeout(() => brandText.classList.remove('rgb-split'), 150);
        } else if (glitchType < 0.8) {
            // Position shake glitch
            brandText.classList.add('glitch');
            setTimeout(() => brandText.classList.remove('glitch'), 200);
        }
    }
    
    /**
     * Start scanning sequence
     */
    function startScan() {
        // Add scanning class
        if (brandText) {
            brandText.classList.add('scanning');
        }
        
        // Random glitches during scan
        setTimeout(() => randomGlitch(), 600);
        setTimeout(() => randomGlitch(), 1000);
        setTimeout(() => randomGlitch(), 1300);
        
        // Mark as fully scanned when scanline completes
        setTimeout(() => {
            if (brandText) {
                brandText.classList.remove('scanning');
                brandText.classList.add('scanned');
            }
        }, 1500);
    }
    
    /**
     * Exit with glitch effect
     */
    function exitPreloader() {
        if (!preloader) return;
        
        // Final glitch
        preloader.classList.add('final-glitch');
        
        setTimeout(() => {
            preloader.classList.add('fade-out');
            
            setTimeout(() => {
                preloader.style.display = 'none';
                document.dispatchEvent(new Event('preloaderComplete'));
            }, 600);
        }, 300);
    }
    
    /**
     * Initialize preloader
     */
    function init() {
        // Start scanning immediately
        startScan();
        
        // Hide after 2.5 seconds
        setTimeout(exitPreloader, 2500);
    }
    
    // Start when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    // Failsafe: force hide after 4 seconds
    window.addEventListener('load', function() {
        setTimeout(() => {
            if (preloader && preloader.style.display !== 'none') {
                exitPreloader();
            }
        }, 4000);
    });
    
})();
