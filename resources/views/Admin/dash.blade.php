<x-layouts.modern>
  <!-- Welcome Section -->
  <div class="mb-2">
    <h2 class="text-xl font-heading font-bold text-slate-800">Ringkasan Layanan</h2>
    <p class="text-sm text-slate-500">Pantau statistik dan permohonan masuk hari ini.</p>
  </div>

  <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
    @foreach($stats as $stat)
    <div class="stat-card rounded-box shadow-soft p-4 border border-slate-200">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
            <i data-lucide="{{ $stat['icon'] ?? 'folder' }}" class="w-4 h-4 text-blue-600"></i>
        </div>
        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide leading-tight">{{ $stat['nama'] }}</p>
      </div>
      <p class="text-2xl font-heading font-bold text-slate-800">{{ $stat['total'] }}</p>
    </div>
    @endforeach
  </div>

  <div class="bg-white rounded-box shadow-soft border border-slate-200 p-4 mb-6" id="filter-card">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
      <div class="flex items-center gap-2 w-full md:w-auto">
        <div class="relative w-full md:w-64">
          <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
          <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Cari tiket..." class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
        </div>
      </div>
      <div class="flex items-center gap-2 w-full md:w-auto">
        <select id="statusFilter" class="w-full md:w-48 px-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
          <option value="">Semua Status</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Open</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Selesai</option>
        </select>
      </div>
    </div>
  </div>

  <div id="table-container" class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
      <h3 class="font-heading font-bold text-sm text-slate-800">Semua Aduan & Permohonan</h3>
    </div>
    <div class="p-5 overflow-x-auto">
      <table class="w-full text-left border-collapse data-table">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">No</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tiket</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kategori</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Waktu</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($latestData as $index => $data)
          <tr>
            <td class="font-medium whitespace-nowrap text-xs">{{ $latestData->firstItem() + $index }}</td>
            <td class="font-mono text-xs text-brand-700 font-semibold">{{ $data['tiket'] }}</td>
            <td>
              <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-600 border border-slate-200">
                {{ $data['kategori'] }}
              </span>
            </td>
            <td>
              @if($data['status'] == '1')
                <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-emerald-100 text-emerald-700 uppercase tracking-wide">Selesai</span>
              @else
                <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-orange-100 text-orange-700 uppercase tracking-wide">Open</span>
              @endif
            </td>
            <td class="text-xs text-slate-500">
              <div class="flex items-center gap-1.5">
                <i data-lucide="clock" class="w-3 h-3 text-slate-400"></i>
                {{ \Carbon\Carbon::parse($data['waktu'])->format('d M Y, H:i') }}
              </div>
            </td>
          </tr>
          @endforeach
          @if(count($latestData) == 0)
          <tr>
              <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data ditemukan.</td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100 flex justify-end">
      {{ $latestData->appends(request()->query())->links() }}
    </div>
  </div>
</x-layouts.modern>
