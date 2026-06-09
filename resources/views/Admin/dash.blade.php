<x-layouts.modern>
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Stat Card 1: Aduan Layanan -->
    <div class="stat-card blue p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center"><i data-lucide="message-square" class="w-5 h-5 text-brand-700"></i></div>
      </div>
      <p class="text-3xl font-heading text-brand-800">{{ $totalAduanLayanan }}</p>
      <p class="text-xs text-gray-500 mt-1">Aduan Layanan</p>
    </div>

    <!-- Stat Card 2: Virtual Meeting -->
    <div class="stat-card green p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center"><i data-lucide="video" class="w-5 h-5 text-emerald-600"></i></div>
      </div>
      <p class="text-3xl font-heading text-emerald-700">{{ $totalVirtualMeeting }}</p>
      <p class="text-xs text-gray-500 mt-1">Virtual Meeting</p>
    </div>

    <!-- Stat Card 3: VPS -->
    <div class="stat-card yellow p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-yellow-50 flex items-center justify-center"><i data-lucide="database" class="w-5 h-5 text-yellow-600"></i></div>
      </div>
      <p class="text-3xl font-heading text-yellow-700">{{ $totalVps }}</p>
      <p class="text-xs text-gray-500 mt-1">Virtual Private Server</p>
    </div>

    <!-- Stat Card 4: BOD -->
    <div class="stat-card red p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center"><i data-lucide="wifi" class="w-5 h-5 text-red-500"></i></div>
      </div>
      <p class="text-3xl font-heading text-red-600">{{ $totalBandwidthOnDemand }}</p>
      <p class="text-xs text-gray-500 mt-1">Bandwidth on Demand</p>
    </div>

    <!-- Stat Card 5: Infrastruktur -->
    <div class="stat-card blue p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center"><i data-lucide="network" class="w-5 h-5 text-brand-700"></i></div>
      </div>
      <p class="text-3xl font-heading text-brand-800">{{ $totalInfrastrukturBaru }}</p>
      <p class="text-xs text-gray-500 mt-1">Infrastruktur Baru</p>
    </div>

    <!-- Stat Card 6: Reset Email -->
    <div class="stat-card green p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center"><i data-lucide="mail" class="w-5 h-5 text-emerald-600"></i></div>
      </div>
      <p class="text-3xl font-heading text-emerald-700">{{ $totalResetEmail }}</p>
      <p class="text-xs text-gray-500 mt-1">Reset Email</p>
    </div>

    <!-- Stat Card 7: Pentest -->
    <div class="stat-card yellow p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-yellow-50 flex items-center justify-center"><i data-lucide="shield" class="w-5 h-5 text-yellow-600"></i></div>
      </div>
      <p class="text-3xl font-heading text-yellow-700">{{ $totalPentest }}</p>
      <p class="text-xs text-gray-500 mt-1">Pen-Testing</p>
    </div>

    <!-- Stat Card 8: TTE -->
    <div class="stat-card red p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center"><i data-lucide="file-signature" class="w-5 h-5 text-red-500"></i></div>
      </div>
      <p class="text-3xl font-heading text-red-600">{{ $totalTte }}</p>
      <p class="text-xs text-gray-500 mt-1">Tanda Tangan Elektronik</p>
    </div>
  </div>

  <div class="chart-card p-5 mt-6">
    <div class="mb-4">
      <h3 class="font-heading text-sm text-brand-800">Aduan dan Permohonan Layanan Terbaru</h3>
    </div>
    <div class="tbl-wrap">
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Tiket</th>
            <th>Kategori</th>
            <th>Waktu</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($latestData as $index => $data)
          <tr>
            <td class="font-mono text-xs text-gray-500">{{ $index + 1 }}</td>
            <td class="font-mono text-xs text-brand-700 font-semibold">{{ $data['tiket'] }}</td>
            <td><span class="text-xs bg-brand-50 text-brand-700 px-2 py-0.5 rounded-full font-medium">{{ $data['kategori'] }}</span></td>
            <td class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($data['waktu'])->format('d M Y, H:i') }}</td>
          </tr>
          @endforeach
          @if(count($latestData) == 0)
          <tr>
              <td colspan="4" class="text-center py-4 text-gray-500">Belum ada data terbaru.</td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</x-layouts.modern>
