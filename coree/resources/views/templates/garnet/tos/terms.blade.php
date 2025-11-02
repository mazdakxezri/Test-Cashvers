@extends($activeTemplate . '.layouts.app')
@section('title', 'Terms Of Use')

@section('content')

    <section class="tos my-3">

        <div class="tos-title text-center mb-5">
            <h1>terms of use</h1>
            <small>last update: {{ $terms->formatted_updated_at }}</small>
        </div>

        <div class="tos-content">
            {!! $terms->terms_of_use !!}
        </div>


    </section>

@endsection
