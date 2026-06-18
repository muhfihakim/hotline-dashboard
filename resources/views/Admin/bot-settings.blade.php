<x-layouts.modern>
  <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-heading font-bold text-slate-800">Pengaturan Bot</h2>
      <p class="text-sm text-slate-500">Koneksi WhatsApp dan konfigurasi balasan bot otomatis.</p>
    </div>
  </div>

  <!-- STATUS KONEKSI WHATSAPP -->
  <div class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden mb-6">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
      <h3 class="font-heading font-bold text-sm text-slate-800 flex items-center gap-2">
          <i data-lucide="smartphone" class="w-4 h-4 text-emerald-600"></i> Status Koneksi WhatsApp
      </h3>
      @if($botState['status'] === 'CONNECTED')
          <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full flex items-center gap-1">
              <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Terhubung
          </span>
      @elseif($botState['status'] === 'AWAITING_SCAN')
          <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full flex items-center gap-1">
              <i data-lucide="scan-line" class="w-3 h-3"></i> Menunggu Scan QR
          </span>
      @else
          <span class="px-3 py-1 bg-rose-100 text-rose-700 text-xs font-bold rounded-full flex items-center gap-1">
              <i data-lucide="wifi-off" class="w-3 h-3"></i> Terputus (Offline)
          </span>
      @endif
    </div>
    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-8 items-center justify-center md:justify-start">
            
            <div class="flex-shrink-0 bg-slate-50 p-4 rounded-2xl border border-slate-200 flex flex-col items-center justify-center min-w-[200px] min-h-[200px]">
                @if($botState['status'] === 'CONNECTED')
                    <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mb-3">
                        <i data-lucide="check-circle-2" class="w-12 h-12 text-emerald-600"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Bot Aktif!</p>
                @elseif($botState['status'] === 'AWAITING_SCAN' && $botState['qr'])
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($botState['qr']) }}" alt="QR Code" class="w-48 h-48 rounded-lg mb-2">
                    <p class="text-xs text-slate-500 text-center">Buka WhatsApp > Perangkat Tertaut > Tautkan Perangkat</p>
                @else
                    <div class="w-24 h-24 bg-rose-100 rounded-full flex items-center justify-center mb-3">
                        <i data-lucide="server-crash" class="w-12 h-12 text-rose-600"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-800 text-center">Service Node.js<br>Mati / Terputus</p>
                @endif
            </div>

            <div class="flex-1 space-y-4 text-center md:text-left">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Terhubung</p>
                    <p class="text-2xl font-heading font-bold text-slate-800">
                        {{ $botState['phone'] ? '+' . preg_replace('/@c\.us$/', '', $botState['phone']) : 'Belum Ada' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status Sistem</p>
                    <p class="text-sm font-medium text-slate-600">
                        @if($botState['status'] === 'CONNECTED')
                            Sistem berjalan normal. Bot siap menerima dan membalas pesan.
                        @elseif($botState['status'] === 'AWAITING_SCAN')
                            Silakan scan QR Code di samping menggunakan aplikasi WhatsApp Anda.
                        @else
                            Pastikan Anda menjalankan perintah <code>node index.js</code> di dalam folder <code>wa-bot</code>.
                        @endif
                    </p>
                </div>
                
                @if($botState['status'] === 'CONNECTED')
                <div class="pt-4 border-t border-slate-100">
                    <form action="{{ route('logout.bot.admin') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memutus koneksi (Logout) nomor WhatsApp ini?')">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 mx-auto md:mx-0">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Putus Koneksi (Logout)
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
  </div>

  <div class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden mb-6">
    <div class="flex border-b border-slate-200 bg-slate-50/50">
      <button class="px-6 py-4 text-sm font-semibold text-blue-600 border-b-2 border-blue-600 transition-colors bg-white focus:outline-none"><i data-lucide="message-square-text" class="w-4 h-4 inline-block -mt-0.5 mr-1"></i> Pesan Dasar</button>
    </div>

    @php
        $allLayanan = \App\Models\Layanan::orderBy('kode', 'asc')->get();
        $listLayananText = "";
        $emojiMap = [
            '0' => '0️⃣', '1' => '1️⃣', '2' => '2️⃣', '3' => '3️⃣', '4' => '4️⃣',
            '5' => '5️⃣', '6' => '6️⃣', '7' => '7️⃣', '8' => '8️⃣', '9' => '9️⃣'
        ];
        
        foreach ($allLayanan as $layanan) {
            $kode = (string) $layanan->kode;
            $emojiKode = '';
            for ($i = 0; $i < strlen($kode); $i++) {
                $emojiKode .= $emojiMap[$kode[$i]] ?? $kode[$i];
            }
            $listLayananText .= $emojiKode . " " . $layanan->nama . "\\n";
        }
    @endphp

    <div class="p-5">
      <form action="{{ route('update.bot-settings.admin') }}" method="POST">
        @csrf
        @method('PATCH')
        
        <!-- TAB PESAN DASAR -->
        <div id="tab-utama" class="grid grid-cols-1 md:grid-cols-2 gap-6 transition-all duration-300">
          @foreach($settings as $setting)
            @if(in_array($setting->key, ['greeting_message', 'reply_success', 'reply_fallback']))
              <div class="space-y-2 {{ $setting->key == 'greeting_message' ? 'md:col-span-2' : '' }}">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-bold text-slate-700">
                        {{ $setting->name }}
                    </label>
                    @if(in_array($setting->key, ['greeting_message', 'reply_fallback']))
                    <button type="button" onclick="insertText('{{ $setting->id }}', '{!! $listLayananText !!}')" class="text-[10px] font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-md transition-colors cursor-pointer border border-blue-200 shadow-sm" title="Klik untuk menyisipkan daftar layanan saat ini">
                        + Sisipkan Daftar Layanan
                    </button>
                    @endif
                </div>
                <textarea id="textarea-{{ $setting->id }}" name="settings[{{ $setting->id }}]" rows="{{ $setting->key == 'greeting_message' ? '8' : '4' }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-white text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-y text-sm font-mono leading-relaxed" required>{{ $setting->value }}</textarea>
                @if($setting->description)
                  <p class="text-xs text-slate-500"><i data-lucide="info" class="w-3 h-3 inline-block -mt-0.5 mr-1"></i> {{ $setting->description }}</p>
                @endif
              </div>
            @endif
          @endforeach
        </div>

        <div class="mt-8 pt-5 border-t border-slate-100 flex justify-end gap-3">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm shadow-blue-200 cursor-pointer flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Konfigurasi
            </button>
        </div>
      </form>
    </div>
  </div>

  @section('Scripts')
      <script>
          function insertText(settingId, textToInsert) {
              const textarea = document.getElementById('textarea-' + settingId);
              if (!textarea) return;
              
              // Mengganti \n string literal ke aktual newline
              const decodedText = textToInsert.replace(/\\n/g, '\n');
              
              const startPos = textarea.selectionStart;
              const endPos = textarea.selectionEnd;
              const text = textarea.value;
              
              textarea.value = text.substring(0, startPos) + decodedText + text.substring(endPos, text.length);
              textarea.focus();
              textarea.selectionStart = startPos + decodedText.length;
              textarea.selectionEnd = startPos + decodedText.length;
          }
      </script>

      @if (session('success'))
          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  showToast('{{ session("success") }}', 'success');
              });
          </script>
      @endif
  @endsection
</x-layouts.modern>
