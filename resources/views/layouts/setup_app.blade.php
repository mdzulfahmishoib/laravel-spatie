@extends('layouts.master')

@section('title')
    Setup Aplikasi
@endsection

@section('header')
    Setup Aplikasi
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Setup Aplikasi</li>
@endsection

@section('content')
    <section>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="col mr-3 mt-4">
                            <div class="mb-3">
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="align-items-center text-center">
                                            <img id="preview_1"
                                                src="{{ $setup_app->logo_aplikasi ? asset('storage/uploads/' . $setup_app->logo_aplikasi) : '' }}"
                                                alt="Foto Profil" width="150" class="mt-3 img-circle elevation-2">
                                            <h5 class="mt-3 mb-4">Logo Aplikasi</h5>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="align-items-center text-center">
                                            <img id="preview_2"
                                                src="{{ $setup_app->logo_instansi ? asset('storage/uploads/' . $setup_app->logo_instansi) : '' }}"
                                                alt="Foto Profil" width="150" class="mt-3 img-circle elevation-2">
                                            <h5 class="mt-3 mb-4">Logo Instansi</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                            <h6 class="text-bold">Nama Aplikasi</h6>
                                            <p class="mb-0">{{ $setup_app->nama_aplikasi }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                            <h6 class="text-bold">Nama Instansi</h6>
                                            <p class="mb-0">{{ $setup_app->nama_instansi }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col">
                                        <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                            <h6 class="text-bold">Alamat</h6>
                                            <p class="mb-0">{{ $setup_app->alamat }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Form Setup Aplikasi</h3>
                    </div>
                    <div class="card-body p-0">
                        <form action="{{ route('setup_app.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row p-4">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nama_aplikasi">Nama Aplikasi<span class="text-danger"> *</span></label>
                                        <input type="text" name="nama_aplikasi" id="nama_aplikasi" class="form-control"
                                            value="{{ old('nama_aplikasi', $setup_app->nama_aplikasi) }}"
                                            placeholder="Masukkan Nama Aplikasi">
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi_aplikasi">Deskripsi Aplikasi<span class="text-danger">
                                                *</span></label>
                                        <input type="text" name="deskripsi_aplikasi" id="deskripsi_aplikasi"
                                            class="form-control"
                                            value="{{ old('deskripsi_aplikasi', $setup_app->deskripsi_aplikasi) }}"
                                            placeholder="Masukkan Deskripsi Aplikasi">
                                    </div>

                                    <div class="mb-3">
                                        <label for="nama_instansi">Nama Instansi<span class="text-danger">
                                                *</span></label>
                                        <input type="text" name="nama_instansi" id="nama_instansi" class="form-control"
                                            value="{{ old('nama_instansi', $setup_app->nama_instansi) }}"
                                            placeholder="Masukkan Nama Instansi">
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat">Alamat<span class="text-danger"> *</span></label>
                                        <textarea name="alamat" id="alamat" rows="4" class="form-control" placeholder="Masukkan Alamat Instansi">{{ old('alamat', $setup_app->alamat) }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="logo_1" class="form-label">Logo Aplikasi <span
                                                        class="text-danger">*max 2MB</span></label>
                                                <div>
                                                    <img id="preview_image" src="" alt="Preview"
                                                        class="img-thumbnail mb-2 d-none" width="100">
                                                </div>
                                                <input type="file" name="logo_1" id="logo_1" accept="image/*"
                                                    class="form-control @error('logo_1') is-invalid @enderror">
                                                @error('logo_1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="logo_2" class="form-label">Logo Instansi <span
                                                    class="text-danger">*max 2MB</span></label>
                                            <div>
                                                <img id="preview_image" src="" alt="Preview"
                                                    class="img-thumbnail mb-2 d-none" width="100">
                                            </div>
                                            <input type="file" name="logo_2" id="logo_2" accept="image/*"
                                                class="form-control @error('logo_2') is-invalid @enderror">
                                            @error('logo_2')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan
                                    Perubahan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <section>
        @endsection

        @push('script')
            <script>
                document.getElementById('logo_1').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById('preview_1');

                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            </script>
            <script>
                document.getElementById('logo_2').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById('preview_2');

                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            </script>
        @endpush
