<aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-brand-800 z-40 flex flex-col shadow-2xl">
  <div class="px-5 py-5 border-b border-brand-700 flex items-center gap-3">
    <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">
      <i data-lucide="message-square" class="text-white"></i>
    </div>
    <div>
      <p class="text-white font-heading text-sm leading-tight">Bot Aduan WA</p>
      <p class="text-brand-300 text-xs">Diskominfo Subang</p>
    </div>
    <button onclick="closeSidebar()" class="ml-auto text-brand-300 hover:text-white lg:hidden"><i data-lucide="x" class="w-5 h-5"></i></button>
  </div>

  <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
    <p class="px-3 text-brand-400 text-xs font-semibold uppercase tracking-widest mb-2">Menu Utama</p>
    <a href="{{ route('dashboard.admin') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard.admin') ? 'text-white bg-brand-600/60' : 'text-brand-300 hover:text-white hover:bg-brand-700/50 transition-colors' }}">
      <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
    </a>
    <a href="{{ route('index.aduan.admin') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('index.aduan.admin') ? 'text-white bg-brand-600/60' : 'text-brand-300 hover:text-white hover:bg-brand-700/50 transition-colors' }}">
      <i data-lucide="message-circle" class="w-4 h-4"></i> Aduan Layanan
    </a>
    <a href="{{ route('index.vm.admin') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('index.vm.admin') ? 'text-white bg-brand-600/60' : 'text-brand-300 hover:text-white hover:bg-brand-700/50 transition-colors' }}">
      <i data-lucide="video" class="w-4 h-4"></i> Virtual Meeting
    </a>
    <a href="{{ route('index.vps.admin') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('index.vps.admin') ? 'text-white bg-brand-600/60' : 'text-brand-300 hover:text-white hover:bg-brand-700/50 transition-colors' }}">
      <i data-lucide="database" class="w-4 h-4"></i> VPS
    </a>
    <a href="{{ route('index.bod.admin') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('index.bod.admin') ? 'text-white bg-brand-600/60' : 'text-brand-300 hover:text-white hover:bg-brand-700/50 transition-colors' }}">
      <i data-lucide="wifi" class="w-4 h-4"></i> Bandwidth on Demand
    </a>
    <a href="{{ route('index.infrastruktur.admin') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('index.infrastruktur.admin') ? 'text-white bg-brand-600/60' : 'text-brand-300 hover:text-white hover:bg-brand-700/50 transition-colors' }}">
      <i data-lucide="network" class="w-4 h-4"></i> Infrastruktur Baru
    </a>
    <a href="{{ route('index.resetemail.admin') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('index.resetemail.admin') ? 'text-white bg-brand-600/60' : 'text-brand-300 hover:text-white hover:bg-brand-700/50 transition-colors' }}">
      <i data-lucide="mail" class="w-4 h-4"></i> Layanan E-Mail
    </a>
    <a href="{{ route('index.pentest.admin') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('index.pentest.admin') ? 'text-white bg-brand-600/60' : 'text-brand-300 hover:text-white hover:bg-brand-700/50 transition-colors' }}">
      <i data-lucide="shield" class="w-4 h-4"></i> Pen-Testing
    </a>
    <a href="{{ route('index.tte.admin') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('index.tte.admin') ? 'text-white bg-brand-600/60' : 'text-brand-300 hover:text-white hover:bg-brand-700/50 transition-colors' }}">
      <i data-lucide="file-signature" class="w-4 h-4"></i> TTE
    </a>

    <div class="pt-4">
        <p class="px-3 text-brand-400 text-xs font-semibold uppercase tracking-widest mb-2">Laporan & Pengguna</p>
        <a href="{{ route('index.rekap') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('index.rekap') ? 'text-white bg-brand-600/60' : 'text-brand-300 hover:text-white hover:bg-brand-700/50 transition-colors' }}">
        <i data-lucide="bar-chart-2" class="w-4 h-4"></i> Laporan Rekap
        </a>
        <a href="{{ route('index.pengguna') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('index.pengguna') ? 'text-white bg-brand-600/60' : 'text-brand-300 hover:text-white hover:bg-brand-700/50 transition-colors' }}">
        <i data-lucide="users" class="w-4 h-4"></i> Pengguna Aplikasi
        </a>
    </div>
  </nav>

  <div class="px-4 py-4 border-t border-brand-700 flex items-center gap-3">
    <div class="w-8 h-8 rounded-full bg-accent-500 flex items-center justify-center text-white font-heading text-sm">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
    <div class="flex-1 min-w-0">
      <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
      <p class="text-brand-400 text-xs truncate">{{ auth()->user()->email ?? 'admin@mail.com' }}</p>
    </div>
    <form action="{{ route('aksi.logout') }}" method="POST">
        @csrf
        <button type="submit" class="text-brand-400 hover:text-white" title="Logout">
          <i data-lucide="log-out" class="w-4 h-4"></i>
        </button>
    </form>
  </div>
</aside>
