@extends('admin.layouts.master')
@section('title', 'Members Directory')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <h2 class="page-title mb-0">Active Members Directory</h2>
                </div>

                <div class="col-auto ms-auto">
                    <form method="GET" action="{{ route('admin.members.index') }}">
                        @php
                            $currentFilter = request()->input('filter');
                        @endphp

                        <div class="d-flex align-items-center">
                            <button type="submit" name="filter"
                                value="{{ $currentFilter === 'online' ? 'all' : 'online' }}"
                                class="btn {{ $currentFilter === 'online' ? 'btn-info' : 'btn-primary' }} me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-filter">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                                </svg>
                                {{ $currentFilter === 'online' ? 'Show All Members' : 'Online Members' }}
                            </button>
                        </div>
                    </form>


                </div>
            </div>

        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            @if ($users->total() > 0)
                <div class="row row-cards mb-3">
                    @foreach ($users as $user)
                        <div class="col-md-6 col-lg-3">
                            <div class="card">
                                <a href="{{ route('admin.members.info', ['uid' => $user->uid]) }}">
                                    <div class="card-body p-4 text-center">
                                        <span class="avatar avatar-xl mb-3 rounded"
                                            style="background-image: url({{ asset('assets/images/flags/' . strtolower($user->country_code) . '.svg') }});border-radius:50%!important">
                                        </span>
                                        <h3 class="m-0 mb-1">{{ $user->name }}</h3>
                                        <div class="text-secondary">{{ $user->email }}</div>
                                        <div class="mt-3">
                                            <span class="badge {{ $user->badgeClass }}">{{ $user->statusMessage }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @include('components.admin.pagination', ['paginator' => $users])
            @endif
        </div>
    </div>
@endsection
