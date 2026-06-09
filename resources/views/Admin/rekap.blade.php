<x-layouts.modern>
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Export Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-r from-brand-700 to-brand-600">
            <h3 class="font-heading text-base text-white">Export Laporan</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('export.layanan') }}" method="GET" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rentang Tanggal:</label>
                    <div class="relative">
                        <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                        <input type="text" id="reservation" name="tanggal" class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brand-300 focus:border-brand-400 outline-none text-gray-700 bg-gray-50" placeholder="Pilih tanggal">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Layanan:</label>
                    <div class="relative">
                        <i data-lucide="layers" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                        <select name="layanan" id="layanan" class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brand-300 focus:border-brand-400 outline-none text-gray-700 bg-gray-50 appearance-none cursor-pointer" required>
                            <option value="" disabled selected>Pilih Layanan Yang Akan Diexport</option>
                            <option value="aduan">Aduan Layanan</option>
                            <option value="virtualmeeting">Virtual Meeting</option>
                            <option value="vps">Virtual Private Server</option>
                            <option value="bod">Bandwidth On Demand</option>
                            <option value="infrastruktur">Infrastruktur Baru</option>
                            <option value="email">Layanan Email</option>
                            <option value="pentest">Pen-Testing</option>
                            <option value="tte">Tanda Tangan Elektronik</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="submit" name="format" value="pdf" class="flex items-center justify-center gap-2 flex-1 px-4 py-2.5 rounded-lg bg-red-500 text-white hover:bg-red-600 font-semibold transition-colors">
                        <i data-lucide="file-text" class="w-5 h-5"></i> Export PDF
                    </button>
                    <button type="submit" name="format" value="excel" class="flex items-center justify-center gap-2 flex-1 px-4 py-2.5 rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 font-semibold transition-colors">
                        <i data-lucide="sheet" class="w-5 h-5"></i> Export Excel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Panduan -->
    <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden h-fit">
        <div class="px-5 py-4 border-b border-emerald-100 bg-gradient-to-r from-emerald-600 to-emerald-500">
            <h3 class="font-heading text-base text-white flex items-center gap-2"><i data-lucide="help-circle" class="w-5 h-5"></i> Panduan Export</h3>
        </div>
        <div class="p-6">
            <ol class="list-decimal list-inside space-y-3 text-sm text-gray-600">
                <li>Pilih <strong class="text-gray-800">rentang tanggal</strong> mulai dan akhir yang diinginkan menggunakan kolom tanggal yang tersedia.</li>
                <li>Pilih <strong class="text-gray-800">layanan</strong> yang ingin Anda ekspor dari daftar dropdown.</li>
                <li>Setelah memilih tanggal dan layanan, klik tombol <strong class="text-gray-800">Export PDF</strong> atau <strong class="text-gray-800">Export Excel</strong> sesuai kebutuhan Anda.</li>
                <li>File hasil export akan otomatis terunduh ke perangkat Anda.</li>
            </ol>
            <div class="mt-5 p-4 bg-yellow-50 rounded-lg border border-yellow-100 flex items-start gap-3">
                <i data-lucide="info" class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5"></i>
                <p class="text-xs text-yellow-700 leading-relaxed"><strong class="font-semibold">Catatan:</strong> Pastikan Anda telah memilih rentang tanggal dan layanan dengan benar sebelum menekan tombol export. Data yang diekspor akan mencakup semua permohonan dalam rentang tersebut terlepas dari statusnya.</p>
            </div>
        </div>
    </div>
  </div>

  @section('Css')
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
  @endsection

  @section('Scripts')
      <!-- SweetAlert2 -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      @if (session('alert.config'))
          <script>Swal.fire({!! session('alert.config') !!});</script>
      @endif

      <!-- DateRangePicker -->
      <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
      <script>
          $(function() {
              $('#reservation').daterangepicker({
                  locale: { format: 'DD-MM-YYYY' },
                  opens: 'left'
              });
          });
      </script>
  @endsection
</x-layouts.modern>
