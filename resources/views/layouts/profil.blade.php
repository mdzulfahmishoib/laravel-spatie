@extends('layouts.master')

@section('header')
    Profil
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profil</li>
@endsection

@section('content')

<section class="content">
    <div class="card">
        <div class="card-body p-0">
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row p-4">
                    <div class="col mr-3 mt-5">
                        <div class="mb-3">
                            <div class="align-items-center text-center">
                                <img id="preview" src="{{ auth()->user()->foto ? asset('storage/management_user/foto_profil/' . auth()->user()->foto) : asset('img/default_user.jpg') }}" alt="Foto Profil" width="150" class="mt-3 img-circle elevation-2">
                                <h5 class="mt-5 mb-4">Detail Profil</h5>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                        <h6 class="text-bold">Nama</h6>
                                        <p class="mb-0">{{ $user->name }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                        <h6 class="text-bold">Username</h6>
                                        <p class="mb-0">{{ $user->username }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col">
                                    <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                        <h6 class="text-bold">Email</h6>
                                        <p class="mb-0">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col">
                                    <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                        <h6 class="text-bold">Roles</h6>

                                        @php
                                            $currentUser = auth()->user(); // Ambil user yang sedang login
                                        @endphp
    
                                        <span>
                                            @if ($currentUser->getRoleNames() && $currentUser->getRoleNames()->isNotEmpty())
                                                @foreach ($currentUser->getRoleNames() as $rolename)
                                                    <p class="mb-0">{{ $rolename }}</p>
                                                @endforeach
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row mt-3">
                                <div class="col">
                                    <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                        <h6 class="text-bold">Terdaftar Sejak</h6>

                                        <p class="mb-0">{{ tanggal_indonesia(auth()->user()->created_at) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="mb-3">
                            <h3>Perbarui Profil</h3>
                        </div>
                        <div class="mb-3">
                            <label for="name">Nama<span class="text-danger"> *</span></label>
                            <input type="text" name="name" value="{{ $user->name }}" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="username">Username<span class="text-danger"> *</span></label>
                            <input type="text" name="username" value="{{ $user->username }}" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan Username">
                            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
        
                        <div class="mb-3">
                            <label for="email">Email<span class="text-danger"> *</span></label>
                            <input type="email" name="email" value="{{ $user->email }}" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
        
                        <div class="mb-3">
                            <label for="current_password">Password Saat Ini<span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required placeholder="Masukkan Password Saat ini">
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePassword('current_password', this)" style="cursor: pointer;">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password">Password Baru</label><span class="fw-normal text-muted"> (Kosongkan jika tidak ingin mengubah)</span>
                            <div class="input-group">
                                <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Masukkan Password Baru">
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePassword('new_password', this)" style="cursor: pointer;">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            @error('new_password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" placeholder="Masukkan Konfirmasi Password">
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePassword('new_password_confirmation', this)" style="cursor: pointer;">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            @error('new_password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="foto">Foto Profil</label><span class="fw-normal text-muted"> (Opsional)</span>
                            <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror">
                            @error('foto') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a href="{{ url()->previous() }}" class="btn btn-danger"><i class="fas fa-times"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@push('script')
<script>
    function togglePassword(fieldId, toggleElement) {
        const input = document.getElementById(fieldId);
        const icon = toggleElement.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

<script>
    document.getElementById('foto').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

<script>
    // Ini supaya input username selalu dikirim dalam huruf kecil
    document.getElementById('username').addEventListener('input', function(e) {
        e.target.value = e.target.value.toLowerCase();
    });
</script>
@endpush