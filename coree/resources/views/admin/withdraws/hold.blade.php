@extends('admin.layouts.master')

@section('title', 'All Withdrawals')

@section('content')
    @include('admin.partials.withdraws', [
        'status' => 'hold',
        'totalHoldWithdrawals' => $totalHoldWithdrawals,
    ])
@endsection
