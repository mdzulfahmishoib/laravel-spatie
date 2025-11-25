@extends('layouts.master')

@section('title')
    Edit Role
@endsection

@section('header')
    Role Management
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Management User / Role Management / Edit Role</li>
@endsection

@section('content')

<section class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ url('management_user/roles/'.$role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3"> <label for="name">Nama Role</label> <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" placeholder="Masukkan Nama Role" autofocus> @error('name') <span class="text-danger">{{ $message }}</span> @enderror </div>
                
                <div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Update</button>
                    <a href="{{ url('management_user/roles') }}" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
<section>

@endsection