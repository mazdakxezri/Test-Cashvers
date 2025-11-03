/**
 * Ultra-Simple Preloader
 */

(function() {
    'use strict';
    
    const preloader = document.querySelector('.preloader');
    
    function hidePreloader() {
        if (preloader) {
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    }
    
    // Hide after 1.5 seconds
    setTimeout(hidePreloader, 1500);
    
    // Failsafe on window load
    window.addEventListener('load', function() {
        setTimeout(() => {
            if (preloader && preloader.style.display !== 'none') {
                hidePreloader();
            }
        }, 2500);
    });
    
})();
