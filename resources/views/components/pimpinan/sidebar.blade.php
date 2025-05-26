 <!--begin::Sidebar-->
 <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
     <!--begin::Sidebar Brand-->
     <div class="sidebar-brand">
         <!--begin::Brand Link-->
         <a href="/pimpinan" class="brand-link">
             <!--begin::Brand Image-->
             <img src="{{ asset('dist/assets/img/Foto Profil Hotline.png') }}" alt="Logo Hotline Diskominfo Subang"
                 class="brand-image opacity-100 shadow rounded-circle" />
             <!--end::Brand Image-->
             <!--begin::Brand Text-->
             <span class="brand-text fw-light">Layanan Hotline</span>
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
                     <a href="/pimpinan" class="nav-link {{ Request::is('pimpinan') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-speedometer"></i>
                         <p>Dashboard</p>
                     </a>
                 </li>
             </ul>
             <!--end::Sidebar Menu-->
         </nav>
     </div>
     <!--end::Sidebar Wrapper-->
 </aside>
 <!--end::Sidebar-->
