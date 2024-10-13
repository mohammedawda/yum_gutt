@extends('emails.layout')

@section('title', __('Email Verification Code'))
@section('content')
        <h3 class="title">Hi {{ $mailData['name'] }}</h3>
        <h3 class="title">Your email for change password</h3>
        <p class="thanksTxt">If you did not change the password, you can change it again.</p>
{{--        <p class="code">{{ $mailData['code'] }}</p>--}}
        <div class="ableTo">
            <p class="happy">Happy trading,</p>
            <p class="sign">Team GoldEra</p>
        </div>
@endsection
@push('scripts') @endpush
@push('css') @endpush
