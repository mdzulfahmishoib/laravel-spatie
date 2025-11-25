@extends('layouts.master')

@section('title')
    Edit Users
@endsection

@section('header')
    User Management
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Management User / User Management / Edit Users</li>
@endsection

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body p-0">
                <div class="row p-4">
                    <div class="col">
                        <div class="align-items-center text-center">
                            <img id="preview"
                                src="{{ $user->foto ? asset('storage/management_user/foto_profil/' . $user->foto) : asset('img/default_user.jpg') }}"
                                alt="Foto Profil" width="150" class="mt-3 img-circle elevation-2">
                            <h5 class="mt-5 mb-4">Detail Profil</h5>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                    <h6 class="text-bold">Nama</h6>
                                    <p class="mb-0" id="show_nama"></p>
                                </div>
                            </div>
                            <div class="col">
                                <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                    <h6 class="text-bold">Username</h6>
                                    <p class="mb-0" id="show_username"></p>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                    <h6 class="text-bold">Email</h6>
                                    <p class="mb-0" id="show_email"></p>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                    <h6 class="text-bold">Roles</h6>
                                    <span>
                                        <p class="mb-0" id="show_roles"></p>
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <div style="background-color: #E9ECEF;" class="p-3 rounded text-center">
                                    <h6 class="text-bold">Terdaftar Sejak</h6>
                                    <p class="mb-0">{{ tanggal_indonesia($user->created_at) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <form action="{{ url('management_user/users/' . $user->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="">Nama<span class="text-danger"> *</span></label>
                                <input for="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama"
                                    required value="{{ old('name', $user->name) }}" autofocus>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Username<span class="text-danger"> *</span></label>
                                <input type="text" name="username" id="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    placeholder="Masukkan Username" required value="{{ old('username', $user->username) }}">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Email<span class="text-danger"> *</span></label>
                                <input for="text" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email"
                                    required value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Masukkan Password">
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="togglePassword('password', this)"
                                            style="cursor: pointer;">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="roles">Roles<span class="text-danger"> *</span></label>
                                <select name="roles[]" id="roles"
                                    class="form-control @error('roles') is-invalid @enderror" multiple required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}"
                                            {{ in_array($role, old('roles', $userRoles)) ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="file">Foto</label><span class="fw-normal text-muted"> (Opsional)</span>
                                <input type="file" class="form-control" id="file" name="file">
                                @error('file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a href="{{ url('management_user/users') }}" class="btn btn-danger btn-sm"><i
                                class="fas fa-times"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan
                            Perubahan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <section>
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
                document.addEventListener("DOMContentLoaded", function() {
                    // Ambil elemen input dan output
                    const nameInput = document.getElementById("name");
                    const usernameInput = document.getElementById("username");
                    const emailInput = document.getElementById("email");
                    const kantorSelect = document.getElementById("kantor_id");
                    const rolesSelect = document.getElementById("roles");
                    const showName = document.getElementById("show_nama");
                    const showUsername = document.getElementById("show_username");
                    const showEmail = document.getElementById("show_email");
                    const showRoles = document.getElementById("show_roles");

                    // Fungsi update tampilan
                    function updateDisplay() {
                        showName.textContent = nameInput.value;
                        showUsername.textContent = usernameInput.value;
                        showEmail.textContent = emailInput.value;

                        // Ambil semua selected roles
                        const selectedRoles = Array.from(rolesSelect.selectedOptions).map(opt => opt.text).join(', ');
                        showRoles.textContent = selectedRoles;
                    }

                    // Event listener
                    nameInput.addEventListener("input", updateDisplay);
                    usernameInput.addEventListener("input", updateDisplay);
                    emailInput.addEventListener("input", updateDisplay);
                    rolesSelect.addEventListener("change", updateDisplay);

                    // Tampilkan nilai awal saat halaman dimuat
                    updateDisplay();
                });
            </script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const showTerdaftar = document.getElementById("show_terdaftar");

                    function getFormattedDateTime() {
                        const now = new Date();
                        const day = now.getDate();
                        const monthIndex = now.getMonth();
                        const year = now.getFullYear();

                        const dayIndex = now.getDay(); // 0 = Minggu, 6 = Sabtu

                        const dayNames = [
                            "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
                        ];
                        const monthNames = [
                            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                        ];

                        return `${dayNames[dayIndex]}, ${day} ${monthNames[monthIndex]} ${year}`;
                    }

                    showTerdaftar.textContent = getFormattedDateTime();
                });
            </script>

            <script>
                document.getElementById('file').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById('preview');

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
                // Ini supaya input username selalu dikirim dalam huruf kecil
                document.getElementById('username').addEventListener('input', function(e) {
                    e.target.value = e.target.value.toLowerCase();
                });
            </script>
        @endpush
