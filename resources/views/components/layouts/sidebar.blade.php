<aside id="sidebar" class="fixed top-0 left-0 h-full w-[260px] bg-white border-r border-slate-200 z-40 flex flex-col transition-transform duration-300">
  <div class="h-16 border-b border-slate-200 flex items-center justify-between px-5 bg-white">
    <div class="flex items-center gap-3">
      <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-sm">
        <i data-lucide="message-square" class="w-4 h-4 text-white"></i>
      </div>
      <div>
        <p class="font-heading font-bold text-slate-800 text-[13px] leading-tight tracking-wide">Hotline App</p>
        <p class="text-slate-500 text-[10px] font-medium uppercase tracking-wider">Diskominfo</p>
      </div>
    </div>
    <button onclick="closeSidebar()" class="lg:hidden text-slate-400 hover:text-slate-600 p-1 rounded-md hover:bg-slate-100"><i data-lucide="x" class="w-5 h-5"></i></button>
  </div>

  <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
    <p class="px-3 text-slate-400 text-[10px] font-bold uppercase tracking-[0.1em] mb-2 mt-2">Menu Utama</p>
    <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard.admin') ? 'text-blue-700 bg-blue-50 shadow-sm ring-1 ring-blue-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
      <i data-lucide="layout-dashboard" class="w-4 h-4 {{ request()->routeIs('dashboard.admin') ? 'text-blue-600' : 'text-slate-400' }}"></i> Dashboard
    </a>
    @php
        $menus = \App\Models\Layanan::orderBy('kode', 'asc')->get();
    @endphp

    @foreach($menus as $menu)
        @php
            $isActive = request()->is('layanan/' . $menu->kode) || request()->is('admin/layanan/' . $menu->kode);
        @endphp
        <a href="{{ route('index.layanan.admin', $menu->kode) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ $isActive ? 'text-blue-700 bg-blue-50 shadow-sm ring-1 ring-blue-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
          <i data-lucide="{{ $menu->icon ?? 'folder' }}" class="w-4 h-4 {{ $isActive ? 'text-blue-600' : 'text-slate-400' }}"></i> {{ $menu->nama }}
        </a>
    @endforeach

    <div class="pt-4 mt-2 border-t border-slate-100">
        <p class="px-3 text-slate-400 text-[10px] font-bold uppercase tracking-[0.1em] mb-2">Laporan & Pengaturan</p>
        <a href="{{ route('index.rekap') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('index.rekap') ? 'text-blue-700 bg-blue-50 shadow-sm ring-1 ring-blue-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
          <i data-lucide="bar-chart-2" class="w-4 h-4 {{ request()->routeIs('index.rekap') ? 'text-blue-600' : 'text-slate-400' }}"></i> Laporan Rekap
        </a>
        <a href="{{ route('index.manajemen.layanan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('index.manajemen.layanan') ? 'text-blue-700 bg-blue-50 shadow-sm ring-1 ring-blue-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
          <i data-lucide="blocks" class="w-4 h-4 {{ request()->routeIs('index.manajemen.layanan') ? 'text-blue-600' : 'text-slate-400' }}"></i> Manajemen Layanan
        </a>
        <a href="{{ route('index.pengguna') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('index.pengguna') ? 'text-blue-700 bg-blue-50 shadow-sm ring-1 ring-blue-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
          <i data-lucide="users" class="w-4 h-4 {{ request()->routeIs('index.pengguna') ? 'text-blue-600' : 'text-slate-400' }}"></i> Pengguna Aplikasi
        </a>
        <a href="{{ route('index.bot-settings.admin') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('index.bot-settings.admin') ? 'text-blue-700 bg-blue-50 shadow-sm ring-1 ring-blue-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
          <i data-lucide="bot" class="w-4 h-4 {{ request()->routeIs('index.bot-settings.admin') ? 'text-blue-600' : 'text-slate-400' }}"></i> Pengaturan Bot
        </a>
    </div>
  </nav>

  <div class="p-4 border-t border-slate-200 bg-slate-50/50">
    <div class="flex items-center gap-3 mb-3">
      <div class="w-9 h-9 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center text-slate-600 font-heading text-sm font-bold shadow-sm">
        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-slate-800 text-xs font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
        <p class="text-slate-500 text-[10px] truncate">{{ auth()->user()->email ?? 'admin@mail.com' }}</p>
      </div>
    </div>
    <form action="{{ route('aksi.logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 rounded-lg text-xs font-semibold transition-all shadow-sm">
          <i data-lucide="log-out" class="w-3.5 h-3.5 text-slate-500"></i> Keluar
        </button>
    </form>
  </div>
</aside>
