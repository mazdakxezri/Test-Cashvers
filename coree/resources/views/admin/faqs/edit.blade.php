@extends('admin.layouts.master')
@section('title', 'Edit FAQ')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-admin.alert />
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit FAQ</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Question</label>
                                    <input type="text" class="form-control @error('question') is-invalid @enderror"
                                        name="question" value="{{ old('question', $faq->question) }}" required>
                                    @error('question')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Answer</label>
                                    <textarea class="form-control @error('answer') is-invalid @enderror" name="answer" rows="4" required>{{ old('answer', $faq->answer) }}</textarea>
                                    @error('answer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-6 btn-success">Update FAQ</button>
                                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
