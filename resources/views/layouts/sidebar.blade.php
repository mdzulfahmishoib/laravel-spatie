  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('beranda') }}" class="brand-link">
          <img src="{{ $setup_app->logo_aplikasi ? asset('storage/uploads/' . $setup_app->logo_aplikasi) : '' }}"
              alt="Logo {{ $setup_app->nama_aplikasi }}" class="brand-image img-circle elevation-1">
          <span class="brand-text font-weight-light">{{ $setup_app->nama_aplikasi }}</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image mt-3">
                  <img src="{{ auth()->user()->foto ? asset('storage/management_user/foto_profil/' . auth()->user()->foto) : asset('img/default_user.jpg') }}"
                      class="img-circle elevation-1" alt="User Image">
              </div>
              <div class="info">
                  <a class="d-block mb-1" href="{{ route('layouts.profil') }}">Halo, {{ auth()->user()->name }}</a>
                  @php
                      $currentUser = auth()->user(); // Ambil user yang sedang login
                  @endphp

                  <span>
                      @if ($currentUser->getRoleNames() && $currentUser->getRoleNames()->isNotEmpty())
                          @foreach ($currentUser->getRoleNames() as $rolename)
                              <span
                                  class="badge bg-success d-inline font-weight-normal text-xs">{{ $rolename }}</span>
                          @endforeach
                      @endif
                  </span>

              </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>


          <nav class="mt-3">
              <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact" data-widget="treeview"
                  role="menu" data-accordion="false">

                  @foreach ($menus as $menu)
                      @php
                          // Ambil permission dan pecah jadi array
                          $permissions = $menu->permission_name
                              ? array_map('trim', explode(',', $menu->permission_name))
                              : [];
                      @endphp

                      {{-- Header --}}
                      @if ($menu->is_header)
                          @if (empty($permissions) || auth()->user()->canAny($permissions))
                              <li class="nav-header text-bold">{{ $menu->header_text }}</li>
                          @endif
                          @continue
                      @endif

                      {{-- Cek akses menu utama --}}
                      @if ($menu->permission_name && !auth()->user()->canAny($permissions))
                          @continue
                      @endif

                      {{-- Menu dengan submenu --}}
                      @if ($menu->children->count())
                          @php
                              $childRoutes = $menu->children->pluck('route_name')->filter()->toArray();
                              $childUrls = $menu->children->pluck('url')->filter()->toArray();
                              $isActive = false;

                              // Cek active berdasarkan nama route
                              foreach ($childRoutes as $route) {
                                  if (request()->routeIs($route . '*')) {
                                      $isActive = true;
                                      break;
                                  }
                              }

                              // Cek active berdasarkan URL jika tidak ada route
                              if (!$isActive) {
                                  foreach ($childUrls as $url) {
                                      if (request()->is(ltrim($url, '/') . '*')) {
                                          $isActive = true;
                                          break;
                                      }
                                  }
                              }
                          @endphp

                          <li class="nav-item has-treeview {{ $isActive ? 'menu-open' : '' }}">
                              <a href="#" class="nav-link {{ $isActive ? 'active' : '' }}">
                                  <i class="nav-icon {{ $menu->icon }}"></i>
                                  <p>
                                      {{ $menu->name }}
                                      <i class="fas fa-angle-left right"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview">
                                  @foreach ($menu->children as $child)
                                      @php
                                          $childPermissions = $child->permission_name
                                              ? array_map('trim', explode(',', $child->permission_name))
                                              : [];
                                          $isChildActive = false;

                                          if ($child->route_name && request()->routeIs($child->route_name . '*')) {
                                              $isChildActive = true;
                                          } elseif ($child->url && request()->is(ltrim($child->url, '/') . '*')) {
                                              $isChildActive = true;
                                          }
                                      @endphp

                                      @canany($childPermissions)
                                          <li class="nav-item">
                                              <a href="{{ $child->route_name ? route($child->route_name) : url($child->url) }}"
                                                  class="nav-link {{ $isChildActive ? 'active' : '' }}">
                                                  <i class="{{ $child->icon }}"></i>
                                                  <p>{{ $child->name }}</p>
                                              </a>
                                          </li>
                                      @endcanany
                                  @endforeach
                              </ul>

                          </li>
                      @else
                          {{-- Menu tunggal --}}
                          <li class="nav-item">
                              <a href="{{ $menu->url ?? ($menu->route_name ? route($menu->route_name) : '#') }}"
                                  class="nav-link {{ ($menu->route_name && request()->routeIs($menu->route_name . '*')) ||
                                  (!$menu->route_name && $menu->url && request()->is(ltrim($menu->url, '/') . '*'))
                                      ? 'active'
                                      : '' }}">
                                  <i class="nav-icon {{ $menu->icon }}"></i>
                                  <p>
                                      {{ $menu->name }}
                                  </p>
                              </a>
                          </li>
                      @endif
                  @endforeach

              </ul>
          </nav>



      </div>
      <!-- /.sidebar -->
  </aside>
