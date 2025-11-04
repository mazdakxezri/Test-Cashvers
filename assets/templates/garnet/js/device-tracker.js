/**
 * Device & Session Tracker
 * Collects device information for fraud detection
 */

(function() {
    'use strict';
    
    /**
     * Get user's timezone
     */
    function getTimezone() {
        try {
            return Intl.DateTimeFormat().resolvedOptions().timeZone;
        } catch (e) {
            return null;
        }
    }
    
    /**
     * Get screen resolution
     */
    function getScreenInfo() {
        return {
            width: window.screen.width,
            height: window.screen.height
        };
    }
    
    /**
     * Store device info for future requests
     */
    function storeDeviceInfo() {
        const timezone = getTimezone();
        const screen = getScreenInfo();
        
        // Store in sessionStorage
        if (timezone) {
            sessionStorage.setItem('userTimezone', timezone);
        }
        sessionStorage.setItem('screenWidth', screen.width);
        sessionStorage.setItem('screenHeight', screen.height);
    }
    
    /**
     * Add device info to all AJAX requests
     */
    function setupAxiosInterceptor() {
        if (typeof axios !== 'undefined') {
            axios.defaults.headers.common['X-Timezone'] = sessionStorage.getItem('userTimezone');
            axios.defaults.headers.common['X-Screen-Width'] = sessionStorage.getItem('screenWidth');
            axios.defaults.headers.common['X-Screen-Height'] = sessionStorage.getItem('screenHeight');
        }
    }
    
    /**
     * Add device info to all fetch requests
     */
    const originalFetch = window.fetch;
    window.fetch = function(...args) {
        if (args[1] && typeof args[1] === 'object') {
            args[1].headers = args[1].headers || {};
            args[1].headers['X-Timezone'] = sessionStorage.getItem('userTimezone');
            args[1].headers['X-Screen-Width'] = sessionStorage.getItem('screenWidth');
            args[1].headers['X-Screen-Height'] = sessionStorage.getItem('screenHeight');
        }
        return originalFetch.apply(this, args);
    };
    
    /**
     * Send initial device info on page load
     */
    function sendDeviceInfo() {
        const timezone = getTimezone();
        const screen = getScreenInfo();
        
        // Send via meta tags for server-side access
        if (timezone) {
            let tzMeta = document.createElement('meta');
            tzMeta.name = 'user-timezone';
            tzMeta.content = timezone;
            document.head.appendChild(tzMeta);
        }
        
        let screenMeta = document.createElement('meta');
        screenMeta.name = 'user-screen';
        screenMeta.content = `${screen.width}x${screen.height}`;
        document.head.appendChild(screenMeta);
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        storeDeviceInfo();
        setupAxiosInterceptor();
        sendDeviceInfo();
    });
    
})();

