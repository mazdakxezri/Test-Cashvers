@extends($activeTemplate . '.layouts.app')
@section('title', 'Privacy Policy')

@section('content')

    <section class="tos my-3">

        <div class="tos-title text-center mb-5">
            <h1>privacy policy</h1>
            <small>last update: {{ $privacy->formatted_updated_at }}</small>
        </div>

        <div class="tos-content">
            {!! $privacy->privacy_policy !!}
        </div>


    </section>

@endsection
