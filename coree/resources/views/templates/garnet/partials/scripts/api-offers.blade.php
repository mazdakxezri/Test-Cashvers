<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('ApiModal');

        modal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const siteSymbol = @json(siteSymbol());
            const assetBaseUrl = "{{ asset('assets/' . $activeTemplate . '/images/icons') }}";

            const name = button.getAttribute('data-name');
            const creative = button.getAttribute('data-creative');
            const payout = button.getAttribute('data-payout');
            const device = button.getAttribute('data-device');
            const requirements = button.getAttribute('data-requirements');
            const description = button.getAttribute('data-description');
            const link = button.getAttribute('data-link');
            const eventData = button.getAttribute('data-event');

            modal.querySelector('#modal-game-name').textContent = name;
            modal.querySelector('#game-payout').textContent = `${payout} ${siteSymbol}`;
            modal.querySelector('#game-requirement').textContent = requirements;
            modal.querySelector('#game-description').textContent = description;
            modal.querySelector('#data-creative').setAttribute('src', creative);
            modal.querySelector('#game-device').setAttribute('src', `${assetBaseUrl}/${device}.svg`);
            modal.querySelector('#link-payout').textContent = `Earn ${payout}${siteSymbol}`;

            const gameLink = modal.querySelector('#game-link');
            gameLink.setAttribute('href', link);

            if (link === '#') {
                gameLink.setAttribute('data-bs-toggle', 'modal');
                gameLink.setAttribute('data-bs-target', '#authModal');
                gameLink.setAttribute('onclick', 'selectCreateAccountTab()');
            } else {
                gameLink.setAttribute('target', '_blank');
                gameLink.removeAttribute('data-bs-toggle');
                gameLink.removeAttribute('data-bs-target');
                gameLink.removeAttribute('onclick');
            }

            const modalEvents = modal.querySelector('#modal-events');
            modalEvents.innerHTML = '';

            if (eventData) {
                try {
                    const jsonData = JSON.parse(eventData.trim());
                    if (Array.isArray(jsonData) && jsonData.length > 0) {
                        // Create events container
                        const eventsContainer = document.createElement('div');
                        eventsContainer.style.cssText = 'background: rgba(18, 18, 26, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 24px; margin-bottom: 24px;';
                        
                        // Add header
                        const header = document.createElement('h6');
                        header.style.cssText = 'color: #00B8D4; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 20px; font-family: Inter, sans-serif; display: flex; align-items: center; gap: 8px;';
                        header.innerHTML = `
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B8D4" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            Reward Steps (CPE Offer)
                        `;
                        eventsContainer.appendChild(header);
                        
                        // Add steps
                        jsonData.forEach((task, index) => {
                            const taskDiv = document.createElement('div');
                            taskDiv.style.cssText = 'display: flex; align-items: center; gap: 16px; padding: 14px 16px; margin-bottom: 10px; border-left: 3px solid ' + (task.payout > 0 ? '#00B8D4' : 'rgba(255, 255, 255, 0.1)') + '; background: rgba(0, 184, 212, 0.05); border-radius: 8px; transition: all 0.2s ease;';
                            taskDiv.onmouseover = () => taskDiv.style.background = 'rgba(0, 184, 212, 0.12)';
                            taskDiv.onmouseout = () => taskDiv.style.background = 'rgba(0, 184, 212, 0.05)';

                            const badgeSpan = document.createElement('span');
                            badgeSpan.style.cssText = 'width: 28px; height: 28px; background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: white; font-size: 13px; font-family: Inter, sans-serif; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0, 184, 212, 0.3);';
                            badgeSpan.textContent = index + 1;

                            const taskDescriptionSpan = document.createElement('span');
                            taskDescriptionSpan.style.cssText = 'color: rgba(255, 255, 255, 0.95); font-size: 14px; flex: 1; font-family: Inter, sans-serif; font-weight: 500;';
                            taskDescriptionSpan.textContent = task.name;

                            const priceSpan = document.createElement('span');
                            priceSpan.style.cssText = 'color: #00E5FF; font-weight: 700; font-size: 15px; font-family: Inter, sans-serif; flex-shrink: 0; padding: 4px 12px; background: rgba(0, 229, 255, 0.1); border-radius: 6px;';
                            priceSpan.textContent = task.payout > 0 ? `+${task.payout.toFixed(2)} ${siteSymbol}` : 'Free';

                            taskDiv.append(badgeSpan, taskDescriptionSpan, priceSpan);
                            eventsContainer.appendChild(taskDiv);
                        });
                        
                        modalEvents.appendChild(eventsContainer);
                    }
                } catch (e) {
                    // Silent fail for invalid event data
                }
            }
        });
    });
</script>
