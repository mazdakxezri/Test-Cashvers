@extends('admin.layouts.master')
@section('title', 'Members Info')


@section('content')


    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <x-admin.alert />
                    <div class="card">
                        <div class="px-3 py-3 bg-blue-lt relative">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl mb-3 rounded"
                                        style="background-image: url({{ asset('assets/images/flags/' . strtolower($user->country_code) . '.svg') }});border-radius:50%!important">
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="h4 mb-0 d-flex align-items-center justify-content-between"
                                        aria-label="User ID and Level">
                                        <span>ID: {{ $user->uid }}</span>
                                        <span class="badge bg-cyan text-cyan-fg">Level {{ $user->level }}</span>
                                    </div>

                                    <div class="mb-2 small">Member since: {{ $user->created_at }}</div>
                                    <span class="badge bg-blue text-blue-fg d-inline-flex">Balance:
                                        {{ $user->balance . ' ' . siteSymbol() }}
                                        <a href="#" class="px-1 ml-2 text-white" data-bs-backdrop="static"
                                            data-bs-keyboard="false" data-bs-toggle="modal"
                                            data-bs-target="#modal-balance-add">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z"></path>
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                        </a>

                                        <a href="#" class="ml-1 text-white" data-bs-backdrop="static"
                                            data-bs-keyboard="false" data-bs-toggle="modal"
                                            data-bs-target="#modal-balance-deduct">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z"></path>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                        </a>

                                    </span>
                                </div>
                            </div>
                        </div>
                        <form class="card-body" method="post" action="{{ route('admin.members.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-2">
                                <span class="form-label mb-1">Name of user:</span>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                            </div>
                            <div class="mb-2">
                                <span class="form-label mb-1">Email address:</span>
                                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">Gender:</span>
                                <input type="text" class="form-control" value="{{ $user->gender }}" readonly>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">Date Of Birth:</span>
                                <input type="text" class="form-control" name=""
                                    value="{{ $user->date_of_birth }}">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">Referred by:</span>
                                <input type="text" class="form-control" value="{{ $referredBy }}" readonly>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">User Agent:</span>
                                <input type="text" class="form-control" readonly value="{{ $user->user_agent }}">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">Register IP:</span>
                                <input type="text" class="form-control" value="{{ $user->ip }}" readonly>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">Last Login IP:</span>
                                <input type="text" class="form-control" value="{{ $user->last_login_ip }}" readonly>
                            </div>
                            <div class="mt-3 mb-3">
                                <span class="form-label mb-1">New password:</span>
                                <input type="text" class="form-control" name="pass" value="">
                            </div>
                            <button type="submit" class="btn btn-block btn-primary w-100">Update user data</button>
                        </form>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12">
                                    <form
                                        action="{{ route('admin.members.status.change', [$user->id, $user->status === 'banned' ? 'unban' : 'ban']) }}"
                                        method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="w-100 btn btn-block {{ $user->status === 'banned' ? 'btn-outline-success' : 'btn-outline-danger' }}">
                                            {{ $user->status === 'banned' ? 'Unban this user' : 'Ban this user' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-8">

                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title me-3 text-nowrap">Withdrawals History</h3>
                        </div>
                        <div class=" table-responsive">
                            <table class="table table-vcenter card-table table-striped">
                                <thead>
                                    <tr>
                                        <th>Method</th>
                                        <th>To</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdrawals as $withdrawal)
                                        <tr>
                                            <td>{{ $withdrawal->category->name }}</td>
                                            <td class="text-secondary">
                                                {{ $withdrawal->redeem_wallet }}
                                            </td>
                                            <td class="text-secondary">
                                                {{ $withdrawal->amount . ' ' . siteSymbol() }}
                                            </td>
                                            <td class="text-secondary">
                                                @if ($withdrawal->status === 'pending')
                                                    <span class="badge bg-yellow text-yellow-fg">Pending</span>
                                                @elseif ($withdrawal->status === 'completed')
                                                    <span class="badge bg-green text-green-fg">Completed</span>
                                                @elseif ($withdrawal->status === 'rejected')
                                                    <span class="badge bg-red text-red-fg">Rejected</span>
                                                @elseif ($withdrawal->status === 'refunded')
                                                    <span class="badge bg-azure text-azure-fg">Refunded</span>
                                                @endif
                                            </td>

                                            <td class="text-secondary">
                                                {{ $withdrawal->created_at->format('Y-m-d') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @include('components.admin.pagination', ['paginator' => $withdrawals])
                    </div>


                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title mr-3 text-nowrap">Activities history</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
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
                                    @foreach ($activities as $activity)
                                        <tr>
                                            <td>{{ $activity->offer_id }}</td>
                                            <td class="text-secondary">
                                                {{ $activity->offer_name }}
                                            </td>
                                            <td class="text-secondary">
                                                {{ $activity->reward . ' ' . siteSymbol() }}
                                            </td>
                                            <td class="text-secondary">
                                                $ {{ $activity->payout }}
                                            </td>
                                            <td class="text-secondary">
                                                @if ($activity->status == 1)
                                                    <span class="badge bg-green text-green-fg">Completed</span>
                                                @elseif ($activity->status == 2)
                                                    <span class="badge bg-red text-red-fg">Chargeback</span>
                                                @endif
                                            </td>
                                            <td class="text-secondary text-capitalize">
                                                {{ $activity->partners }}
                                            </td>
                                            <td class="text-secondary">
                                                {{ $activity->ip }}
                                            </td>
                                            <td class="{{ $activity->country ? 'text-secondary' : 'text-danger' }}">
                                                {{ $activity->country ?? 'N/A' }}
                                            </td>

                                            <td class="text-secondary">
                                                {{ $activity->transaction_id ?? 'N/A' }}
                                            </td>
                                            <td class="text-secondary">
                                                {{ $activity->created_at }}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        @include('components.admin.pagination', ['paginator' => $activities])

                    </div>


                    @if ($invitedCount > 0)
                        <div class="card mb-3">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h3 class="card-title mb-0">
                                    Referred Users
                                </h3>
                                <span class="badge bg-red text-red-fg">
                                    Total Invited: {{ $invitedCount }}
                                </span>
                            </div>

                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                        <tr>
                                            <th>User Info</th>
                                            <th>Commission Earned</th>
                                            <th>Referred At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($referrals as $referral)
                                            <tr>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar avatar-2 me-2"
                                                            style="background-image: url({{ asset('assets/images/flags/' . strtolower($referral->referredUser->country_code) . '.svg') }})">
                                                        </span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">
                                                                {{ $referral->referredUser->name }}</div>
                                                            <div class="text-secondary"><a
                                                                    href="{{ route('admin.members.info', ['uid' => $referral->referredUser->uid]) }}"
                                                                    class="text-reset">{{ $referral->referredUser->email }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary">
                                                    {{ number_format($referral->earnings, 2) . ' ' . siteSymbol() }}
                                                </td>
                                                <td class="text-secondary">
                                                    {{ $referral->created_at->format('Y-m-d') }}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            @include('components.admin.pagination', ['paginator' => $activities])

                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>


    <!-- Add Balance Modal -->
    <form method="post" action="{{ route('admin.members.balance.add', ['id' => $user->id]) }}"
        class="modal modal-blur fade" id="modal-balance-add" tabindex="-1" role="dialog" aria-hidden="true">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">How many {{ siteSymbol() }} do you want to add?</div>
                    <div><input type="text" class="form-control" name="balance"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Add Balance</button>
                </div>
            </div>
        </div>
    </form>
    <!-- Deduct Balance Modal -->
    <form method="post" action="{{ route('admin.members.balance.deduct', ['id' => $user->id]) }}"
        class="modal modal-blur fade" id="modal-balance-deduct" tabindex="-1" role="dialog" aria-hidden="true">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">How many {{ siteSymbol() }} do you want to deduct?</div>
                    <div><input type="text" class="form-control" name="balance"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Deduct Balance</button>
                </div>

            </div>
        </div>
    </form>

@endsection
