<x-layouts.modern>
  <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-heading font-bold text-slate-800">Manajemen Layanan & Pertanyaan</h2>
      <p class="text-sm text-slate-500">Kelola daftar menu layanan dan alur pertanyaan bot secara dinamis.</p>
    </div>
    <div class="flex items-center gap-2 text-sm text-slate-500">
      <span>Home</span> <i data-lucide="chevron-right" class="w-3 h-3"></i> <span class="font-semibold text-slate-700">Manajemen Layanan</span>
    </div>
  </div>

  <!-- MANAJEMEN MENU LAYANAN -->
  <div class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden mb-6">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
      <h3 class="font-heading font-bold text-sm text-slate-800">Daftar Menu Layanan Utama</h3>
      <button onclick="openModalTambah()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold transition-colors flex items-center gap-1.5 shadow-sm shadow-blue-200">
          <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah Layanan
      </button>
    </div>
    <div class="p-5">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($layanans as $layanan)
        <div class="border border-slate-200 rounded-xl p-4 relative group hover:border-blue-300 hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="{{ $layanan->icon }}" class="w-5 h-5"></i>
                </div>
                <div class="flex gap-1">
                    <button onclick='openModalEdit(@json($layanan))' class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Layanan"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                    <form action="{{ route('destroy.manajemen.layanan', $layanan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus layanan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Layanan"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </form>
                </div>
            </div>
            <h4 class="font-bold text-slate-800 text-base leading-tight mb-1">{{ $layanan->nama }}</h4>
            <p class="text-xs text-slate-500 font-mono">Kode Bot: <span class="font-bold text-slate-700">{{ $layanan->kode }}</span></p>
            <p class="text-[10px] text-slate-400 mt-2">{{ count($layanan->pertanyaan ?? []) }} Langkah Pertanyaan</p>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- BUILDER PERTANYAAN -->
  <div class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden mb-6">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
      <h3 class="font-heading font-bold text-sm text-slate-800">Alur Pertanyaan (Step-by-Step Builder)</h3>
    </div>
    <div class="p-5 space-y-6">
        @foreach($layanans as $layanan)
        <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50/30">
            <div class="px-5 py-3 border-b border-slate-200 bg-white flex justify-between items-center cursor-pointer hover:bg-slate-50" onclick="toggleFlow('flow-{{ $layanan->id }}', this)">
                <div class="flex items-center gap-3">
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400 transition-transform duration-200" id="icon-flow-{{ $layanan->id }}"></i>
                    <h5 class="font-bold text-slate-800 text-sm">{{ $layanan->kode }}. {{ $layanan->nama }}</h5>
                </div>
                <span class="text-xs font-semibold px-2 py-1 bg-slate-100 text-slate-500 rounded-md">{{ count($layanan->pertanyaan ?? []) }} Step</span>
            </div>
            <div id="flow-{{ $layanan->id }}" class="hidden">
                <form action="{{ route('update.pertanyaan.layanan', $layanan->id) }}" method="POST" class="p-5">
                    @csrf @method('PATCH')
                    
                    <div class="space-y-3" id="container-{{ $layanan->id }}">
                        @forelse($layanan->pertanyaan ?? [] as $index => $q)
                        <div class="flex items-start gap-3 group question-row">
                            <div class="w-1/3 md:w-1/4">
                                <select name="pertanyaan[{{ $index }}][type]" class="w-full border border-slate-200 rounded-xl px-4 py-2 bg-white text-slate-800 focus:ring-2 focus:ring-blue-500 text-sm outline-none appearance-none">
                                    <option value="text" {{ ($q['type']??'text') == 'text' ? 'selected' : '' }}>Teks Biasa</option>
                                    <option value="image" {{ ($q['type']??'text') == 'image' ? 'selected' : '' }}>Gambar / Foto</option>
                                    <option value="document" {{ ($q['type']??'text') == 'document' ? 'selected' : '' }}>Dokumen (PDF/Word)</option>
                                    <option value="video" {{ ($q['type']??'text') == 'video' ? 'selected' : '' }}>Video</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <input type="text" name="pertanyaan[{{ $index }}][question]" value="{{ $q['question'] ?? '' }}" placeholder="Teks Pertanyaan yang dikirim Bot" class="w-full border border-slate-200 rounded-xl px-4 py-2 bg-white text-slate-800 focus:ring-2 focus:ring-blue-500 text-sm outline-none" required>
                            </div>
                            <button type="button" onclick="this.closest('.question-row').remove()" class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors focus:opacity-100 mt-0.5">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                        @empty
                        <p class="text-xs text-slate-400 italic empty-state mb-2">Belum ada pertanyaan. Silakan tambahkan pertanyaan pertama.</p>
                        @endforelse
                    </div>

                    <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4">
                        <button type="button" onclick="addQuestion({{ $layanan->id }})" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded-lg transition-colors">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah Baris
                        </button>
                        <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold transition-colors shadow-sm shadow-blue-200">
                            Simpan Alur
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>
  </div>

  <!-- Modal Tambah/Edit Layanan -->
  <div id="modal-layanan" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity" onclick="closeModal()">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md scale-95 transition-transform duration-300" id="modal-layanan-box" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50 rounded-t-2xl">
            <h2 id="modal-title" class="font-heading font-bold text-slate-800 text-sm">Tambah Layanan</h2>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 bg-white p-1.5 rounded-lg border border-slate-200"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
        <form id="form-layanan" action="{{ route('store.manajemen.layanan') }}" method="POST" class="p-6">
            @csrf
            <div id="method-put"></div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kode Balasan Bot (Pemicu) <span class="text-rose-500">*</span></label>
                    <input type="text" name="kode" id="input-kode" required placeholder="Contoh: 9" class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
                    <p class="text-[10px] text-slate-500 mt-1">Harus unik. Pengguna WA akan mengetik kode ini untuk memulai layanan.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Layanan <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" id="input-nama" required placeholder="Contoh: Permohonan Cuti" class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Icon (Lucide)</label>
                    <input type="text" name="icon" id="input-icon" placeholder="Contoh: folder" value="folder" class="w-full border border-slate-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 text-sm outline-none font-mono">
                    <p class="text-[10px] text-blue-600 hover:underline mt-1"><a href="https://lucide.dev/icons" target="_blank">Lihat daftar icon di lucide.dev</a></p>
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Batal</button>
                <button type="submit" id="btn-submit" class="px-6 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm shadow-blue-200 transition-colors">Simpan Layanan</button>
            </div>
        </form>
    </div>
  </div>

  @section('Scripts')
  <script>
      function toggleFlow(id, headerEl) {
          const content = document.getElementById(id);
          const icon = document.getElementById('icon-' + id);
          if(content.classList.contains('hidden')) {
              content.classList.remove('hidden');
              icon.style.transform = 'rotate(90deg)';
              headerEl.classList.add('bg-blue-50/50');
          } else {
              content.classList.add('hidden');
              icon.style.transform = 'rotate(0deg)';
              headerEl.classList.remove('bg-blue-50/50');
          }
      }

      function addQuestion(layananId) {
          const container = document.getElementById('container-' + layananId);
          const emptyText = container.querySelector('.empty-state');
          if(emptyText) emptyText.remove();

          const index = container.querySelectorAll('.question-row').length;
          const row = document.createElement('div');
          row.className = "flex items-start gap-3 group question-row";
          row.innerHTML = `
              <div class="w-1/3 md:w-1/4">
                  <select name="pertanyaan[${index}][type]" class="w-full border border-slate-200 rounded-xl px-4 py-2 bg-white text-slate-800 focus:ring-2 focus:ring-blue-500 text-sm outline-none appearance-none">
                      <option value="text">Teks Biasa</option>
                      <option value="image">Gambar / Foto</option>
                      <option value="document">Dokumen (PDF/Word)</option>
                      <option value="video">Video</option>
                  </select>
              </div>
              <div class="flex-1">
                  <input type="text" name="pertanyaan[${index}][question]" placeholder="Teks Pertanyaan yang dikirim Bot" class="w-full border border-slate-200 rounded-xl px-4 py-2 bg-white text-slate-800 focus:ring-2 focus:ring-blue-500 text-sm outline-none" required>
              </div>
              <button type="button" onclick="this.closest('.question-row').remove()" class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors focus:opacity-100 mt-0.5">
                  <i data-lucide="trash-2" class="w-4 h-4"></i>
              </button>
          `;
          container.appendChild(row);
          lucide.createIcons();
      }

      function openModalTambah() {
          document.getElementById('modal-title').innerText = 'Tambah Layanan Baru';
          document.getElementById('form-layanan').action = "{{ route('store.manajemen.layanan') }}";
          document.getElementById('method-put').innerHTML = '';
          document.getElementById('input-kode').value = '';
          document.getElementById('input-nama').value = '';
          document.getElementById('input-icon').value = 'folder';
          document.getElementById('btn-submit').innerText = 'Simpan Layanan';
          
          showModal();
      }

      function openModalEdit(layanan) {
          document.getElementById('modal-title').innerText = 'Edit Layanan';
          document.getElementById('form-layanan').action = `/admin/manajemen-layanan/${layanan.id}`;
          document.getElementById('method-put').innerHTML = '@method("PATCH")';
          document.getElementById('input-kode').value = layanan.kode;
          document.getElementById('input-nama').value = layanan.nama;
          document.getElementById('input-icon').value = layanan.icon;
          document.getElementById('btn-submit').innerText = 'Perbarui Layanan';
          
          showModal();
      }

      function showModal() {
          const modal = document.getElementById('modal-layanan');
          const box = document.getElementById('modal-layanan-box');
          modal.classList.remove('hidden');
          setTimeout(() => {
              modal.classList.remove('opacity-0');
              box.classList.remove('scale-95');
          }, 10);
      }

      function closeModal() {
          const modal = document.getElementById('modal-layanan');
          const box = document.getElementById('modal-layanan-box');
          modal.classList.add('opacity-0');
          box.classList.add('scale-95');
          setTimeout(() => modal.classList.add('hidden'), 300);
      }
  </script>

  @if (session('success'))
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              showToast('{{ session("success") }}', 'success');
          });
      </script>
  @endif
  @if ($errors->any())
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              showToast('{{ $errors->first() }}', 'error');
          });
      </script>
  @endif
  @endsection
</x-layouts.modern>
