@extends('layouts.master')

@section('header')
    Beranda
@endsection

@section('title')
    Beranda
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        @php
            use Carbon\Carbon;

            $hour = Carbon::now()->format('H');
            if ($hour >= 5 && $hour < 11) {
                $greeting = 'Selamat Pagi';
            } elseif ($hour >= 11 && $hour < 15) {
                $greeting = 'Selamat Siang';
            } elseif ($hour >= 15 && $hour < 18) {
                $greeting = 'Selamat Sore';
            } else {
                $greeting = 'Selamat Malam';
            }
        @endphp

        <div class="alert alert-info">
            <p class="h5 mb-0"><i class="icon far fa-sun"></i>{{ $greeting }}.. {{ auth()->user()->name }}</p>
            <p class="text-sm mb-0">Selamat Datang di Website {{ $setup_app->nama_aplikasi }} {{ $setup_app->nama_instansi }}
            </p>
        </div>


    </section>
@endsection

@push('script')
@endpush
