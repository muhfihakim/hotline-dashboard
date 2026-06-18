<x-layouts.modern>
  <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-heading font-bold text-slate-800">{{ $serviceInfo['name'] }}</h2>
      <p class="text-sm text-slate-500">Daftar permohonan / tiket untuk layanan {{ $serviceInfo['name'] }}.</p>
    </div>
    <div class="flex items-center gap-2 text-sm text-slate-500">
      <span>Home</span> <i data-lucide="chevron-right" class="w-3 h-3"></i> <span class="font-semibold text-slate-700">{{ $serviceInfo['name'] }}</span>
    </div>
  </div>

  <div class="bg-white rounded-box shadow-soft border border-slate-200 p-4 mb-6" id="filter-card">
    <form action="" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
      <div class="flex items-center gap-2 w-full md:w-auto">
        <div class="relative w-full md:w-64">
          <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
          <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Cari tiket / data..." class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
        </div>
      </div>
      <div class="flex items-center gap-2 w-full md:w-auto">
        <select name="status" id="statusFilter" onchange="this.form.submit()" class="w-full md:w-48 px-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
          <option value="">Semua Status</option>
          <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
          <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <button type="submit" class="hidden">Filter</button>
      </div>
    </form>
  </div>

  <div id="table-container" class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
      <h3 class="font-heading font-bold text-sm text-slate-800">Data Tiket</h3>
    </div>
    <div class="p-5 overflow-x-auto">
      <table class="w-full text-left border-collapse data-table">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">No Tiket</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">No Pengirim (WA)</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ringkasan Data</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($permohonan as $item)
          <tr>
            <td class="font-mono text-xs text-blue-700 font-semibold">{{ $item->nomor_tiket }}</td>
            <td class="font-medium whitespace-nowrap text-sm">{{ $item->phone }}</td>
            <td class="max-w-xs">
                @php
                    $jsonData = is_array($item->data) ? $item->data : json_decode($item->data, true);
                    $summary = '';
                    if(is_array($jsonData)) {
                        $count = 0;
                        foreach($jsonData as $key => $val) {
                            if($count < 2) {
                                $summary .= '<b>' . ucfirst(str_replace('_', ' ', $key)) . ':</b> ' . Str::limit($val, 20) . '<br>';
                            }
                            $count++;
                        }
                        if($count > 2) $summary .= '<span class="text-xs text-slate-400">... (+'.($count-2).' data lainnya)</span>';
                    }
                @endphp
                <p class="text-xs text-slate-600 leading-tight">{!! $summary ?: '-' !!}</p>
            </td>
            <td>
              @if(strtolower($item->status) == 'selesai' || $item->status == '1')
                <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-emerald-100 text-emerald-700 uppercase tracking-wide">Selesai</span>
              @else
                <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-orange-100 text-orange-700 uppercase tracking-wide">Open</span>
              @endif
            </td>
            <td class="flex gap-2 items-center">
              <button onclick="openModalAduan('{{ $item->id }}')" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-500 transition-colors" title="Lihat Detail Penuh"><i data-lucide="eye" class="w-4 h-4"></i></button>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center py-8 text-slate-500 text-sm">Tidak ada tiket/data ditemukan.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100 flex justify-end">
      {{ $permohonan->appends(request()->query())->links() }}
    </div>
  </div>

  <!-- Reusable Modal Container -->
  <div id="modal-backdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 transition-opacity duration-300 opacity-0" onclick="closeModalOutside(event)">
    <div id="modal-box" class="bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
      <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50 rounded-t-2xl">
        <h2 id="modal-title" class="font-heading font-bold text-slate-800 text-sm">Detail Penuh</h2>
        <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 bg-white p-1.5 rounded-lg shadow-sm border border-slate-200"><i data-lucide="x" class="w-4 h-4"></i></button>
      </div>
      <div id="modal-content" class="px-6 py-5 space-y-4 text-sm"></div>
    </div>
  </div>

  @section('Scripts')
  @if (session('success'))
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              showToast('{{ session("success") }}', 'success');
          });
      </script>
  @endif

  <script>
    var tableData = @json($permohonan->items());
    var updateRouteBase = "{{ route('update.layanan.admin', ':id') }}";

    function openModalAduan(id) {
      var item = tableData.find(x => x.id == id);
      if(!item) return;
      document.getElementById('modal-title').innerText = 'Detail Tiket: ' + item.nomor_tiket;
      
      var isSelesai = (item.status === 'selesai' || item.status === '1');
      var statusHtml = isSelesai 
        ? '<span class="px-2 py-1 text-[10px] font-bold rounded-md bg-emerald-100 text-emerald-700 uppercase tracking-wide">Selesai</span>' 
        : '<span class="px-2 py-1 text-[10px] font-bold rounded-md bg-orange-100 text-orange-700 uppercase tracking-wide">Open</span>';
      
      // Build JSON Data Grid
      var dataHtml = '';
      if(item.data && typeof item.data === 'object') {
          for(let key in item.data) {
              let label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
              let val = item.data[key];
              
              if (typeof val === 'string' && val.startsWith('/storage/bot_media/')) {
                  let isImage = val.match(/\.(jpeg|jpg|gif|png|webp)$/i) != null;
                  if (isImage) {
                      val = `<a href="${val}" target="_blank"><img src="${val}" class="max-w-full h-auto max-h-48 rounded-lg border border-slate-200 mt-2 object-contain" alt="Lampiran"></a>`;
                  } else {
                      val = `<a href="${val}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline font-bold flex items-center gap-1 mt-1"><i data-lucide="paperclip" class="w-4 h-4"></i> Unduh / Buka Dokumen</a>`;
                  }
              }

              dataHtml += `
                <div class="mb-3 border-b border-slate-100 pb-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">${label}</p>
                    <p class="text-slate-800 font-medium">${val}</p>
                </div>
              `;
          }
      }

      document.getElementById('modal-content').innerHTML = `
        <div class="flex items-center gap-3 mb-5 p-3 bg-blue-50 rounded-xl border border-blue-100">
            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                <i data-lucide="user" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-xs text-blue-600 font-bold uppercase tracking-wider">Pengirim (WhatsApp)</p>
                <p class="text-sm font-semibold text-blue-900">${item.phone || 'Tidak diketahui'}</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-slate-200 mb-5 shadow-sm">
            ${dataHtml || '<p class="text-slate-400 italic text-xs">Tidak ada data tercatat.</p>'}
        </div>

        <div class="flex items-center justify-between border-t border-slate-100 pt-4">
            <div class="flex items-center gap-2">
                <p class="text-xs font-bold text-slate-500">Status:</p>
                ${statusHtml}
            </div>
            
            <form action="${updateRouteBase.replace(':id', item.id)}" method="POST" class="m-0">
               @csrf @method('PATCH')
               <input type="hidden" name="status" value="${isSelesai ? 'open' : 'selesai'}">
               <button type="submit" class="px-4 py-2 rounded-xl shadow-sm ${isSelesai ? 'bg-orange-50 text-orange-700 border border-orange-200 hover:bg-orange-100' : 'bg-emerald-600 text-white hover:bg-emerald-700'} text-xs font-bold transition-colors">
                  Tandai sebagai ${isSelesai ? 'Open' : 'Selesai'}
               </button>
            </form>
        </div>
      `;
      showModal();
    }

    function showModal() {
        var backdrop = document.getElementById('modal-backdrop');
        var box = document.getElementById('modal-box');
        backdrop.classList.remove('hidden');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            box.classList.remove('scale-95');
            box.classList.add('scale-100');
        }, 10);
        if(typeof lucide !== 'undefined') lucide.createIcons();
    }

    function closeModal() {
        var backdrop = document.getElementById('modal-backdrop');
        var box = document.getElementById('modal-box');
        backdrop.classList.add('opacity-0');
        box.classList.remove('scale-100');
        box.classList.add('scale-95');
        setTimeout(() => backdrop.classList.add('hidden'), 300);
    }

    function closeModalOutside(e) {
        if (e.target === document.getElementById('modal-backdrop')) closeModal();
    }
  </script>
  @endsection
</x-layouts.modern>
