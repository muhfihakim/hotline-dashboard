<x-layouts.modern>
  <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-heading font-bold text-slate-800">Pengguna Aplikasi</h2>
      <p class="text-sm text-slate-500">Manajemen akses dan daftar pengguna sistem.</p>
    </div>
    <div class="flex items-center gap-2 text-sm text-slate-500">
      <span>Home</span> <i data-lucide="chevron-right" class="w-3 h-3"></i> <span class="font-semibold text-slate-700">Pengguna</span>
    </div>
  </div>

  <div class="bg-white rounded-box shadow-soft border border-slate-200 p-4 mb-6" id="filter-card">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
      <div class="flex items-center gap-2 w-full md:w-auto">
        <div class="relative w-full md:w-64">
          <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
          <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
        </div>
      </div>
      <div class="flex items-center gap-3 w-full md:w-auto">
        <select id="statusFilter" class="w-full md:w-48 px-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
          <option value="">Semua Posisi</option>
          <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="pimpinan" {{ request('role') === 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
        </select>
        <button onclick="openAddModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors whitespace-nowrap flex gap-2 items-center cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah
        </button>
      </div>
    </div>
  </div>

  <div id="table-container" class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
      <h3 class="font-heading font-bold text-sm text-slate-800">Data Pengguna</h3>
    </div>
    <div class="p-5 overflow-x-auto">
      <table class="w-full text-left border-collapse data-table">
        <thead>
          <tr>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider w-16">No</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Email</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Posisi</th>
            <th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pengguna as $index => $user)
          <tr>
            <td class="font-medium whitespace-nowrap text-xs text-slate-500">{{ $pengguna->firstItem() + $index }}</td>
            <td class="font-semibold text-slate-800 text-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs uppercase border border-slate-200">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    {{ $user->name }}
                </div>
            </td>
            <td class="text-slate-500 text-sm">{{ $user->email }}</td>
            <td>
              @if($user->role == 'admin')
                <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-blue-50 text-blue-600 uppercase tracking-wide border border-blue-100">Admin</span>
              @else
                <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-purple-50 text-purple-600 uppercase tracking-wide border border-purple-100">Pimpinan</span>
              @endif
            </td>
            <td class="text-right">
                <div class="flex justify-end gap-2 items-center">
                    <button onclick="openEditModal({{ $user->id }})" class="p-1.5 rounded-lg hover:bg-amber-50 text-amber-500 transition-colors cursor-pointer" title="Edit Pengguna"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                    @if(auth()->id() != $user->id)
                    <form action="{{ route('destroy.pengguna.admin', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 rounded-lg hover:bg-rose-50 text-rose-500 transition-colors cursor-pointer" title="Hapus Pengguna"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </form>
                    @endif
                </div>
            </td>
          </tr>
          @endforeach
          @if(count($pengguna) == 0)
          <tr>
              <td colspan="5" class="text-center py-8 text-gray-500 text-sm font-medium">Belum ada data pengguna ditemukan.</td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100 flex justify-end">
      {{ $pengguna->appends(request()->query())->links() }}
    </div>
  </div>

  <!-- Reusable Modal Container -->
  <div id="modal-backdrop" class="fixed inset-0 bg-slate-900/40 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm transition-opacity opacity-0" onclick="closeModalOutside(event)">
    <div id="modal-box" class="bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-hidden flex flex-col" onclick="event.stopPropagation()">
      <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
        <h2 id="modal-title" class="font-heading font-bold text-slate-800 text-lg">Tambah Pengguna</h2>
        <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 bg-white hover:bg-slate-100 rounded-lg p-1.5 transition-colors cursor-pointer"><i data-lucide="x" class="w-4 h-4"></i></button>
      </div>
      <div id="modal-content" class="px-6 py-5 overflow-y-auto">
          <form id="penggunaForm" action="{{ route('store.pengguna.admin') }}" method="POST">
             @csrf
             <input type="hidden" name="_method" id="formMethod" value="POST">
             
             <div class="space-y-4 text-sm">
                 <div>
                     <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                     <input type="text" name="name" id="nameInput" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-white text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required placeholder="Masukkan nama...">
                 </div>
                 <div>
                     <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Email</label>
                     <input type="email" name="email" id="emailInput" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-white text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required placeholder="email@domain.com">
                 </div>
                 <div>
                     <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Posisi / Role</label>
                     <select name="role" id="roleInput" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-white text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all appearance-none cursor-pointer" required>
                         <option value="admin">Admin</option>
                         <option value="pimpinan">Pimpinan</option>
                     </select>
                 </div>
                 <div>
                     <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Password <span id="passwordHelp" class="text-slate-400 font-normal lowercase">(Opsional jika edit)</span></label>
                     <input type="password" name="password" id="passwordInput" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-white text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Minimal 8 karakter...">
                 </div>
             </div>

             <div class="mt-6 pt-5 border-t border-slate-100 flex justify-end gap-3">
                 <button type="button" onclick="closeModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition-colors cursor-pointer">Batal</button>
                 <button type="submit" id="submitBtn" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm shadow-blue-200 cursor-pointer">Simpan Data</button>
             </div>
          </form>
      </div>
    </div>
  </div>

  @section('Scripts')
      <script>
          var penggunaData = @json($pengguna->items());
          var storeRoute = "{{ route('store.pengguna.admin') }}";
          var updateRouteBase = "{{ url('/pengguna') }}";

          function openAddModal() {
              document.getElementById('modal-title').innerText = 'Tambah Pengguna Baru';
              document.getElementById('penggunaForm').action = storeRoute;
              document.getElementById('formMethod').value = 'POST';
              
              document.getElementById('nameInput').value = '';
              document.getElementById('emailInput').value = '';
              document.getElementById('roleInput').value = 'admin';
              document.getElementById('passwordInput').value = '';
              document.getElementById('passwordInput').required = true;
              document.getElementById('passwordHelp').classList.add('hidden');
              document.getElementById('submitBtn').innerText = 'Tambahkan';
              
              showModal();
          }

          function openEditModal(id) {
              const user = penggunaData.find(u => u.id == id);
              if(!user) return;
              
              document.getElementById('modal-title').innerText = 'Edit Pengguna';
              document.getElementById('penggunaForm').action = updateRouteBase + '/' + id;
              document.getElementById('formMethod').value = 'PATCH';
              
              document.getElementById('nameInput').value = user.name;
              document.getElementById('emailInput').value = user.email;
              document.getElementById('roleInput').value = user.role;
              document.getElementById('passwordInput').value = '';
              document.getElementById('passwordInput').required = false;
              document.getElementById('passwordHelp').classList.remove('hidden');
              document.getElementById('submitBtn').innerText = 'Perbarui';

              showModal();
          }

          function showModal() {
              const backdrop = document.getElementById('modal-backdrop');
              backdrop.classList.remove('hidden');
              // allow display block to apply before transitioning opacity
              requestAnimationFrame(() => {
                  backdrop.classList.remove('opacity-0');
              });
              if(typeof lucide !== 'undefined') lucide.createIcons();
          }
          
          function closeModal() {
              const backdrop = document.getElementById('modal-backdrop');
              backdrop.classList.add('opacity-0');
              setTimeout(() => backdrop.classList.add('hidden'), 300);
          }
          
          function closeModalOutside(e) {
              if (e.target === document.getElementById('modal-backdrop')) closeModal();
          }
      </script>

      <!-- Menampilkan Toasts Global -->
      @if ($errors->any())
          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  showToast('{{ $errors->first() }}', 'error');
              });
          </script>
      @endif
      @if (session('success'))
          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  showToast('{{ session("success") }}', 'success');
              });
          </script>
      @endif
      @if (session('error'))
          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  showToast('{{ session("error") }}', 'error');
              });
          </script>
      @endif
  @endsection
</x-layouts.modern>
