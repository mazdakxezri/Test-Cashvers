/**
 * Enhanced Preloader Script
 * Adds percentage counter and smooth transitions
 */

(function() {
    'use strict';
    
    // Preloader elements
    const preloader = document.querySelector('.preloader');
    const percentageDisplay = document.getElementById('loadingPercentage');
    const progressBar = document.getElementById('progressBar');
    
    let currentPercentage = 0;
    let targetPercentage = 0;
    let loadingInterval;
    
    /**
     * Simulate loading progress
     */
    function simulateLoading() {
        // Simulate different loading stages
        const loadingStages = [
            { percent: 30, delay: 200 },   // Fast initial load
            { percent: 60, delay: 400 },   // Medium load
            { percent: 85, delay: 600 },   // Slower for realism
            { percent: 100, delay: 100 }   // Quick finish
        ];
        
        let stageIndex = 0;
        
        function nextStage() {
            if (stageIndex < loadingStages.length) {
                targetPercentage = loadingStages[stageIndex].percent;
                setTimeout(nextStage, loadingStages[stageIndex].delay);
                stageIndex++;
            }
        }
        
        nextStage();
    }
    
    /**
     * Update percentage display smoothly
     */
    function updatePercentage() {
        if (currentPercentage < targetPercentage) {
            currentPercentage += 1;
            
            if (percentageDisplay) {
                percentageDisplay.textContent = currentPercentage + '%';
            }
            
            if (progressBar) {
                progressBar.style.width = currentPercentage + '%';
            }
            
            // If we reach 100%, start fade out
            if (currentPercentage >= 100) {
                setTimeout(hidePreloader, 300);
            }
        }
    }
    
    /**
     * Hide preloader with fade animation
     */
    function hidePreloader() {
        if (preloader) {
            preloader.classList.add('fade-out');
            
            setTimeout(() => {
                preloader.style.display = 'none';
                clearInterval(loadingInterval);
                
                // Optional: Dispatch event when loading complete
                document.dispatchEvent(new Event('preloaderComplete'));
            }, 800);
        }
    }
    
    /**
     * Initialize preloader
     */
    function initPreloader() {
        // Update percentage smoothly
        loadingInterval = setInterval(updatePercentage, 30);
        
        // Start simulated loading
        simulateLoading();
        
        // Fallback: Force hide after 5 seconds
        setTimeout(() => {
            if (preloader && preloader.style.display !== 'none') {
                targetPercentage = 100;
            }
        }, 5000);
    }
    
    /**
     * Start on page load
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPreloader);
    } else {
        initPreloader();
    }
    
    /**
     * Also trigger on window load (for images/resources)
     */
    window.addEventListener('load', function() {
        // Speed up to 100% when everything is loaded
        setTimeout(() => {
            targetPercentage = 100;
        }, 200);
    });
    
})();

