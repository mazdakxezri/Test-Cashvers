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
                    if (Array.isArray(jsonData)) {
                        jsonData.forEach((task, index) => {
                            const taskDiv = document.createElement('div');
                            taskDiv.className =
                                'd-flex align-items-center gap-4 task border-bottom';

                            const badgeSpan = document.createElement('span');
                            badgeSpan.className = 'badge';
                            badgeSpan.textContent = index + 1;

                            const taskDescriptionSpan = document.createElement('span');
                            taskDescriptionSpan.className = 'text-white fs-13';
                            taskDescriptionSpan.textContent = task.name;

                            const priceSpan = document.createElement('span');
                            priceSpan.className = 'text-warning ms-auto fw-semibold';
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
