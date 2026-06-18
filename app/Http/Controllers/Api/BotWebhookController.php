<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BotSetting;
use App\Models\BotSession;
use Illuminate\Support\Str;

class BotWebhookController extends Controller
{
    /**
     * Ambil dari Layanan DB
     */
    private function getFlowQuestions($serviceId)
    {
        $layanan = \App\Models\Layanan::where('kode', $serviceId)->first();
        $questions = [];
        
        if ($layanan && $layanan->pertanyaan) {
            $decoded = is_array($layanan->pertanyaan) ? $layanan->pertanyaan : json_decode($layanan->pertanyaan, true);
            if (is_array($decoded)) {
                foreach ($decoded as $item) {
                    if (isset($item['question'])) {
                        // slug string for json keys
                        $key = $item['key'] ?? \Illuminate\Support\Str::slug(substr($item['question'], 0, 30), '_');
                        $type = $item['type'] ?? 'text';
                        $questions[] = [
                            'key' => $key,
                            'type' => $type,
                            'question' => $item['question']
                        ];
                    }
                }
            }
        }
        
        return $questions;
    }

    /**
     * Menerima pesan masuk dari Bot Node.js
     */
    public function handle(Request $request)
    {
        $from = $request->input('from'); 
        $name = $request->input('name') ?? 'User';
        $body = $request->input('body'); 
        
        $message = trim($body);
        $messageLower = strtolower($message);
        
        // 1. Cek perintah batal/menu untuk mereset sesi
        if (in_array($messageLower, ['batal', 'cancel', 'menu', 'halo', 'ping', 'hi', 'p'])) {
            BotSession::where('phone', $from)->delete();
            
            $replyText = BotSetting::getValue('greeting_message');
            $replyText = str_replace('{name}', $name, $replyText);
            
            // Parse [DAFTAR_LAYANAN] shortcode
            if (str_contains($replyText, '[DAFTAR_LAYANAN]')) {
                $allLayanan = \App\Models\Layanan::orderBy('kode', 'asc')->get();
                $listStr = "";
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
                    $listStr .= $emojiKode . " " . $layanan->nama . "\n";
                }
                $replyText = str_replace('[DAFTAR_LAYANAN]', trim($listStr), $replyText);
            }
            
            return response()->json(['success' => true, 'reply' => $replyText]);
        }

        // 2. Cek apakah ada sesi yang aktif
        $session = BotSession::where('phone', $from)->first();

        if ($session) {
            $serviceId = $session->service_id;
            $step = $session->step;
            $data = $session->data ?? [];
            
            $questions = $this->getFlowQuestions($serviceId);
            
            // Simpan jawaban dari langkah sebelumnya
            $previousQuestion = $questions[$step - 1];
            $currentKey = $previousQuestion['key'];
            $type = $previousQuestion['type'] ?? 'text';
            
            $answerValue = $message;

            // Validasi Tipe File
            if (in_array($type, ['image', 'document', 'video'])) {
                if (!$request->input('hasMedia')) {
                    $formatMsg = 'File/Gambar/Dokumen';
                    if($type == 'image') $formatMsg = 'Foto/Gambar';
                    if($type == 'document') $formatMsg = 'Dokumen (PDF/Word)';
                    if($type == 'video') $formatMsg = 'Video';
                    
                    return response()->json(['success' => true, 'reply' => "⚠️ *Format Salah*\n\nHarap kirimkan sebuah *$formatMsg* sesuai dengan pertanyaan di atas."]);
                }
                
                // Proses penyimpanan file
                $base64 = $request->input('media');
                $filename = $request->input('filename') ?? ('bot_file_' . time() . '.bin');
                
                // Handle duplicate filenames / extensions
                $extension = '';
                $mimetype = $request->input('mimetype');
                if ($mimetype) {
                    $parts = explode('/', $mimetype);
                    if (count($parts) > 1) {
                        $extension = '.' . explode(';', $parts[1])[0];
                    }
                }
                if (!str_contains($filename, '.')) $filename .= $extension;
                
                $path = 'bot_media/' . uniqid() . '_' . $filename;
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, base64_decode($base64));
                
                // Simpan URL/path sebagai jawaban
                $answerValue = '/storage/' . $path;
            } else {
                // Jika ekspektasi teks tapi dikirim gambar (opsional bisa ditolak, tapi kita terima teks captionnya saja)
                if ($request->input('hasMedia') && empty($message)) {
                     return response()->json(['success' => true, 'reply' => "⚠️ *Format Salah*\n\nHarap ketikkan *Teks/Pesan* untuk membalas, bukan mengirim file."]);
                }
            }
            
            $data[$currentKey] = $answerValue;
            
            // Jika masih ada langkah berikutnya
            if ($step < count($questions)) {
                $nextQuestion = $questions[$step]['question'];
                
                // Update sesi
                $session->step = $step + 1;
                $session->data = $data;
                $session->save();
                
                return response()->json(['success' => true, 'reply' => "Baik. Selanjutnya, " . $nextQuestion]);
            } else {
                // Selesai! Simpan data ke Database
                $ticket = "TIKET-" . rand(10000, 99999);
                
                try {
                    \App\Models\Permohonan::create([
                        'nomor_tiket' => $ticket,
                        'service_id' => $serviceId,
                        'phone' => $from,
                        'data' => $data,
                        'status' => 'open'
                    ]);
                } catch (\Exception $e) { 
                    \Illuminate\Support\Facades\Log::error("Bot Save Error: " . $e->getMessage());
                }
                
                $session->delete();
                
                $replyText = BotSetting::getValue('reply_success');
                $replyText = str_replace('{ticket}', $ticket, $replyText);
                
                return response()->json(['success' => true, 'reply' => "Data Anda lengkap!\n" . $replyText]);
            }
        } else {
            // 3. User TIDAK memiliki sesi. Cek apakah dia memilih kode layanan.
            $layananTarget = \App\Models\Layanan::where('kode', $message)->first();

            if ($layananTarget) {
                $serviceId = $message;
                $questions = $this->getFlowQuestions($serviceId);
                
                if (empty($questions)) {
                    return response()->json(['success' => true, 'reply' => "Layanan belum dikonfigurasi. Silakan hubungi admin."]);
                }
                
                $firstQuestion = $questions[0]['question'];
                
                BotSession::create([
                    'phone' => $from,
                    'service_id' => $serviceId,
                    'step' => 1,
                    'data' => []
                ]);
                
                $serviceName = $layananTarget->nama;
                $replyText = "Anda memilih layanan *" . $serviceName . "*.\n\n" . $firstQuestion . "\n\n_(Ketik *batal* kapan saja untuk membatalkan)_";
                
                return response()->json(['success' => true, 'reply' => $replyText]);
            } else {
                $replyText = BotSetting::getValue('reply_fallback');
                
                // Parse [DAFTAR_LAYANAN] shortcode
                if (str_contains($replyText, '[DAFTAR_LAYANAN]')) {
                    $allLayanan = \App\Models\Layanan::orderBy('kode', 'asc')->get();
                    $listStr = "";
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
                        $listStr .= $emojiKode . " " . $layanan->nama . "\n";
                    }
                    $replyText = str_replace('[DAFTAR_LAYANAN]', trim($listStr), $replyText);
                }

                return response()->json(['success' => true, 'reply' => $replyText]);
            }
        }
    }
}
