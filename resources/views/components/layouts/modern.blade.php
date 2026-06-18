<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard — Diskominfo Subang</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/lucide@0.383.0/dist/umd/lucide.js"></script>
  <style>
    * { box-sizing: border-box; }
    body { background-color: #F8FAFC; color: #334155; }
    
    .rounded-box { border-radius: 1.25rem; }
    .shadow-soft { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid #E2E8F0; }
    
    .stat-card { background: #FFFFFF; transition: all 0.2s; position: relative; overflow: hidden; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02); border-color: #cbd5e1; }
    
    /* Density adjustments */
    .dense-p { padding: 1rem; }
    .dense-gap { gap: 0.75rem; }
    
    table { width: 100%; border-collapse: separate; border-spacing: 0; }
    thead th { background-color: #F1F5F9; color: #475569; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; padding: 0.75rem 1rem; text-align: left; border-bottom: 1px solid #E2E8F0; }
    thead th:first-child { border-top-left-radius: 1rem; }
    thead th:last-child { border-top-right-radius: 1rem; }
    tbody tr { background: #FFFFFF; transition: background-color 0.15s; }
    tbody tr:hover { background: #F8FAFC; }
    tbody td { padding: 0.75rem 1rem; font-size: 0.875rem; color: #334155; border-bottom: 1px solid #E2E8F0; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    
    #sidebar { transition: transform .25s ease-in-out; }
    #sidebar-overlay { transition: opacity .25s; }
    
    #toast-container { position: fixed; bottom: 1.5rem; right: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem; z-index: 9999; pointer-events: none; }
    .toast { display: flex; align-items: flex-start; gap: 0.75rem; padding: 1rem; border-radius: 1rem; background: #FFFFFF; border: 1px solid #E2E8F0; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); min-width: 250px; pointer-events: all; animation: slideIn .3s ease forwards; }
    @keyframes slideIn { from { transform: translateY(100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    @keyframes slideOut { from { transform: translateY(0); opacity: 1; } to { transform: translateY(100%); opacity: 0; } }
    .toast.hide { animation: slideOut .3s ease forwards; }
    
    ::-webkit-scrollbar { width: 4px; height: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    @media (max-width: 1023px) { #sidebar { transform: translateX(-100%); } #sidebar.open { transform: translateX(0); } }
  </style>
  @yield('Css')
</head>
<body class="font-body antialiased selection:bg-blue-100 selection:text-blue-900 flex min-h-screen">

<div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 z-30 hidden opacity-0 lg:hidden backdrop-blur-sm transition-opacity" onclick="closeSidebar()"></div>

<x-layouts.sidebar />

<div class="lg:pl-[260px] w-full flex flex-col min-h-screen bg-slate-50 transition-all duration-300">
  <header class="bg-white border-b border-slate-200 sticky top-0 z-20 shadow-sm">
    <div class="flex items-center justify-between px-4 sm:px-6 h-16">
      <div class="flex items-center gap-4">
        <button onclick="openSidebar()" class="lg:hidden p-2 -ml-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-colors">
          <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <div class="hidden sm:flex flex-col">
          <h1 class="font-heading font-bold text-slate-800 text-lg tracking-tight">Dashboard Bot Aduan</h1>
          <p class="text-slate-500 text-[11px] font-medium uppercase tracking-wider">Diskominfo Subang</p>
        </div>
      </div>
      <div class="flex items-center gap-4">
        <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-slate-100 rounded-full border border-slate-200">
          <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-500"></i>
          <span id="live-date" class="text-xs font-medium text-slate-600"></span>
        </div>
        <!-- Profile simple dropdown or avatar -->
        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-heading text-xs font-bold shadow-sm cursor-pointer border-2 border-white ring-1 ring-slate-200">
          {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
        </div>
      </div>
    </div>
  </header>

  <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6">
    {{ $slot }}
  </main>
</div>

<div id="toast-container"></div>

<script>
  lucide.createIcons();
  function openSidebar() { document.getElementById('sidebar').classList.add('open'); const o = document.getElementById('sidebar-overlay'); o.classList.remove('hidden'); setTimeout(() => o.style.opacity = '1', 10); }
  function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); const o = document.getElementById('sidebar-overlay'); o.style.opacity = '0'; setTimeout(() => o.classList.add('hidden'), 250); }
  function updateDate() { const el = document.getElementById('live-date'); if(el) el.textContent = new Date().toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' }); }
  updateDate(); setInterval(updateDate, 60000);
  function showToast(msg, type = 'info') {
      const container = document.getElementById('toast-container');
      if(!container) return;
      const icons = { info: 'info', success: 'check-circle', warning: 'alert-triangle', error: 'x-circle' };
      const colors = { info: 'text-blue-500', success: 'text-teal-500', warning: 'text-orange-500', error: 'text-rose-500' };
      const bg = { info: 'bg-blue-50', success: 'bg-teal-50', warning: 'bg-orange-50', error: 'bg-rose-50' };
      const el = document.createElement('div');
      el.className = `toast`;
      el.innerHTML = `<div class="p-2 rounded-lg ${bg[type]} ${colors[type]}"><i data-lucide="${icons[type]}" class="w-4 h-4"></i></div><div class="flex-1 min-w-0 py-1"><p class="text-sm font-semibold text-slate-700">${msg}</p></div><button onclick="dismissToast(this.parentElement)" class="text-slate-400 hover:text-slate-600 p-1"><i data-lucide="x" class="w-4 h-4"></i></button>`;
      container.appendChild(el); lucide.createIcons(); setTimeout(() => dismissToast(el), 4500);
  }
  function dismissToast(el) { if (!el || el.classList.contains('hide')) return; el.classList.add('hide'); setTimeout(() => el.remove(), 300); }

  // Global AJAX Search & Pagination
  document.addEventListener('DOMContentLoaded', function() {
      let debounceTimer;
      const searchInput = document.getElementById('searchInput');
      const statusFilter = document.getElementById('statusFilter');

      function fetchFilteredData(pageUrl = null) {
          const currentSearchInput = document.getElementById('searchInput');
          const currentStatusFilter = document.getElementById('statusFilter');
          const search = currentSearchInput ? currentSearchInput.value : '';
          const status = currentStatusFilter ? currentStatusFilter.value : '';
          
          let url = new URL(pageUrl || window.location.href);
          if(search) url.searchParams.set('search', search);
          else url.searchParams.delete('search');
          
          if(status !== '') url.searchParams.set('status', status);
          else url.searchParams.delete('status');

          const mainContent = document.querySelector('main');
          if(mainContent) mainContent.style.opacity = '0.5';

          fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
              .then(res => res.text())
              .then(html => {
                  const doc = new DOMParser().parseFromString(html, 'text/html');
                  const newMain = doc.querySelector('main');
                  if(newMain && mainContent) {
                      mainContent.innerHTML = newMain.innerHTML;
                      
                      // Re-evaluate scripts in main to update any modal JSON data
                      const scripts = newMain.querySelectorAll('script');
                      scripts.forEach(s => {
                          const newScript = document.createElement('script');
                          newScript.textContent = s.textContent;
                          document.body.appendChild(newScript);
                          setTimeout(() => newScript.remove(), 100);
                      });
                  }
                  if(mainContent) mainContent.style.opacity = '1';
                  if(typeof lucide !== 'undefined') lucide.createIcons();
                  
                  // Re-attach listeners to the newly rendered DOM
                  const newSearchInput = document.getElementById('searchInput');
                  const newStatusFilter = document.getElementById('statusFilter');
                  
                  if(newSearchInput) {
                      newSearchInput.focus();
                      // Move cursor to end
                      const val = newSearchInput.value;
                      newSearchInput.value = '';
                      newSearchInput.value = val;
                      
                      newSearchInput.addEventListener('input', () => {
                          clearTimeout(debounceTimer);
                          debounceTimer = setTimeout(() => fetchFilteredData(), 500);
                      });
                  }
                  if(newStatusFilter) {
                      newStatusFilter.addEventListener('change', () => fetchFilteredData());
                  }
                  
                  window.history.pushState({}, '', url);
              });
      }

      if(searchInput) {
          searchInput.addEventListener('input', () => {
              clearTimeout(debounceTimer);
              debounceTimer = setTimeout(() => fetchFilteredData(), 500);
          });
      }

      if(statusFilter) {
          statusFilter.addEventListener('change', () => fetchFilteredData());
      }
      
      // Delegation for pagination links
      document.addEventListener('click', function(e) {
          const link = e.target.closest('nav[role="navigation"] a');
          if(link) {
              e.preventDefault();
              fetchFilteredData(link.href);
          }
      });
  });
</script>
@yield('Scripts')
</body>
</html>
