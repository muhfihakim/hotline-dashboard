<x-layouts.modern>
  <!-- Welcome Section -->
  <div class="mb-2">
    <h2 class="text-xl font-heading font-bold text-slate-800">Ringkasan Layanan</h2>
    <p class="text-sm text-slate-500">Pantau statistik dan permohonan masuk hari ini.</p>
  </div>

  <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
    <!-- Stat Card 1 -->
    <div class="stat-card rounded-box shadow-soft p-4 border border-slate-200">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0"><i data-lucide="message-square" class="w-4 h-4 text-blue-600"></i></div>
        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide leading-tight">Aduan Layanan</p>
      </div>
      <p class="text-2xl font-heading font-bold text-slate-800">{{ $totalAduanLayanan }}</p>
    </div>

    <!-- Stat Card 2 -->
    <div class="stat-card rounded-box shadow-soft p-4 border border-slate-200">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center shrink-0"><i data-lucide="video" class="w-4 h-4 text-indigo-600"></i></div>
        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide leading-tight">Virtual Meeting</p>
      </div>
      <p class="text-2xl font-heading font-bold text-slate-800">{{ $totalVirtualMeeting }}</p>
    </div>

    <!-- Stat Card 3 -->
    <div class="stat-card rounded-box shadow-soft p-4 border border-slate-200">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 rounded-lg bg-cyan-50 border border-cyan-100 flex items-center justify-center shrink-0"><i data-lucide="database" class="w-4 h-4 text-cyan-600"></i></div>
        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide leading-tight">VPS</p>
      </div>
      <p class="text-2xl font-heading font-bold text-slate-800">{{ $totalVps }}</p>
    </div>

    <!-- Stat Card 4 -->
    <div class="stat-card rounded-box shadow-soft p-4 border border-slate-200">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 rounded-lg bg-sky-50 border border-sky-100 flex items-center justify-center shrink-0"><i data-lucide="wifi" class="w-4 h-4 text-sky-600"></i></div>
        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide leading-tight">Bandwidth on Demand</p>
      </div>
      <p class="text-2xl font-heading font-bold text-slate-800">{{ $totalBandwidthOnDemand }}</p>
    </div>

    <!-- Stat Card 5 -->
    <div class="stat-card rounded-box shadow-soft p-4 border border-slate-200">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 rounded-lg bg-teal-50 border border-teal-100 flex items-center justify-center shrink-0"><i data-lucide="network" class="w-4 h-4 text-teal-600"></i></div>
        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide leading-tight">Infrastruktur Baru</p>
      </div>
      <p class="text-2xl font-heading font-bold text-slate-800">{{ $totalInfrastrukturBaru }}</p>
    </div>

    <!-- Stat Card 6 -->
    <div class="stat-card rounded-box shadow-soft p-4 border border-slate-200">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0"><i data-lucide="mail" class="w-4 h-4 text-blue-600"></i></div>
        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide leading-tight">Reset Email</p>
      </div>
      <p class="text-2xl font-heading font-bold text-slate-800">{{ $totalResetEmail }}</p>
    </div>

    <!-- Stat Card 7 -->
    <div class="stat-card rounded-box shadow-soft p-4 border border-slate-200">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0"><i data-lucide="shield" class="w-4 h-4 text-slate-600"></i></div>
        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide leading-tight">Pen-Testing</p>
      </div>
      <p class="text-2xl font-heading font-bold text-slate-800">{{ $totalPentest }}</p>
    </div>

    <!-- Stat Card 8 -->
    <div class="stat-card rounded-box shadow-soft p-4 border border-slate-200">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 rounded-lg bg-violet-50 border border-violet-100 flex items-center justify-center shrink-0"><i data-lucide="file-signature" class="w-4 h-4 text-violet-600"></i></div>
        <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide leading-tight">TTE</p>
      </div>
      <p class="text-2xl font-heading font-bold text-slate-800">{{ $totalTte }}</p>
    </div>
  </div>

  <div class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
      <h3 class="font-heading font-bold text-sm text-slate-800">Aduan & Permohonan Terbaru</h3>
      <button class="text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">Lihat Semua</button>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">No</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tiket</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kategori</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Waktu</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @foreach ($latestData as $index => $data)
          <tr class="hover:bg-slate-50/50 transition-colors group">
            <td class="px-5 py-3 text-xs text-slate-500 font-medium w-12">{{ $index + 1 }}</td>
            <td class="px-5 py-3 text-xs font-bold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $data['tiket'] }}</td>
            <td class="px-5 py-3">
              <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-600 border border-slate-200">
                {{ $data['kategori'] }}
              </span>
            </td>
            <td class="px-5 py-3 text-xs text-slate-500">
              <div class="flex items-center gap-1.5">
                <i data-lucide="clock" class="w-3 h-3 text-slate-400"></i>
                {{ \Carbon\Carbon::parse($data['waktu'])->format('d M Y, H:i') }}
              </div>
            </td>
          </tr>
          @endforeach
          @if(count($latestData) == 0)
          <tr>
              <td colspan="4" class="px-5 py-8 text-center text-sm text-slate-400 font-medium">Belum ada data terbaru.</td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</x-layouts.modern>
