@extends('admin.layouts.master')
@section('title', 'Manage FAQs')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-admin.alert />
            <div class="row">
                <!-- Left Column: Add FAQ -->
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New FAQ</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.faqs.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Question</label>
                                    <input type="text" class="form-control" name="question" value="{{ old('question') }}"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Answer</label>
                                    <textarea class="form-control" name="answer" rows="4" required>{{ old('answer') }}</textarea>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Add FAQ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: List FAQs -->
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">All FAQs</h3>
                        </div>
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Question</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($faqs as $faq)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $faq->question }}</td>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <a href="{{ route('admin.faqs.edit', $faq->id) }}"
                                                            class="btn btn-1"> Edit </a>
                                                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-red"
                                                                onclick="return confirm('Are you sure you want to delete this FAQ?')">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No FAQs found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @include('components.admin.pagination', ['paginator' => $faqs])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
