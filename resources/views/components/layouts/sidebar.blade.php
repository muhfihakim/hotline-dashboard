 <!--begin::Sidebar-->
 <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
     <!--begin::Sidebar Brand-->
     <div class="sidebar-brand">
         <!--begin::Brand Link-->
         <a href="/" class="brand-link">
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
                     <a href="/" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-speedometer"></i>
                         <p>Dashboard</p>
                     </a>
                 </li>
                 <li class="nav-header">LAYANAN</li>
                 <li class="nav-item">
                     <a href="{{ route('index.aduan.admin') }}"
                         class="nav-link {{ Request::is('aduan-layanan') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-exclamation-square"></i>
                         <p>Aduan Layanan</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('index.vm.admin') }}"
                         class="nav-link {{ Request::is('virtual-meeting') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-person-video3"></i>
                         <p>Virtual Meeting</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('index.vps.admin') }}"
                         class="nav-link {{ Request::is('virtual-private-server') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-hdd-stack"></i>
                         <p>Virtual Private Server</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('index.bod.admin') }}"
                         class="nav-link {{ Request::is('bandwidth-on-demand') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-router"></i>
                         <p>Bandwidth on Demand</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('index.infrastruktur.admin') }}"
                         class="nav-link {{ Request::is('infrastruktur-baru') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-ethernet"></i>
                         <p>Infrastruktur Baru</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('index.resetemail.admin') }}"
                         class="nav-link {{ Request::is('reset-email') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-envelope-at"></i>
                         <p>Layanan E-Mail</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('index.pentest.admin') }}"
                         class="nav-link {{ Request::is('pentesting') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-shield-check"></i>
                         <p>Pen-Testing</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('index.tte.admin') }}"
                         class="nav-link {{ Request::is('tanda-tangan-elektronik') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-file-earmark-check"></i>
                         <p>TTE</p>
                     </a>
                 </li>
                 <li class="nav-header">LAPORAN</li>
                 <li class="nav-item">
                     <a href="{{ route('index.rekap') }}"
                         class="nav-link {{ Request::is('laporan-rekap') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-file-earmark-bar-graph"></i>
                         <p>Rekap</p>
                     </a>
                 </li>
                 <li class="nav-header">PENGGUNA</li>
                 <li class="nav-item">
                     <a href="{{ route('index.pengguna') }}"
                         class="nav-link {{ Request::is('laporan-rekap') ? 'active' : '' }}">
                         <i class="nav-icon bi bi-person-circle"></i>
                         <p>Aplikasi</p>
                     </a>
                 </li>
             </ul>
             <!--end::Sidebar Menu-->
         </nav>
     </div>
     <!--end::Sidebar Wrapper-->
 </aside>
 <!--end::Sidebar-->
