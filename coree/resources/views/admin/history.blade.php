@extends('admin.layouts.master')
@section('title', 'History')


@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Activities History</h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-secondary">
                                    Show
                                    <div class="mx-2 d-inline-block">
                                        <form method="GET">
                                            <input type="number" name="perPage" class="form-control form-control-sm"
                                                id="paginationInput" value="{{ $historys->perPage() }}"
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

                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <th>user id</th>
                                    <th>Offer ID</th>
                                    <th>Offer Name</th>
                                    <th>Reward</th>
                                    <th>Payout</th>
                                    <th>Status</th>
                                    <th>From</th>
                                    <th>IP</th>
                                    <th>Country</th>
                                    <th>Trx ID</th>
                                    <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historys as $history)
                                        <tr>
                                            <td><a href="{{ route('admin.members.info', ['uid' => $history->uid]) }}"
                                                    target="_blank">{{ $history->uid }}</a></td>
                                            <td>{{ $history->offer_id }}</td>
                                            <td class="text-secondary">
                                                {{ $history->offer_name }}
                                            </td>
                                            <td class="text-secondary">
                                                {{ $history->reward . " " . siteSymbol() }}
                                            </td>
                                            <td class="text-secondary">
                                                $ {{ $history->payout }}
                                            </td>
                                            <td class="text-secondary">
                                                @if ($history->status == 1)
                                                    <span class="badge bg-green text-green-fg">Completed</span>
                                                @elseif ($history->status == 2)
                                                    <span class="badge bg-red text-red-fg">Chargeback</span>
                                                @endif
                                            </td>
                                            <td class="text-secondary text-capitalize">
                                                {{ $history->partners }}
                                            </td>
                                            <td class="text-secondary">
                                                {{ $history->ip }}
                                            </td>
                                            <td class="{{ $history->country ? 'text-secondary' : 'text-danger' }}">
                                                {{ $history->country ?? 'N/A' }}
                                            </td>

                                            <td class="text-secondary">
                                                {{ $history->transaction_id ?? 'N/A' }}
                                            </td>
                                            <td class="text-secondary">
                                                {{ $history->created_at }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        @include('components.admin.pagination', ['paginator' => $historys])
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
