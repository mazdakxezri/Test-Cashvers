@extends('admin.layouts.master')
@section('styles')<style>
        .networks:hover {
            cursor: move;
        }
    </style>
@endsection
@section('title', 'All Offerwalls')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <x-admin.alert />
                </div>
                <!-- Offerwalls -->
                @include('admin.partials.network', [
                    'networks' => $offer,
                    'title' => 'All Offerwalls',
                ])

                <!-- Surveys -->
                @include('admin.partials.network', [
                    'networks' => $survey,
                    'title' => 'All Surveys',
                ])

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        async function saveOrder(e) {
            try {
                let t = await fetch("{{ route('admin.network.order') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        order: e
                    }),
                });
                if (!t.ok) throw Error("Failed to save order");
                showSuccessNotification("Network order updated successfully!");
            } catch (r) {
                console.error("Error saving order:", r);
            }
        }

        function showSuccessNotification(e = "Action completed successfully!") {
            let t = document.createElement("div");
            (t.className = "alert alert-important alert-success alert-dismissible"),
            t.setAttribute("role", "alert"),
                (t.innerHTML = `
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon me-2">
                    <path d="M5 12l5 5l10 -10"></path>
                </svg>
                <div>${e}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `),
                Object.assign(t.style, {
                    position: "fixed",
                    top: "20px",
                    right: "20px",
                    zIndex: "1050",
                    opacity: "0",
                    transition: "opacity 0.5s ease-in-out",
                }),
                document.body.appendChild(t),
                setTimeout(() => (t.style.opacity = "1"), 100),
                setTimeout(() => {
                    (t.style.opacity = "0"), setTimeout(() => t.remove(), 500);
                }, 3e3);
        }

        function debounce(e, t) {
            let r;
            return (...o) => {
                clearTimeout(r), (r = setTimeout(() => e(...o), t));
            };
        }

        function copyToClipboard(element) {
            const url = element.previousElementSibling?.dataset.url;
            if (url) {
                navigator.clipboard
                    .writeText(url)
                    .then(() => showSuccessNotification("Postback copied successfully!"))
                    .catch((err) => console.error("Error copying:", err));
            }
        }
        document.addEventListener("DOMContentLoaded", () => {
            "undefined" != typeof Sortable &&
                document.querySelectorAll(".sortable-container").forEach((e) => {
                    new Sortable(e, {
                        animation: 150,
                        handle: ".networks",
                        onEnd: debounce(async (t) => {
                            let r = Array.from(e.children)
                                .filter((e) => e.classList.contains("networks"))
                                .map((e, t) => {
                                    e.querySelector(".card.bg-dark-lt");
                                    let r = e.querySelector(".card-title")?.textContent
                                        .trim();
                                    return {
                                        name: r,
                                        order: t + 1
                                    };
                                });
                            r.length > 0 ?
                                await saveOrder(r) :
                                console.error("No order data found.");
                        }, 500),
                    });
                });
        });
    </script>
@endsection
