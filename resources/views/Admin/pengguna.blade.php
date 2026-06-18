<x-layouts.modern>
  <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-heading font-bold text-slate-800">Pengguna Aplikasi</h2>
      <p class="text-sm text-slate-500">Daftar pengguna yang memiliki akses ke dalam sistem.</p>
    </div>
    <div class="flex items-center gap-2 text-sm text-slate-500">
      <span>Home</span> <i data-lucide="chevron-right" class="w-3 h-3"></i> <span class="font-semibold text-slate-700">Pengguna Aplikasi</span>
    </div>
  </div>

  <div class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
      <h3 class="font-heading font-bold text-sm text-slate-800">Data Pengguna</h3>
    </div>
    <div class="p-5 overflow-x-auto">
      <table id="example1" class="w-full text-left border-collapse">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider w-16">No</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Posisi</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Email</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider w-24">Aksi</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider w-24">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <!-- Data Pengguna (Saat ini kosong di kode sumber) -->
        </tbody>
      </table>
    </div>
  </div>

  @section('Scripts')
      <script>
          function submitStatus(id, statusValue) {
              document.getElementById('statusInput' + id).value = statusValue;
              document.getElementById('statusForm' + id).submit();
          }
      </script>

      <!-- SweetAlert2 -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      @if (session('alert.config'))
          <script>Swal.fire({!! session('alert.config') !!});</script>
      @endif
  @endsection
</x-layouts.modern>
