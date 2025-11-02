@extends('admin.layouts.master')
@section('title', 'Banned Members')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Banned Members Directory</h2>
                    @if ($users->total() > 0)
                        <div class="text-secondary mt-1">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} people
                        </div>
                    @endif
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
                                            @if ($user->status == 'active')
                                                <span class="badge bg-green-lt">{{ $user->status }}</span>
                                            @else
                                                <span class="badge bg-red-lt">{{ $user->status }}</span>
                                            @endif
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
