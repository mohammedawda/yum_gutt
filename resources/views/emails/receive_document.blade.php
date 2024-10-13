@extends('emails.layout')

@section('title', __('Email Upload'))
@section('content')
    <h3 class="title">{{ $mailData['name'] }},</h3>
    <p class="thankText">Thank you for uploading supporting documents for your online application.</p>
    <p class="thankText">We will review and confirm your application shortly. Should we have any additional information required, we will contact you.</p>
    <p class="thankText">Kind regards,</p>
@endsection
@push('scripts') @endpush
@push('css') @endpush
