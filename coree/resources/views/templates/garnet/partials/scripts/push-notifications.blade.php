<script>
// Push Notifications Setup
const pushNotifications = {
    init() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            console.log('Push notifications not supported');
            return;
        }

        // Register service worker
        navigator.serviceWorker.register('/service-worker.js')
            .then((registration) => {
                console.log('Service Worker registered:', registration);
                this.checkSubscription(registration);
            })
            .catch((error) => {
                console.error('Service Worker registration failed:', error);
            });
    },

    async checkSubscription(registration) {
        const subscription = await registration.pushManager.getSubscription();
        
        if (!subscription) {
            // Show prompt to enable notifications
            this.showNotificationPrompt();
        } else {
            console.log('Already subscribed to push notifications');
        }
    },

    showNotificationPrompt() {
        // Check if user has already dismissed or denied
        if (localStorage.getItem('push_notification_prompted') === 'true') {
            return;
        }

        // Create a beautiful notification prompt
        const prompt = document.createElement('div');
        prompt.className = 'push-notification-prompt';
        prompt.innerHTML = `
            <div class="push-prompt-content">
                <div class="push-prompt-icon">🔔</div>
                <div class="push-prompt-text">
                    <h4>Stay Updated!</h4>
                    <p>Get notified about new offers, events, and rewards</p>
                </div>
                <div class="push-prompt-actions">
                    <button class="btn-enable-push">Enable</button>
                    <button class="btn-close-push">×</button>
                </div>
            </div>
        `;

        document.body.appendChild(prompt);

        // Handle enable button
        prompt.querySelector('.btn-enable-push').addEventListener('click', () => {
            this.subscribe();
            prompt.remove();
        });

        // Handle close button
        prompt.querySelector('.btn-close-push').addEventListener('click', () => {
            prompt.remove();
            localStorage.setItem('push_notification_prompted', 'true');
        });

        // Auto-show with animation
        setTimeout(() => prompt.classList.add('show'), 100);
    },

    async subscribe() {
        try {
            const registration = await navigator.serviceWorker.ready;
            
            const subscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: this.urlBase64ToUint8Array('{{ env("VAPID_PUBLIC_KEY", "BP-replace-with-your-vapid-public-key") }}')
            });

            // Send subscription to server
            const response = await fetch('{{ route("push.subscribe") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify(subscription),
            });

            const data = await response.json();
            
            if (data.success) {
                console.log('Successfully subscribed to push notifications');
                this.showToast('✅ Notifications enabled!', 'success');
            }
        } catch (error) {
            console.error('Failed to subscribe:', error);
            this.showToast('❌ Failed to enable notifications', 'error');
        }
    },

    async unsubscribe() {
        try {
            const registration = await navigator.serviceWorker.ready;
            const subscription = await registration.pushManager.getSubscription();
            
            if (subscription) {
                await subscription.unsubscribe();
                
                // Notify server
                await fetch('{{ route("push.unsubscribe") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ endpoint: subscription.endpoint }),
                });

                this.showToast('Notifications disabled', 'info');
            }
        } catch (error) {
            console.error('Failed to unsubscribe:', error);
        }
    },

    urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');

        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);

        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    },

    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `push-toast push-toast-${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    pushNotifications.init();
});
</script>

<style>
.push-notification-prompt {
    position: fixed;
    bottom: 20px;
    right: 20px;
    max-width: 400px;
    background: linear-gradient(145deg, rgba(15, 15, 25, 0.98), rgba(20, 20, 30, 0.98));
    border: 1px solid rgba(0, 184, 212, 0.3);
    border-radius: 16px;
    padding: var(--space-lg);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
    z-index: 10000;
    transform: translateY(calc(100% + 40px));
    transition: transform 0.3s ease;
}

.push-notification-prompt.show {
    transform: translateY(0);
}

.push-prompt-content {
    display: flex;
    align-items: center;
    gap: var(--space-md);
}

.push-prompt-icon {
    font-size: 36px;
    flex-shrink: 0;
}

.push-prompt-text h4 {
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 4px 0;
}

.push-prompt-text p {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
}

.push-prompt-actions {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
}

.btn-enable-push {
    padding: 8px 20px;
    background: linear-gradient(135deg, #00B8D4, #0081A7);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-enable-push:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 184, 212, 0.4);
}

.btn-close-push {
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    border-radius: 8px;
    color: rgba(255, 255, 255, 0.6);
    font-size: 20px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-close-push:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
}

.push-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 12px 20px;
    background: rgba(15, 15, 25, 0.95);
    border-radius: 8px;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    z-index: 10001;
    opacity: 0;
    transform: translateY(-20px);
    transition: all 0.3s ease;
}

.push-toast.show {
    opacity: 1;
    transform: translateY(0);
}

.push-toast-success {
    border-left: 4px solid #4CAF50;
}

.push-toast-error {
    border-left: 4px solid #F44336;
}

.push-toast-info {
    border-left: 4px solid #00B8D4;
}

@media (max-width: 768px) {
    .push-notification-prompt {
        right: 10px;
        left: 10px;
        max-width: none;
    }

    .push-prompt-content {
        flex-direction: column;
        text-align: center;
    }

    .push-prompt-actions {
        width: 100%;
        justify-content: center;
    }
}
</style>

