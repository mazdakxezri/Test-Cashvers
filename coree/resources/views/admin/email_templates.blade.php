@extends('admin.layouts.master')

@section('title', 'Email Templates')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/panel/dist/libs/summernote/summernote-lite.min.css') }}">
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Email Management</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="col-12">
                    <x-admin.alert />
                </div>
                <div class="card">
                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.email-templates.updateAll') }}">
                            @csrf
                            @method('PUT')

                            @foreach ($emailTemplates as $template)
                                <div class="mb-4">
                                    <h4 class="text-capitalize">{{ str_replace('_', ' ', $template->name) }}</h4>
                                    <textarea class="summernote-editor" name="content[{{ $template->id }}]" id="template-{{ $template->id }}"
                                        rows="10">{{ old('content.' . $template->id, $template->content) }}</textarea>
                                </div>
                            @endforeach

                            <button type="submit" class="btn btn-primary">Save All</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('assets/panel/dist/libs/summernote/summernote-lite.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote-editor').each(function() {
                const placeholder = `Enter email content for template #${$(this).attr('id')}`;
                $(this).summernote({
                    placeholder: placeholder,
                    tabsize: 2,
                    height: 250,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });
        });
    </script>
@endsection
