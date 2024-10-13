@extends('emails.layout')

@section('title', __('Email'))
@section('content')
    <h3 class="title">We’re processing your documents</h3>
    <p class="thanksTxt">
        Thank you for sharing your documents with us, we’ll get back to you
        soon.
    </p>
    <div class="processingImage">
        <img
            src="{{env('APP_URL')}}/emails/email-processing-main/images/processing.png"
            alt="processing"
            class="processingImg"
        />
    </div>
    <div class="whatsnext">
        <img src="{{env('APP_URL')}}/emails/email-processing-main/images/hand.png" alt="hand" />
        <p>What's next?</p>
    </div>
    <div class="ableTo">
        <p class="once">
            Once your documents are accepted, we’ll email you that your account
            has been verified. You’ll then be able to:
        </p>
        <ul>
            <li>Access more deposit types</li>
            <li>Withdraw profits*</li>
            <li>Deposit without limits</li>
        </ul>
        <p class="happy">Happy trading,</p>
        <p class="sign">Team Gold Era</p>
    </div>
@endsection
@push('scripts') @endpush
@push('css') @endpush
