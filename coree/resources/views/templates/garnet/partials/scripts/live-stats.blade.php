    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const liveStatsContainer = document.querySelector("#live-stats-wrapper");

            // Initialize Swiper
            const swiper = new Swiper("#live-stats", {
                slidesPerView: "auto",
                loop: false,
                freeMode: false,
                speed: 800,
            });

            // Function to fetch latest data
            async function fetchNewStats() {
                try {
                    const siteSymbol = @json(siteSymbol());
                    if (!window.displayedItemIds) {
                        window.displayedItemIds = new Set();
                    }

                    const response = await fetch("{{ route('getWithdrawAndCompletedOffers') }}");

                    const {
                        combinedData
                    } = await response.json();

                    if (!combinedData.length) return;

                    const newItems = combinedData.filter(item => !window.displayedItemIds.has(item.id));

                    if (newItems.length === 0) return;

                    newItems.reverse();

                    newItems.forEach((item) => {
                        window.displayedItemIds.add(item.id);

                        const slide = document.createElement("div");
                        slide.classList.add("stats-card", "swiper-slide");
                        slide.innerHTML = `
                    <div class="icon-stats" style="background: ${item.bg_color};">
                        <span class="text-uppercase">${item.type === "withdrawal" ? item.category_name.charAt(0) : item.partners.charAt(0)}</span>
                    </div>
                    <div class="stats-content">
                        <div class="title">${item.type === "withdrawal" ? item.category_name : item.partners}</div>
                        <div class="desc">${item.type === "withdrawal" ? "cashout" : item.offer_name.substring(0, 9)}</div>
                    </div>
                    <div class="stats-payout">${siteSymbol + (item.type === "withdrawal" ? item.amount : item.reward)}</div>
                `;

                        liveStatsContainer.prepend(slide);
                    });

                    swiper.update();
                } catch (error) {
                    console.error("Error fetching new stats:", error);
                }
            }

            fetchNewStats();

            setInterval(fetchNewStats, 5000);
        });
    </script>
