<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-yellow text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-hours-24">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 13c.325 2.532 1.881 4.781 4 6" />
                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2" />
                                        <path d="M4 5v4h4" />
                                        <path
                                            d="M12 15h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-1a1 1 0 0 0 -1 1v1a1 1 0 0 0 1 1h2" />
                                        <path d="M18 15v2a1 1 0 0 0 1 1h1" />
                                        <path d="M21 15v6" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    @if ($status === 'hold')
                                        {{ $totalHoldWithdrawals }}
                                    @elseif ($status === 'pending')
                                        {{ $totalPendingWithdrawals }}
                                    @else
                                        0
                                    @endif
                                </div>
                                <div class="text-secondary">
                                    @if ($status === 'hold')
                                        Total Hold Withdrawals
                                    @elseif ($status === 'pending')
                                        Total Pending Withdrawals
                                    @else
                                        Total Withdrawals
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-green text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-currency-dollar">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                                        <path d="M12 3v3m0 12v3" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    ${{ number_format($totalUSDAmount, 2) }}
                                </div>
                                <div class="text-secondary">
                                    Total USD Withdrawals
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <x-admin.alert />
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Withdrawals</h3>
                    @if ($userTotal > 0)
                        <h3 class="ms-auto mb-0">Total to Pay: <span class="text-red">{{ $userTotal }} (USD)</span>
                        </h3>
                    @endif
                </div>
                <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                        <div class="text-secondary">
                            Show
                            <div class="mx-2 d-inline-block">
                                <form method="GET">
                                    <input type="number" name="perPage" class="form-control form-control-sm"
                                        id="paginationInput" value="{{ $withdrawals->perPage() }}"
                                        aria-label="withdraw count">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                </form>
                            </div>
                            entries
                        </div>
                        <div class="ms-auto text-secondary">
                            Search:
                            <div class="ms-2 d-inline-block">
                                <form method="GET">
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        aria-label="Search withdraw" placeholder="Search..."
                                        value="{{ request('search') }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <form id="markCompletedForm" action="{{ route('admin.withdraw.completed') }}" method="post">
                        @csrf
                        @method('PUT')
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox"
                                            id="selectAllCheckbox" aria-label="Select all withdraw"></th>
                                    <th class="w-1">Method</th>
                                    <th>To</th>
                                    <th>User ID</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdrawals as $withdrawal)
                                    <tr>
                                        <td>
                                            <input class="form-check-input m-0 align-middle withdrawal-checkbox"
                                                type="checkbox" name="selectedWithdrawals[]"
                                                aria-label="Select withdraw" value="{{ $withdrawal->id }}">
                                        </td>
                                        <td><span class="text-secondary">{{ $withdrawal->category->name }}</span></td>
                                        <td class="text-reset" tabindex="-1">{{ $withdrawal->redeem_wallet }}</td>
                                        <td>
                                            <span class="flag flag-xs flag-country-us me-2"></span>
                                            <a href="{{ route('admin.members.info', ['uid' => $withdrawal->user->uid]) }}"
                                                target="_blank">{{ $withdrawal->user->uid }}</a>

                                        </td>
                                        <td>{{ $withdrawal->amount . ' ' . siteSymbol() }}
                                            <small class="text-red">
                                                {{ $withdrawal->amount / AdminRate() }} USD</small>
                                        </td>
                                        <td>{{ $withdrawal->description }}</td>
                                        <td>{{ $withdrawal->created_at }}</td>
                                        <td class="text-end">
                                            <button type="button" class="border-0 bg-transparent"
                                                data-bs-toggle="modal" data-bs-target="#cancel-modal"
                                                data-withdraw-id="{{ $withdrawal->id }}"
                                                data-withdraw-amount="{{ $withdrawal->amount }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
                @include('components.admin.pagination', ['paginator' => $withdrawals])
                <div class="card-footer">
                    <button type="submit" name="action" value="complete" form="markCompletedForm"
                        class="btn btn-success">
                        Make It Completed
                    </button>
                    @if ($status !== 'hold')
                        <button type="submit" name="action" value="hold" form="markCompletedForm"
                            class="btn btn-warning">
                            Make It Hold
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal modal-blur fade" id="cancel-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <form action="{{ route('admin.withdraw.cancel') }}" method="POST" id="cancelWithdrawForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="withdraw-id" value="" id="withdraw-id">

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
                    <div class="text-muted text-wrap">Do you really want to
                        cancel these Withdrawals? This process cannot be
                        undone.
                    </div>

                    <div class="mt-3">
                        <label class="row">
                            <span class="col text-start">Return
                                $<span id="withdraw-amount"></span></span>
                            <span class="col-auto">
                                <label class="form-check form-check-single form-switch">
                                    <input class="form-check-input" type="checkbox" name="confirmCancel">
                                </label>
                            </span>
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancel</button>

                <button type="submit" form="cancelWithdrawForm" class="btn btn-danger">Cancel
                    Withdrawals</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const withdrawalCheckboxes = document.querySelectorAll('.withdrawal-checkbox');

        selectAllCheckbox.addEventListener('change', function() {
            withdrawalCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        withdrawalCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    // Check if all checkboxes are checked
                    let allChecked = true;
                    withdrawalCheckboxes.forEach(cb => {
                        if (!cb.checked) {
                            allChecked = false;
                        }
                    });
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var cancelModal = document.getElementById('cancel-modal');

            // Handle modal show event
            cancelModal.addEventListener('show.bs.modal', function(event) {
                // Get the button that triggered the modal
                var button = event.relatedTarget;

                var withdrawId = button.getAttribute('data-withdraw-id');
                var withdrawAmount = button.getAttribute('data-withdraw-amount');

                var withdrawIdInput = cancelModal.querySelector('#withdraw-id');
                var withdrawAmountDiv = cancelModal.querySelector('#withdraw-amount');

                if (withdrawIdInput) {
                    withdrawIdInput.value = withdrawId;
                }

                if (withdrawAmountDiv) {
                    withdrawAmountDiv.textContent = withdrawAmount;
                }
            });
        });
    </script>
@endpush
