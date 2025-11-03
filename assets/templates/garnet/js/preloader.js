/**
 * Cyberpunk Scanning Preloader
 * Line-by-line scanning animation with glitch effects
 */

(function() {
    'use strict';
    
    const preloader = document.querySelector('.preloader');
    const brandText = document.querySelector('.brand-scanner');
    const scanline = document.querySelector('.scanline');
    
    let scanComplete = false;
    
    /**
     * Trigger random glitch effects
     */
    function triggerGlitch() {
        if (!brandText || scanComplete) return;
        
        const glitchType = Math.random();
        
        if (glitchType < 0.5) {
            // RGB split glitch
            brandText.classList.add('rgb-split');
            setTimeout(() => {
                brandText.classList.remove('rgb-split');
            }, 200);
        } else {
            // Position glitch
            brandText.classList.add('glitch');
            setTimeout(() => {
                brandText.classList.remove('glitch');
            }, 300);
        }
    }
    
    /**
     * Schedule random glitches during scanning
     */
    function scheduleGlitches() {
        // Trigger 3-5 random glitches during scan
        const glitchCount = 3 + Math.floor(Math.random() * 3);
        
        for (let i = 0; i < glitchCount; i++) {
            const delay = 400 + Math.random() * 1200;
            setTimeout(triggerGlitch, delay);
        }
    }
    
    /**
     * Simulate line-by-line scanning
     */
    function startScanning() {
        // Mark text as being scanned
        if (brandText) {
            // Start dim, will brighten as scan completes
            setTimeout(() => {
                brandText.classList.add('scanned');
            }, 1500); // When scanline reaches bottom
        }
        
        // Schedule random glitches
        scheduleGlitches();
        
        // Mark scan as complete
        setTimeout(() => {
            scanComplete = true;
        }, 1600);
    }
    
    /**
     * Hide preloader with glitch effect
     */
    function hidePreloader() {
        if (!preloader) return;
        
        // Final glitch before exit
        if (brandText) {
            brandText.classList.add('glitch');
        }
        
        setTimeout(() => {
            preloader.classList.add('final-glitch');
            
            setTimeout(() => {
                preloader.classList.add('fade-out');
                
                setTimeout(() => {
                    preloader.style.display = 'none';
                    
                    // Dispatch completion event
                    document.dispatchEvent(new Event('preloaderComplete'));
                }, 800);
            }, 200);
        }, 100);
    }
    
    /**
     * Initialize preloader sequence
     */
    function initPreloader() {
        // Start scanning animation immediately
        startScanning();
        
        // Hide after scan completes + small delay
        const totalDuration = 2500; // 2.5 seconds total
        setTimeout(hidePreloader, totalDuration);
    }
    
    /**
     * Trigger on various load events
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPreloader);
    } else {
        initPreloader();
    }
    
    /**
     * Also ensure it hides when everything is loaded
     */
    window.addEventListener('load', function() {
        // If preloader still showing after 4 seconds, force hide
        setTimeout(() => {
            if (preloader && preloader.style.display !== 'none') {
                hidePreloader();
            }
        }, 4000);
    });
    
})();
