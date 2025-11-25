@extends('layouts.master')

@section('title')
    Role Management
@endsection

@section('header')
    Role Management
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Management User / Role Management</li>
@endsection

@section('content')

<section>

    <div class="card">
        <div class="card-header">
            <!-- Tombol untuk membuka modal -->
            <button type="button" id="openCreateRoleModal" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Role
            </button>

        </div>
        <div class="card-body">
            <table id="tabelku" class="table table-bordered table-sm table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th width="800px">NAMA</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $index => $role)
                    <tr>
                        <td>{{ $index + 1 }}</td> <!-- Display the number -->
                        <td>{{ $role->name }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ url('roles/'. $role->id .'/give-permissions') }}" class="btn btn-success btn-sm">
                                    <i class="fa fa-user-check"></i>
                                </a>
                                <button type="button" class="btn btn-primary btn-sm editRoleBtn" data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-action="{{ url('management_user/roles/' . $role->id) }}"> <i class="fa fa-pen"></i> </button>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteRole('{{ url('roles/' . $role->id . '/delete') }}')"> <i class="fa fa-trash"></i> </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
<section>


<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="roleForm" method="POST">
        @csrf
        <!-- Akan diganti pakai JS saat edit -->
        <input type="hidden" name="_method" id="formMethod" value="POST">

        <div class="modal-header">
          <h5 class="modal-title" id="roleModalLabel">Tambah Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nama Role</label>
            <input type="text" name="name" id="roleNameInput"
              class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name') }}" placeholder="Masukkan Nama Role">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('script')

<script>
    $(document).ready(function () {
        // Tombol tambah role
        $('#openCreateRoleModal').on('click', function () {
            $('#roleForm').attr('action', "{{ url('management_user/roles') }}");
            $('#formMethod').val('POST');
            $('#roleNameInput').val('');
            $('#roleModalLabel').text('Tambah Role');
            $('#roleModal').modal('show');
        });

        // Tombol edit role
        $('.editRoleBtn').on('click', function () {
            const action = $(this).data('action');
            const name = $(this).data('name');

            $('#roleForm').attr('action', action);
            $('#formMethod').val('PUT');
            $('#roleNameInput').val(name);
            $('#roleModalLabel').text('Edit Role');
            $('#roleModal').modal('show');
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const triggerButton = document.getElementById('openCreateRoleModal');
        const modalElement = document.getElementById('createRoleModal');

        if (triggerButton && modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            triggerButton.addEventListener('click', () => {
                modal.show();
            });
        }
    });
</script>


<script>
    function deleteRole(url) {
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

<script>
    $(document).ready(function () {
        $('#tabelku').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": false,
            "columnDefs": [
                { "orderable": false, "targets": 2 }
            ],
            language: {
                url: '/js/datatables_id.json'
            },
        });
    });
</script>

@endpush