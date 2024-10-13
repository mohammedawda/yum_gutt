@extends('emails.layout')

@section('title', __('Email Verification Code'))
@section('content')
{{--        <h3 class="title">Hi {{ $mailData['name'] }}</h3>--}}
        <h3 class="title">Your email verification code</h3>
        <p class="thanksTxt">Thank you for setting up your account, here’s your code.</p>
        <p class="code">{{ $mailData['code'] }}</p>
        <div class="ableTo">
            <p class="happy">Happy trading,</p>
            <p class="sign">Team Yum Gutt</p>
        </div>
@endsection
@push('scripts') @endpush
@push('css') @endpush
