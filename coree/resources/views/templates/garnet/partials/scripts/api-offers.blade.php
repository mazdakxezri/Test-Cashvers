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
                        // Add header
                        const header = document.createElement('h6');
                        header.style.cssText = 'color: #00B8D4; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; font-family: Inter, sans-serif;';
                        header.textContent = 'Milestones';
                        modalEvents.appendChild(header);
                        
                        jsonData.forEach((task, index) => {
                            const taskDiv = document.createElement('div');
                            taskDiv.style.cssText = 'background: rgba(18, 18, 26, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 16px 20px; margin-bottom: 12px; display: flex; align-items: center; gap: 16px;';

                            const badgeSpan = document.createElement('span');
                            badgeSpan.style.cssText = 'width: 32px; height: 32px; background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: white; font-size: 14px; font-family: Inter, sans-serif; flex-shrink: 0;';
                            badgeSpan.textContent = index + 1;

                            const taskDescriptionSpan = document.createElement('span');
                            taskDescriptionSpan.style.cssText = 'color: rgba(255, 255, 255, 0.9); font-size: 15px; flex: 1; font-family: Inter, sans-serif;';
                            taskDescriptionSpan.textContent = task.name;

                            const priceSpan = document.createElement('span');
                            priceSpan.style.cssText = 'background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700; font-size: 16px; font-family: Inter, sans-serif; flex-shrink: 0;';
                            priceSpan.textContent = `${task.payout.toFixed(2)} ${siteSymbol}`;

                            taskDiv.append(badgeSpan, taskDescriptionSpan, priceSpan);
                            modalEvents.appendChild(taskDiv);
                        });
                    }
                } catch (e) {}
            }
        });
    });
</script>
