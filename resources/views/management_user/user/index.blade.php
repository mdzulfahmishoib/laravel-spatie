@extends('layouts.master')

@section('title')
    User Management
@endsection

@section('header')
    User Management
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Management User / User Management</li>
@endsection

@section('content')

<section>

    <div class="card">
        <div class="card-header">
            <a href="{{ url('management_user/users/create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>  Tambah User</a>
        </div>
        <div class="card-body">
            <table id="tabelku" class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>STATUS</th>
                        <th>NAMA</th>
                        <th>USERNAME</th>
                        <th>EMAIL</th>
                        <th>FOTO</th>
                        <th>ROLES</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label class="switch">
                                    <input type="checkbox" name="is_active" onchange="this.form.submit()" {{ $user->is_active ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </form>
                        </td>
                        <td>{{ $user->name }}</td> 
                        <td>{{ $user->username }}</td> 
                        <td>{{ $user->email }}</td>
                        <td>
                            <img src="{{ $user->foto ? asset('storage/management_user/foto_profil/' . $user->foto) : asset('img/default_user.jpg') }}" alt="{{ $user->name }}" width="50" class="img-circle">
                        </td>
                        <td>
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRolenames() as $rolename)
                                    <label for="" class="badge bg-success text-xs font-weight-normal mx-1">{{ $rolename }}</label>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                            <a href="{{ url('management_user/users/'. $user->id .'/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteUser('{{ url('users/' . $user->id . '/delete') }}')">
                                <i class="fa fa-trash"></i>
                            </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
<section>

@endsection

@push('script')
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
                { "orderable": false, "targets": 7 } // kolom ke-9
            ],
            language: {
                url: '/js/datatables_id.json'
            },
        });
    });
</script>


<script>
    function deleteUser(url) {
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