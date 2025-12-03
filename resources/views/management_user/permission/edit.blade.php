@extends('layouts.master')

@section('title')
    Edit Permission
@endsection

@section('header')
    Permission Management
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Management User</li>
    <li class="breadcrumb-item active">Permission Management</li>
@endsection

@section('content')

<section class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ url('management_user/permission/'.$permission->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3"> <label for="name">Nama Permission</label> <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $permission->name) }}" placeholder="Masukkan Nama Permission"> @error('name') <span class="text-danger" autofocus>{{ $message }}</span> @enderror </div>
                
                <div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Update</button>
                    <a href="{{ url('management_user/permission') }}" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
<section>

@endsection