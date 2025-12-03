@extends('layouts.master')

@section('title')
    Permission Management
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
        <div class="card-header">
            <a href="{{ url('management_user/permission/create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>  Tambah Permission</a>
        </div>
        <div class="card-body">
            <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-exclamation-triangle"></i>Perhatian!</h5>
                  Dimohon untuk tidak mengubah atau menghapus permission basis data di bawah ini kecuali jika benar-benar diperlukan, karena permission tersebut saling terkait dengan tampilan dan fungsi program lainnya.
            </div>
            <table class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th width="1000px">NAMA</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Pengelompokan data berdasarkan kata sebelum karakter "_"
                        $groupedPermissions = [];
                        foreach ($permissions as $permission) {
                            $key = strtok($permission->name, '_'); // Mengambil kata sebelum karakter "_"
                            $groupedPermissions[$key][] = $permission;
                        }
                    @endphp

                    @foreach ($groupedPermissions as $key => $permissionsGroup)
                        <tr>
                            <td colspan="3" style="text-transform: capitalize; text-align: center; font-weight: bold; color:white; background-color: #007BFF;"><?= $key ?></td>
                        </tr>
                        @foreach ($permissionsGroup as $index => $permission)
                            <tr>
                                <td>{{ $loop->parent->iteration + $index }}</td> <!-- Menampilkan nomor urut -->
                                <td>{{ $permission->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm editPermissionBtn" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}" data-action="{{ url('management_user/permission/'.$permission->id) }}" title="Edit Data"> <i class="fa fa-pen"></i> </button>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deletePermission('{{ url('permission/' . $permission->id . '/delete') }}')" title="Hapus Data">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>                
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="permissionForm" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <div class="modal-header">
          <h5 class="modal-title" id="permissionModalLabel">Edit Permission</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="permissionNameInput">Nama Permission</label>
            <input type="text" name="name" id="permissionNameInput" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="Masukkan Nama Permission">
            @error('name') <span class="text-danger" autofocus>{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection

@push('script')
<script>
    $(document).ready(function () {
        $('.editPermissionBtn').on('click', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const action = $(this).data('action');

            // Atur action form dan isi input
            $('#permissionForm').attr('action', action);
            $('#permissionNameInput').val(name);
            $('#permissionModalLabel').text('Edit Permission');

            // Tampilkan modal
            $('#permissionModal').modal('show');
        });
    });
</script>

    <script>
        function deletePermission(url) {
            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data ini?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the delete URL if confirmed
                    window.location.href = url;
                }
            });
        }
    </script>

@endpush