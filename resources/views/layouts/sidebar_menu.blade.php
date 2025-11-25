@extends('layouts.master')

@section('header')
    Sidebar Menu
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Sidebar Menu</li>
@endsection

@section('content')

<section>
    <div class="row">
        {{-- Kolom Kiri: Form Input --}}
        <div class="col-md-6">
            <form action="{{ route('sidebar_menu.store') }}" method="POST" class="card p-3 shadow-sm mb-4">
                @csrf
                <p class="h3 mb-1">Form Tambah Menu</p>
                <p class="text-secondary text-sm">Formulir untuk menambahkan menu baru pada sidebar</p>

                <div class="form-group">
                    <label>Nama Menu</label>
                    <input name="name" class="form-control" required placeholder="Contoh: Dashboard">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Icon (class)</label>
                        <input name="icon" class="form-control" placeholder="Contoh: fas fa-home">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Urutan</label>
                        <input type="number" name="order" class="form-control" value="0" min="0" placeholder="Contoh: 1">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Route Name</label>
                        <input name="route_name" class="form-control" placeholder="Contoh: dashboard.index">
                    </div>
                    <div class="form-group col-md-6">
                        <label>URL</label>
                        <input name="url" class="form-control" placeholder="Contoh: /custom-link">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Parent Menu</label>
                        <select name="parent_id" class="form-control">
                            <option value="">- Tidak Ada (Menu Utama) -</option>
                            @foreach ($menus as $m)
                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Permission</label>
                        <input name="permission_name" class="form-control" placeholder="Contoh: view-dashboard,manage-user">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="custom-control custom-checkbox mt-4">
                            <input type="checkbox" name="is_header" value="1" class="custom-control-input" id="is_header">
                            <label class="custom-control-label" for="is_header">Jadikan sebagai Header</label>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Teks Header</label>
                        <input name="header_text" class="form-control" placeholder="Contoh: MASTER DATA">
                    </div>
                </div>
                @can('update_sidebar_menu')
                    <button class="btn btn-primary"><i class="fas fa-check"></i> Simpan</button>
                @endcan
            </form>
        </div>

        {{-- Kolom Kanan: Daftar Menu --}}
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">    
                <p class="h3 mb-1">Daftar Menu</p>
                <p class="text-secondary text-sm">List Menu yang muncul pada sidebar</p>
                <ul class="list-group">
                    @foreach ($menus as $menu)
                        <li id="menu-{{ $menu->id }}" class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <form method="POST" action="{{ route('sidebar_menu.reorder') }}#menu-{{ $menu->id }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $menu->id }}">
                                    <input type="hidden" name="direction" value="up">
                                    <button class="btn btn-sm btn-outline-secondary" title="Naikkan"><i class="fas fa-arrow-up"></i></button>
                                </form>
                                <form method="POST" action="{{ route('sidebar_menu.reorder') }}#menu-{{ $menu->id }}" class="d-inline mr-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $menu->id }}">
                                    <input type="hidden" name="direction" value="down">
                                    <button class="btn btn-sm btn-outline-secondary" title="Turunkan"><i class="fas fa-arrow-down"></i></button>
                                </form>
                                <span class="mr-3">{{ $menu->order }}</span>
                                <i class="{{ $menu->icon }}"></i> {{ $menu->name }}
                                @if($menu->is_header)
                                    <strong class="text-muted">(Header)</strong>
                                @endif
                            </div>
                            <div>
                                @can('update_sidebar_menu')
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editMenuModal{{ $menu->id }}"><i class="fas fa-pen"></i></button>
                                @endcan
                                @can('delete_sidebar_menu')
                                <form method="POST" action="{{ route('sidebar_menu.destroy', $menu->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                                {{-- Modal Edit --}}
                                <div class="modal fade" id="editMenuModal{{ $menu->id }}" tabindex="-1" role="dialog" aria-labelledby="editMenuLabel{{ $menu->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-md" role="document">
                                        <form method="POST" action="{{ route('sidebar_menu.update', $menu->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Menu {{ $menu->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {{-- Form Edit --}}
                                                    <div class="form-group">
                                                        <label>Nama Menu</label>
                                                        <input name="name" class="form-control" value="{{ $menu->name }}" required placeholder="Contoh: fas fa-home">
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Icon</label>
                                                            <input name="icon" class="form-control" value="{{ $menu->icon }}" placeholder="Contoh: fas fa-home">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Urutan</label>
                                                            <input type="number" name="order" class="form-control" value="{{ $menu->order }}" placeholder="Contoh: 1">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Route Name</label>
                                                            <input name="route_name" class="form-control" value="{{ $menu->route_name }}" placeholder="Contoh: dashboard.index">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>URL</label>
                                                            <input name="url" class="form-control" value="{{ $menu->url }}" placeholder="Contoh: /custom-link">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Parent Menu</label>
                                                            <select name="parent_id" class="form-control">
                                                                <option value="">- Tidak Ada -</option>
                                                                @foreach ($menus as $m)
                                                                    @if($m->id != $menu->id)
                                                                        <option value="{{ $m->id }}" {{ $menu->parent_id == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Permission</label>
                                                            <input name="permission_name" class="form-control" value="{{ $menu->permission_name }}" placeholder="Contoh: view-dashboard,manage-user">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <div class="custom-control custom-checkbox mt-4">
                                                                <input type="checkbox" name="is_header" value="1" class="custom-control-input" id="editHeaderCheck{{ $menu->id }}" {{ $menu->is_header ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="editHeaderCheck{{ $menu->id }}">Jadikan sebagai Header</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Teks Header</label>
                                                            <input name="header_text" class="form-control" value="{{ $menu->header_text }}" placeholder="Contoh: MASTER DATA">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Simpan Perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>

                        @foreach ($menu->children->sortBy('order') as $child)
                            <li id="menu-{{ $child->id }}" class="list-group-item pl-5 d-flex justify-content-between align-items-center">
                                <div>
                                    <form method="POST" action="{{ route('sidebar_menu.reorder') }}#menu-{{ $child->id }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $child->id }}">
                                        <input type="hidden" name="direction" value="up">
                                        <button class="btn btn-sm btn-outline-secondary" title="Naikkan"><i class="fas fa-arrow-up"></i></button>
                                    </form>
                                    <form method="POST" action="{{ route('sidebar_menu.reorder') }}#menu-{{ $child->id }}" class="d-inline mr-2">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $child->id }}">
                                        <input type="hidden" name="direction" value="down">
                                        <button class="btn btn-sm btn-outline-secondary" title="Turunkan"><i class="fas fa-arrow-down"></i></button>
                                    </form>
                                    <span class="mr-3">{{ $child->order }}</span>
                                    {{ $child->name }}
                                </div>
                                <div>
                                    @can('update_sidebar_menu')
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editMenuModal{{ $child->id }}"><i class="fas fa-pen"></i></button>
                                    @endcan
                                    @can('delete_sidebar_menu')
                                    <form method="POST" action="{{ route('sidebar_menu.destroy', $child->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus submenu ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                    @endcan
                                </div>
                            </li>

                            {{-- Modal Edit Submenu --}}
                            <div class="modal fade" id="editMenuModal{{ $child->id }}" tabindex="-1" role="dialog" aria-labelledby="editMenuLabel{{ $child->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <form method="POST" action="{{ route('sidebar_menu.update', $child->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Submenu {{ $child->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                {{-- Form Edit Submenu --}}
                                                <div class="form-group">
                                                    <label>Nama Menu</label>
                                                    <input name="name" class="form-control" value="{{ $child->name }}" required>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Icon</label>
                                                        <input name="icon" class="form-control" value="{{ $child->icon }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Urutan</label>
                                                        <input type="number" name="order" class="form-control" value="{{ $child->order }}">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Route Name</label>
                                                        <input name="route_name" class="form-control" value="{{ $child->route_name }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>URL</label>
                                                        <input name="url" class="form-control" value="{{ $child->url }}">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Parent Menu</label>
                                                        <select name="parent_id" class="form-control">
                                                            <option value="">- Tidak Ada -</option>
                                                            @foreach ($menus as $m)
                                                                @if($m->id != $child->id)
                                                                    <option value="{{ $m->id }}" {{ $child->parent_id == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Permission</label>
                                                        <input name="permission_name" class="form-control" value="{{ $child->permission_name }}">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6 mt-4">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="is_header" value="1" class="custom-control-input" id="editHeaderCheck{{ $child->id }}" {{ $child->is_header ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="editHeaderCheck{{ $child->id }}">Jadikan sebagai Header</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Teks Header</label>
                                                        <input name="header_text" class="form-control" value="{{ $child->header_text }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @can('update_sidebar_menu')
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Simpan Perubahan</button>
                                            </div>
                                            @endcan
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                    @endforeach
                </ul>
                
            </div>
        </div>
    </div>
</section>

@endsection

@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Scroll to specific menu after page load
        const targetId = localStorage.getItem('scrollToMenu');
        if (targetId) {
            const el = document.getElementById(targetId);
            if (el) el.scrollIntoView({ behavior: "smooth", block: "center" });
            localStorage.removeItem('scrollToMenu');
        }

        // Saat klik submit tombol reorder
        document.querySelectorAll("form[action*='sidebar_menu.reorder']").forEach(form => {
            form.addEventListener("submit", function() {
                const idInput = form.querySelector("input[name='id']");
                if (idInput) {
                    localStorage.setItem('scrollToMenu', `menu-${idInput.value}`);
                }
            });
        });

        // Saat submit form edit di modal
        document.querySelectorAll(".modal form").forEach(form => {
            form.addEventListener("submit", function() {
                const id = form.getAttribute("action").match(/sidebar_menu\/(\d+)/);
                if (id && id[1]) {
                    localStorage.setItem('scrollToMenu', `menu-${id[1]}`);
                }
            });
        });
    });
</script>


@endpush