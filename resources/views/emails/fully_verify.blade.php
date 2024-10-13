@extends('emails.layout')

@section('title', __('Email Verified'))
@section('content')
    <h3 class="title">Your account is fully verified</h3>
    <p class="thanksTxt">
        Thank you for verifying your Gold Era Account and helping us maintain
        a safe and fair trading environment for all.
    </p>
    <a class="startBtn">START TRADING</a>
    <div class="processingImage">
        <img
            src="{{env('APP_URL')}}/emails/email-verified-main/images/verified.png"
            alt="processing"
            class="processingImg"
        />
    </div>
    <div class="whatsnext">
        <img src="{{env('APP_URL')}}/emails/email-verified-main/images/icon.png" alt="hand" />
        <p>You’ve unlocked extra perks!</p>
    </div>
    <div class="ableTo">
        <ul class="extraList">
            <li class="listItem">
                New deposit types: Crypto wallets, bank transfers and more
            </li>
            <li class="listItem">Withdraw profits</li>
            <li class="listItem">Deposit without limits</li>
        </ul>
        <p class="depTitle">Deposit methods</p>
        <ul class="images">
            <li class="imageBox">
                <div class="image">
                    <img src="{{env('APP_URL')}}/emails/email-verified-main/images/visa.png" alt="visa" />
                </div>
                <span>Visa</span>
            </li>
            <li class="imageBox">
                <div class="image">
                    <img src="{{env('APP_URL')}}/emails/email-verified-main/images/master.png" alt="visa" />
                </div>
                <span>Mastercard</span>
            </li>
            <li class="imageBox">
                <div class="image">
                    <img src="{{env('APP_URL')}}/emails/email-verified-main/images/skrill.png" alt="visa" />
                </div>
                <span>Skrill</span>
            </li>
            <li class="imageBox">
                <div class="image">
                    <img src="{{env('APP_URL')}}/emails/email-verified-main/images/neteller.png" alt="visa" />
                </div>
                <span>Neteller</span>
            </li>
            <li class="imageBox">
                <div class="image">
                    <img src="{{env('APP_URL')}}/emails/email-verified-main/images/bank.png" alt="visa" />
                </div>
                <span>Bank Transfer</span>
            </li>
            <li class="imageBox">
                <div class="image">
                    <img src="{{env('APP_URL')}}/emails/email-verified-main/images/eWallet.png" alt="visa" />
                </div>
                <span>eWallet</span>
            </li>
        </ul>
        <p class="happy">Happy trading,</p>
        <p class="sign">Team Gold Era</p>
        <div class="impNote">
            <p class="impNoteTxt">
                <b>Important Notice:</b> The leverage applied to your account may
                be increased or decreased to safeguard against market volatility,
                with or without notice to you. This shall include, without
                limitation, a decrease in leverage <span>one hour</span> prior to
                Market close <span>at the end of each trading week</span>. Please
                monitor and manage your open positions accordingly and refer to
                our website for more information.
            </p>
        </div>
        <div class="liveMarket">
            <h3 class="liveTitle">Open live markets</h3>
            <a class="startBtn">Login</a>
        </div>
    </div>
@endsection
@push('scripts') @endpush
@push('css') @endpush
