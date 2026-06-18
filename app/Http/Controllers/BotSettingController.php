<?php

namespace App\Http\Controllers;

use App\Models\BotSetting;
use Illuminate\Http\Request;

class BotSettingController extends Controller
{
    public function index()
    {
        $settings = BotSetting::all();
        $botState = [
            'status' => 'OFFLINE',
            'qr' => null,
            'phone' => null
        ];

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(3)->get('http://localhost:3000/api/status');
            if ($response->successful()) {
                $botState = $response->json();
            }
        } catch (\Exception $e) {
            // Node.js service is probably down
        }

        return view('Admin.bot-settings', compact('settings', 'botState'));
    }

    public function logoutBot()
    {
        try {
            \Illuminate\Support\Facades\Http::post('http://localhost:3000/api/logout');
            return redirect()->back()->with('success', 'Bot berhasil diputus. Memuat ulang QR Code...');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memutus bot. Pastikan service Node.js berjalan.');
        }
    }

    public function update(Request $request)
    {
        // $request->settings is an array of [id => value]
        // or [id => [ array of questions ]]
        if ($request->has('settings')) {
            foreach ($request->settings as $id => $value) {
                $setting = BotSetting::find($id);
                if ($setting) {
                    if (is_array($value)) {
                        // Jika value berbentuk array (dari dynamic form builder JSON)
                        // Pastikan index ter-reset (mengabaikan kunci yg mungkin acak karena JS)
                        $cleanArray = array_values($value);
                        $setting->value = json_encode($cleanArray);
                    } else {
                        // Value text biasa
                        $setting->value = $value;
                    }
                    $setting->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Pengaturan bot berhasil diperbarui!');
    }
}
