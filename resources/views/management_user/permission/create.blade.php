@extends('layouts.master')

@section('title')
    Buat Permission
@endsection

@section('header')
    Permission Management
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Management User / Permission Management / Buat Permission</li>
@endsection

@section('content')

<section class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ url('management_user/permission') }}" method="POST">
                @csrf

                <div class="mb-3"> <label for="name">Nama Permission</label> <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan Permission" autofocus> @error('name') <span class="text-danger">{{ $message }}</span> @enderror </div>

                <div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
                    <a href="{{ url('management_user/permission') }}" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
<section>

@endsection