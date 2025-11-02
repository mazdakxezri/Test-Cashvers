@extends('admin.layouts.master')

@section('title', 'Custom Offers')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <x-admin.alert />
            </div>
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">All Custom Offers</h3>
                        <a href="{{ route('admin.offers.custom.create') }}" class="btn btn-success ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icon-tabler-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5v14m-7 -7h14" />
                            </svg>
                            Add New Custom Offer
                        </a>
                    </div>

                    <div class="card-body border-bottom py-3">
                        <div class="d-flex">
                            <div class="text-secondary">
                                Show
                                <form method="GET" class="d-inline-block">
                                    <input type="number" name="perPage" class="form-control form-control-sm"
                                        value="{{ request('perPage', $offers->perPage()) }}" onchange="this.form.submit()">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                </form>
                                entries
                            </div>
                            <div class="ms-auto text-secondary">
                                Search:
                                <form method="GET" class="d-inline-block">
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Search..." value="{{ request('search') }}">
                                    <input type="hidden" name="perPage"
                                        value="{{ request('perPage', $offers->perPage()) }}">
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap">
                            <thead>
                                <tr>
                                    <th>Offer Image</th>
                                    <th>Offer ID</th>
                                    <th>Offer Name</th>
                                    <th>Network Name</th>
                                    <th>Payout</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Postback</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($offers as $offer)
                                    <tr>
                                        <td>
                                            <span class="avatar me-2"
                                                style="background-image: url({{ url($offer->creative) }})"></span>
                                        </td>
                                        <td>{{ $offer->offer_id }}</td>
                                        <td>{{ $offer->name }}</td>
                                        <td>{{ $offer->partner }}</td>
                                        <td>{{ $offer->payout }}</td>
                                        <td class="text-wrap" style="max-width: 300px;">
                                            {{ mb_strlen($offer->description) > 100 ? mb_substr($offer->description, 0, 100) . '...' : $offer->description }}
                                        </td>
                                        <td>{{ $offer->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <span class="text-white badge {{ $offer->status ? 'bg-green' : 'bg-red' }}">
                                                {{ $offer->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>

                                        <td>
                                            <!-- Copy Button -->
                                            <button class="btn btn-sm btn-primary"
                                                onclick="copyLink('{{ route('custom.postback.callback', [
                                                    'param_secret' => 'Yk9@7v@Dw5vJ',
                                                    'network_name' => $offer->partner,
                                                ]) }}?payout={payout}&of_name={custom_offer_name}&of_id={offer_id}&uid={user_uid_here}&ip={ip}&country={country}&status={status}&tx_id={transaction_id}')">
                                                Click here to copy
                                            </button>
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <a href="{{ route('admin.offers.custom.edit', $offer->id) }}"
                                                    class="btn">
                                                    Edit
                                                </a>

                                                <a href="javascript:void(0)" class="btn" data-bs-toggle="modal"
                                                    data-bs-target="#delete-modal" data-offer-id="{{ $offer->id }}">
                                                    Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    @include('components.admin.pagination', ['paginator' => $offers])
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal modal-blur fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <form action="{{ route('admin.offers.custom.destroy') }}" method="POST" id="deleteOfferForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="offer-id" value="" id="offer-id">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983l.014.003h14.338a1.99 1.99 0 0 0 1.7-2.982l-8.436-14.06a1.989 1.989 0 0 0-3.466 0z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                        <h3>Are you sure?</h3>
                        <div class="text-muted">Do you really want to delete this offer? This process cannot be undone.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="deleteOfferForm" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('delete-modal').addEventListener('show.bs.modal', function(event) {
            const offerId = event.relatedTarget.getAttribute('data-offer-id');
            document.getElementById('offer-id').value = offerId;
        });
    </script>
    <script>
        function copyLink(url) {
            var tempInput = document.createElement("input");
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

            showSuccessNotification("Link copied to clipboard!");
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
                }, 3000);
        }
    </script>
@endsection
