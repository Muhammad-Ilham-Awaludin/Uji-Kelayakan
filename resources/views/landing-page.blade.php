@extends('layouts.template')

@section('masuk')
<div class="col-lg-6 content-section text-center text-lg-start">
    <h1 class="display-4 fw-bold">Pengaduan Masyarakat</h1>
    <p class="mt-3">
        Sistem pelaporan untuk masyarakat yang ingin menyampaikan aspirasi dan keluhan.
    </p>
    <a href="{{ route('login') }}" class="btn btn-dark btn-lg mt-4">Bergabung!</a>
</div>
@endsection
