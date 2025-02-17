 <!--begin::Sidebar-->
 <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
      <!--begin::Brand Link-->
      <a href="{{ url('/') }}" class="brand-link">
        <!--begin::Brand Image-->
        {{-- <img src="{{ asset('assets/writer/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" /> --}}
        <!--end::Brand Image-->
        <!--begin::Brand Text-->
        <span class="brand-text fw-light">WartaBalarea</span>
        <!--end::Brand Text-->
      </a>
      <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon bi bi-speedometer"></i>
              <p>
                Dashboard
                {{-- <i class="nav-arrow bi bi-chevron-right"></i> --}}
              </p>
            </a>
          </li>
          <li class="nav-header">Data Master</li>
          <li class="nav-item">
            <a href="./docs/introduction.html" class="nav-link">
              <i class="nav-icon bi bi-download"></i>
              <p>Tulis Informasi</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./docs/layout.html" class="nav-link">
              <i class="nav-icon bi bi-grip-horizontal"></i>
              <p>Edit informasi</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./docs/color-mode.html" class="nav-link">
              <i class="nav-icon bi bi-star-half"></i>
              <p>Hapus Informasi</p>
            </a>
          </li>
        </ul>
        <!--end::Sidebar Menu-->
      </nav>
    </div>
    <!--end::Sidebar Wrapper-->
  </aside>
  <!--end::Sidebar-->
