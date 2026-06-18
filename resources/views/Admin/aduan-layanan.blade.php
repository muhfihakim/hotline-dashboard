<x-layouts.modern>
  <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-heading font-bold text-slate-800">Aduan Layanan</h2>
      <p class="text-sm text-slate-500">Daftar semua aduan layanan yang masuk ke dalam sistem.</p>
    </div>
    <div class="flex items-center gap-2 text-sm text-slate-500">
      <span>Home</span> <i data-lucide="chevron-right" class="w-3 h-3"></i> <span class="font-semibold text-slate-700">Aduan Layanan</span>
    </div>
  </div>

  <div class="bg-white rounded-box shadow-soft border border-slate-200 p-4 mb-6" id="filter-card">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
      <div class="flex items-center gap-2 w-full md:w-auto">
        <div class="relative w-full md:w-64">
          <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
          <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Cari tiket atau nama..." class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
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
      <h3 class="font-heading font-bold text-sm text-slate-800">Data Aduan Layanan</h3>
    </div>
    <div class="p-5 overflow-x-auto">
      <table class="w-full text-left border-collapse data-table">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">No Tiket</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Instansi</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Isi Aduan</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($aduan as $item)
          <tr>
            <td class="font-mono text-xs text-brand-700 font-semibold">{{ $item->nomor_tiket }}</td>
            <td class="font-medium whitespace-nowrap">{{ $item->nama_lengkap }}</td>
            <td class="text-xs text-gray-500">{{ $item->instansi }}</td>
            <td class="max-w-xs"><p class="truncate text-gray-600 text-xs">{{ Str::limit($item->isi_aduan, 50) }}</p></td>
            <td>
              @if($item->status == '1')
                <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-emerald-100 text-emerald-700 uppercase tracking-wide">Selesai</span>
              @else
                <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-orange-100 text-orange-700 uppercase tracking-wide">Open</span>
              @endif
            </td>
            <td class="flex gap-2 items-center">
              <button onclick="openModalAduan('{{ $item->id }}')" class="p-1.5 rounded-lg hover:bg-brand-50 text-brand-500" title="Detail"><i data-lucide="eye" class="w-4 h-4"></i></button>
              <button onclick="openReplyModal('{{ $item->id }}')" class="p-1.5 rounded-lg hover:bg-emerald-50 text-emerald-500" title="Balas"><i data-lucide="message-square" class="w-4 h-4"></i></button>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center py-4 text-gray-500">Tidak ada aduan ditemukan</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100 flex justify-end">
      {{ $aduan->appends(request()->query())->links() }}
    </div>
  </div>

  <!-- Reusable Modal Container -->
  <div id="modal-backdrop" class="fixed inset-0 bg-black/40 z-50 hidden flex items-center justify-center p-4" onclick="closeModalOutside(event)">
    <div id="modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
      <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-brand-700 to-brand-600 rounded-t-2xl">
        <h2 id="modal-title" class="font-heading text-white text-base">Detail</h2>
        <button onclick="closeModal()" class="text-white/70 hover:text-white"><i data-lucide="x" class="w-5 h-5"></i></button>
      </div>
      <div id="modal-content" class="px-6 py-5 space-y-4 text-sm"></div>
    </div>
  </div>

  @section('Scripts')
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @if (session('alert.config'))
      <script>
          Swal.fire({!! session('alert.config') !!});
      </script>
  @endif
  @if (session('success'))
      <script>
          showToast('{{ session('success') }}', 'success');
      </script>
  @endif
  @if (session('error'))
      <script>
          showToast('{{ session('error') }}', 'error');
      </script>
  @endif

  <script>
    // Escape HTML from backend to avoid JS injection issues
    var aduanData = @json($aduan);
    var updateRouteBase = "{{ route('update.aduan.admin', ':id') }}";
    var replyRouteBase = "{{ route('aduan.reply', ':id') }}";

    function openModalAduan(id) {
      var item = aduanData.find(x => x.id == id);
      if(!item) return;
      document.getElementById('modal-title').innerText = 'Detail Aduan';
      
      var statusHtml = item.status == '1' ? '<span class="px-2 py-1 text-[10px] font-bold rounded-md bg-emerald-100 text-emerald-700 uppercase tracking-wide">Selesai</span>' : '<span class="px-2 py-1 text-[10px] font-bold rounded-md bg-orange-100 text-orange-700 uppercase tracking-wide">Open</span>';
      
      document.getElementById('modal-content').innerHTML = `
        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 mb-4 whitespace-pre-wrap">${item.isi_aduan}</div>
        <p><strong>Status Saat Ini:</strong> ${statusHtml}</p>
        <form action="${updateRouteBase.replace(':id', item.id)}" method="POST" class="mt-4 border-t pt-4 flex gap-2">
           @csrf @method('PATCH')
           <input type="hidden" name="status" value="${item.status == '1' ? '0' : '1'}">
           <button type="submit" class="px-4 py-2 rounded-lg ${item.status == '1' ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-accent-500 text-white hover:bg-accent-600'} text-sm font-semibold transition-colors">
              Ubah ke ${item.status == '1' ? 'Open' : 'Selesai'}
           </button>
        </form>
      `;
      showModal();
    }

    function openReplyModal(id) {
      var item = aduanData.find(x => x.id == id);
      if(!item) return;
      var nomor = item.user_id ? item.user_id.replace('@c.us', '') : '';
      document.getElementById('modal-title').innerText = 'Balas Aduan Tiket: ' + item.nomor_tiket;
      document.getElementById('modal-content').innerHTML = `
        <form action="${replyRouteBase.replace(':id', item.id)}" method="POST">
           @csrf
           <div class="mb-3">
             <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Pengadu</label>
             <input type="text" value="${item.nama_lengkap}" disabled class="w-full border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 text-gray-600">
           </div>
           <div class="mb-3">
             <label class="block text-xs font-semibold text-gray-500 mb-1">Nomor WhatsApp</label>
             <input type="text" name="nomor" value="${nomor}" readonly class="w-full border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 text-gray-600">
           </div>
           <div class="mb-4">
             <label class="block text-xs font-semibold text-gray-500 mb-1">Isi Balasan</label>
             <textarea name="pesan" rows="5" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-gray-700 focus:ring-2 focus:ring-brand-400 outline-none transition-shadow" required placeholder="Ketik balasan Anda di sini..."></textarea>
           </div>
           <div class="flex justify-end gap-2">
             <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 text-sm font-medium transition-colors">Batal</button>
             <button type="submit" class="px-4 py-2 bg-brand-600 text-white hover:bg-brand-700 rounded-lg text-sm font-semibold transition-colors">Kirim Balasan</button>
           </div>
        </form>
      `;
      showModal();
    }

    function showModal() {
        var backdrop = document.getElementById('modal-backdrop');
        backdrop.classList.remove('hidden');
        setTimeout(() => backdrop.style.opacity = '1', 10);
        lucide.createIcons();
    }
    function closeModal() {
        var backdrop = document.getElementById('modal-backdrop');
        backdrop.style.opacity = '0';
        setTimeout(() => backdrop.classList.add('hidden'), 200);
    }
    function closeModalOutside(e) {
        if (e.target === document.getElementById('modal-backdrop')) closeModal();
    }
  </script>
  @endsection
</x-layouts.modern>
