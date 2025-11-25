@extends('layouts.master')

@section('title')
    Edit Role Permission
@endsection

@section('header')
    Role Management
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Management User / Role Management / Edit Role Permission</li>
@endsection

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <span class="h4"><i class="fa fa-user-check mx-2 text-primary"></i><b
                        class="text-primary">{{ $role->name }}</b></span>
                <button type="button" id="uncheckAll" class="btn btn-danger float-right ml-1 btn-sm"><i
                        class="fas fa-times"></i> UnChecklist</button>
                <button type="button" id="checkAll" class="btn btn-success float-right btn-sm"><i
                        class="fas fa-check"></i> Checklist</button>
            </div>
            <div class="card-body p-0">
                <form action="{{ url('roles/' . $role->id . '/give-permissions') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row p-4">
                        <div class="col">
                            <div class="mb-3">
                                @error('permission')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <!-- Table for structured layout -->
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Permission Name</th>
                                            <th class="text-center">Aktif Satu Baris</th>
                                            <th class="text-center">View Menu</th>
                                            <th class="text-center">Create</th>
                                            <th class="text-center">Read</th>
                                            <th class="text-center">Update</th>
                                            <th class="text-center">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td class="text-bold" colspan="8">PENGATURAN</td>
                                        </tr>

                                        <tr>
                                            <td>1</td>
                                            <td>Pengaturan > Management User</td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="toggle-row">
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="row-checkbox" name="permission[]"
                                                        value="view_management_user"
                                                        {{ in_array('view_management_user', $rolePermissions) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="row-checkbox" name="permission[]"
                                                        value="create_management_user"
                                                        {{ in_array('create_management_user', $rolePermissions) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="row-checkbox" name="permission[]"
                                                        value="read_management_user"
                                                        {{ in_array('read_management_user', $rolePermissions) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="row-checkbox" name="permission[]"
                                                        value="update_management_user"
                                                        {{ in_array('update_management_user', $rolePermissions) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="row-checkbox" name="permission[]"
                                                        value="delete_management_user"
                                                        {{ in_array('delete_management_user', $rolePermissions) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>Pengaturan > Setup Aplikasi</td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="toggle-row">
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="row-checkbox" name="permission[]"
                                                        value="view_setup_app"
                                                        {{ in_array('view_setup_app', $rolePermissions) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="row-checkbox" name="permission[]"
                                                        value="update_setup_app"
                                                        {{ in_array('update_setup_app', $rolePermissions) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>Pengaturan > Sidebar Menu</td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="toggle-row">
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="row-checkbox" name="permission[]"
                                                        value="view_sidebar_menu"
                                                        {{ in_array('view_sidebar_menu', $rolePermissions) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="row-checkbox" name="permission[]"
                                                        value="create_sidebar_menu"
                                                        {{ in_array('create_sidebar_menu', $rolePermissions) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td></td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="row-checkbox" name="permission[]"
                                                        value="update_sidebar_menu"
                                                        {{ in_array('update_sidebar_menu', $rolePermissions) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="row-checkbox" name="permission[]"
                                                        value="delete_sidebar_menu"
                                                        {{ in_array('delete_sidebar_menu', $rolePermissions) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td></td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan
                            Perubahan</button>
                        <a href="{{ url('management_user/roles') }}" class="btn btn-danger btn-sm"><i
                                class="fas fa-times"></i> Kembali</a>
                    </div>
                </form>
            </div>


        </div>
        <section>

            <script>
                // JavaScript untuk mencentang semua checkbox
                document.getElementById('checkAll').addEventListener('click', function() {
                    var checkboxes = document.querySelectorAll('input[type="checkbox"].row-checkbox');
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = true;
                    });
                });

                // JavaScript untuk unchecklist
                document.getElementById('uncheckAll').addEventListener('click', function() {
                    var checkboxes = document.querySelectorAll('input[type="checkbox"].row-checkbox');
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                });
            </script>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.toggle-row').forEach(function(toggle) {
                        toggle.addEventListener('change', function() {
                            // Cari tr (baris) terdekat
                            const tr = this.closest('tr');
                            // Cari semua checkbox di baris tersebut yang punya class row-checkbox
                            const checkboxes = tr.querySelectorAll('.row-checkbox');

                            checkboxes.forEach(function(checkbox) {
                                checkbox.checked = toggle.checked;
                            });
                        });
                    });
                });
            </script>
        @endsection
