<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{env('APP_URL')}}/emails/email-processing-main/images/favicon.ico">
    <title>@yield('title', __('Email'))</title>
    <link rel="stylesheet" href="{{env('APP_URL')}}/emails/email-processing-main/css/style.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}/emails/email-processing-main/css/normalize.css" />
    <link rel="stylesheet" href="{{env('APP_URL')}}/emails/email-processing-main/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap"
    />

    @stack('scripts')
    @stack('css')
</head>
<body>
<div class="mainContainer">
    <header class="header">
        <p class="openin">Open in browser</p>
        <img src="{{env('APP_URL')}}/emails/email-processing-main/images/black-logo.png" alt="logo" class="logoImg" />
    </header>

    <section class="content">
        @yield('content')

        <div class="legal">
            <div class="bottomLogo">
                <img src="{{env('APP_URL')}}/emails/email-processing-main/images/black-logo.png" alt="logo" />
            </div>
            <a href="#" class="legalUrl">Legal Documentation</a>
            <p class="p1">
                Yum Gutt Legal Documentation Margined FX and contracts for difference
                are complex leveraged products which carry a high level of risk and
                can result in losses that exceed your initial investment. We
                recommend you seek professional advice before investing.
            </p>
            <p class="p2">
                Yum Gutt Brokerage (Seychelles) Limited is a company incorporated with
                limited liability under the laws of the Republic of Seychelles,
                under registration number 8428558-1, with its registered address at
                First Floor, Marina House, Eden Island, Republic of Seychelles.
            </p>
            <p class="p3">
                Yum Gutt Brokerage (Seychelles) Limited is authorised by the Financial
                Services Authority of Seychelles under license number SD064 as a
                Securities Dealers Broker.
            </p>
            <p class="p4">
                We provide an execution-only service. We do not provide investment
                advice or management services. Any analysis, opinion, commentary or
                research-based material in this e-mail is for information and
                educational purposes only and is not, under any circumstances,
                intended to be an offer, recommendation, advice or solicitation to
                buy or sell.
            </p>
        </div>
    </section>
    <footer class="footer">
        <p class="copyrights">&copy; {{Illuminate\Support\Carbon::now()->year}} Gold Era</p>
        <p class="address">First Floor, Marina House, Eden Island, Republic of Seychelles</p>
    </footer>
</div>

</body>
</html>
