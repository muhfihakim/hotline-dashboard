<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard — Diskominfo Subang</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/lucide@0.383.0/dist/umd/lucide.js"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { heading: ['Poppins', 'sans-serif'], body: ['Inter', 'sans-serif'] },
          colors: {
            brand: { 50:'#EEF4FC', 100:'#D6E5F7', 200:'#AECBEF', 300:'#7DAEE5', 400:'#4D90DA', 500:'#2272CE', 600:'#1A5AA8', 700:'#1A4F8A', 800:'#153F70', 900:'#0F2D52' },
            accent: { 400:'#34D399', 500:'#10B981', 600:'#059669' },
            warn: { 500:'#F59E0B' }, danger: { 500:'#EF4444' },
          },
        }
      }
    };
  </script>
  <style>
    * { box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; }
    h1, h2, h3, .font-heading { font-family: 'Poppins', sans-serif; }
    .page-bg { background: linear-gradient(145deg, #EEF4FC 0%, #F0FBF6 40%, #FAFFFE 100%); min-height: 100vh; }
    .header-banner { background: linear-gradient(135deg, #1A4F8A 0%, #1A5AA8 45%, #0F9068 100%); }
    .stat-card { background: #fff; border-radius: 14px; border-top: 4px solid transparent; box-shadow: 0 2px 14px rgba(26,79,138,0.08); transition: transform .18s, box-shadow .18s; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(26,79,138,0.13); }
    .stat-card.blue { border-top-color: #1A4F8A; } .stat-card.green { border-top-color: #059669; } .stat-card.yellow { border-top-color: #F59E0B; } .stat-card.red { border-top-color: #EF4444; }
    .chart-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 14px rgba(26,79,138,0.08); }
    .tbl-wrap { border-radius: 14px; overflow: hidden; box-shadow: 0 2px 14px rgba(26,79,138,0.08); }
    table { border-collapse: collapse; width: 100%; }
    thead th { background: linear-gradient(90deg, #1A4F8A, #1A5AA8); color: #fff; font-size: .8rem; letter-spacing: .05em; text-transform: uppercase; padding: 12px 16px; text-align: left; font-family: 'Poppins', sans-serif; white-space: nowrap; }
    tbody tr { border-bottom: 1px solid #EEF4FC; background: #fff; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #F5F9FF; }
    tbody td { padding: 11px 16px; font-size: .875rem; color: #374151; vertical-align: middle; }
    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 999px; font-size: .72rem; font-weight: 600; letter-spacing: .03em; }
    .badge-masuk { background: #DBEAFE; color: #1D4ED8; }
    .badge-proses { background: #FEF3C7; color: #B45309; }
    .badge-selesai { background: #D1FAE5; color: #065F46; }
    .badge-ditolak { background: #FEE2E2; color: #B91C1C; }
    #sidebar { transition: transform .28s cubic-bezier(.4,0,.2,1); }
    #sidebar-overlay { transition: opacity .28s; }
    #toast-container { position: fixed; bottom: 24px; right: 24px; display: flex; flex-direction: column; gap: 10px; z-index: 9999; pointer-events: none; }
    .toast { display: flex; align-items: flex-start; gap: 10px; padding: 13px 16px; border-radius: 12px; box-shadow: 0 6px 24px rgba(0,0,0,.15); background: #fff; min-width: 260px; max-width: 340px; pointer-events: all; animation: slideIn .3s ease forwards; border-left: 4px solid #1A4F8A; }
    .toast.success { border-left-color: #059669; } .toast.warning { border-left-color: #F59E0B; } .toast.error { border-left-color: #EF4444; }
    @keyframes slideIn { from { transform: translateX(110%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(110%); opacity: 0; } }
    .toast.hide { animation: slideOut .3s ease forwards; }
    #modal-backdrop { transition: opacity .2s; }
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #F1F5F9; }
    ::-webkit-scrollbar-thumb { background: #AECBEF; border-radius: 6px; }
    @media (max-width: 1023px) { #sidebar { transform: translateX(-100%); } #sidebar.open { transform: translateX(0); } }
  </style>
  @yield('Css')
</head>
<body class="page-bg font-body">

<div id="sidebar-overlay" class="fixed inset-0 bg-black/30 z-30 hidden opacity-0 lg:hidden" onclick="closeSidebar()"></div>

<x-layouts.sidebar />

<div class="lg:pl-64 min-h-screen flex flex-col">
  <header class="header-banner text-white px-5 py-0">
    <div class="flex items-center gap-3 py-4">
      <button onclick="openSidebar()" class="lg:hidden p-2 rounded-lg bg-white/15 hover:bg-white/25 transition-colors mr-1">
        <i data-lucide="menu" class="w-5 h-5"></i>
      </button>
      <div class="flex items-center gap-3 flex-1">
        <div class="hidden sm:flex flex-col">
          <span class="font-heading text-lg leading-tight">Dashboard Bot Aduan WhatsApp</span>
          <span class="text-blue-200 text-xs">Dinas Komunikasi dan Informatika — Kabupaten Subang</span>
        </div>
      </div>
      <div class="flex items-center gap-3 ml-auto">
        <span id="live-date" class="hidden md:block text-xs text-blue-200"></span>
      </div>
    </div>
  </header>

  <main class="flex-1 px-4 md:px-6 py-6 space-y-6">
    {{ $slot }}

    <footer class="text-center text-xs text-gray-400 pb-4 mt-8">
      © 2025 Dinas Komunikasi dan Informatika Kabupaten Subang
    </footer>
  </main>
</div>

<div id="toast-container"></div>

<script>
  lucide.createIcons();
  function openSidebar() { document.getElementById('sidebar').classList.add('open'); const o = document.getElementById('sidebar-overlay'); o.classList.remove('hidden'); setTimeout(() => o.style.opacity = '1', 10); }
  function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); const o = document.getElementById('sidebar-overlay'); o.style.opacity = '0'; setTimeout(() => o.classList.add('hidden'), 280); }
  function updateDate() { const el = document.getElementById('live-date'); if(el) el.textContent = new Date().toLocaleDateString('id-ID', { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' }); }
  updateDate(); setInterval(updateDate, 60000);
  function showToast(msg, type = 'info') {
      const container = document.getElementById('toast-container');
      if(!container) return;
      const icons = { info: 'info', success: 'check-circle', warning: 'alert-triangle', error: 'x-circle' };
      const colors = { info: 'text-brand-600', success: 'text-emerald-600', warning: 'text-yellow-600', error: 'text-red-500' };
      const el = document.createElement('div');
      el.className = `toast ${type}`;
      el.innerHTML = `<i data-lucide="${icons[type]}" class="w-5 h-5 mt-0.5 flex-shrink-0 ${colors[type]}"></i><div class="flex-1 min-w-0"><p class="text-sm font-medium text-gray-800 leading-snug">${msg}</p></div><button onclick="dismissToast(this.parentElement)" class="text-gray-300 hover:text-gray-500 flex-shrink-0 ml-1"><i data-lucide="x" class="w-4 h-4"></i></button>`;
      container.appendChild(el); lucide.createIcons(); setTimeout(() => dismissToast(el), 4500);
  }
  function dismissToast(el) { if (!el || el.classList.contains('hide')) return; el.classList.add('hide'); setTimeout(() => el.remove(), 320); }
</script>
@yield('Scripts')
</body>
</html>
