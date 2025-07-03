const venom = require("venom-bot");
const mysql = require("mysql2");
const fs = require("fs");
const path = require("path");
require("dotenv").config();
const express = require("express");

const http = require("http");
const { Server } = require("socket.io");

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
  cors: {
    origin: process.env.LARAVEL_URL || "http://localhost:8000", // Ganti dengan URL frontend Laravel Anda
    methods: ["GET", "POST"],
  },
});

app.use(express.json());
const PORT = process.env.NODE_PORT || 3000;

const db = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASS,
  database: process.env.DB_NAME,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
});

const dbPromise = db.promise();

db.getConnection((err, connection) => {
  if (err) {
    console.error("❌ Gagal terhubung ke database:", err);
  } else {
    console.log("✅ Database terhubung.");
    connection.release();
  }
});

let venomClient;

// Endpoint untuk dipanggil Laravel (CS mengirim pesan)
app.post("/kirim-pesan", async (req, res) => {
  const { nomor, pesan } = req.body;
  if (!nomor || !pesan) {
    return res.status(400).json({
      status: "error",
      message: 'Parameter "nomor" dan "pesan" dibutuhkan.',
    });
  }
  if (!venomClient) {
    return res
      .status(503)
      .json({ status: "error", message: "WhatsApp client belum siap." });
  }
  try {
    const formattedNomor = `${nomor}@c.us`;
    await venomClient.sendText(formattedNomor, pesan);
    res
      .status(200)
      .json({ status: "success", message: "Pesan berhasil dikirim." });
  } catch (error) {
    console.error(`❌ Gagal mengirim pesan ke ${nomor}:`, error);
    res
      .status(500)
      .json({ status: "error", message: "Gagal mengirim pesan WhatsApp." });
  }
});

let userState = {};

// Function to send debug error notifications
function sendDebugError(client, user, error) {
  console.error("DEBUG ERROR:", error);
  client.sendText(user, `⚠️ Terjadi error: ${error.message}`);
}

// Function to generate ticket number
function generateNomorTiket(prefix) {
  const now = new Date();
  const datePart = `${now.getFullYear()}${(now.getMonth() + 1)
    .toString()
    .padStart(2, "0")}${now.getDate().toString().padStart(2, "0")}`;
  const randomPart = Math.floor(1000 + Math.random() * 9000);
  return `${prefix}-${datePart}-${randomPart}`;
}

// venom.create({
//   session: "session",
//   multidevice: true,
//   browserArgs: ["--no-sandbox", "--disable-gpu"],
// }).then((client) => start(client))
//   .catch((error) => console.error("Gagal membuat session venom:", error));

venom
  .create({
    session: "session",
    multidevice: true,
    browserArgs: ["--no-sandbox", "--disable-gpu"],
    // ... (sesuaikan puppeteer path jika perlu)
  })
  .then((client) => {
    venomClient = client;
    start(client);

    // MODIFIKASI: Jalankan server utama (termasuk Socket.IO)
    server.listen(PORT, () => {
      console.log(`✅ Server API & WebSocket berjalan di port ${PORT}`);
    });
  })
  .catch((error) => console.error("Gagal membuat session venom:", error));

// BARU: Listener untuk koneksi dari dashboard CS
io.on("connection", (socket) => {
  console.log("✅ Dashboard CS terhubung via WebSocket.");
  socket.on("disconnect", () => {
    console.log(" Dashboard CS terputus.");
  });
});

function start(client) {
  // ==================================================================
  // MODIFIKASI UTAMA: Logika Penerima Pesan
  // ==================================================================
  client.onMessage(async (message) => {
    const user = message.from;
    const text = message.body;

    // Prioritas 1: Jika user sedang dalam proses menu bot, lanjutkan
    if (userState[user]) {
      await handleUserResponse(client, user, message);
      return;
    }

    // Prioritas 2: Cek status chat di database
    try {
      // Cari tiket aduan yang masih open (status=0) dari user ini
      const [rows] = await db.query(
        "SELECT id, chat_status FROM aduan_layanans WHERE user_id = ? AND status = '0' ORDER BY created_at DESC LIMIT 1",
        [user]
      );

      const aduan = rows[0];

      // Jika ada tiket aktif dan statusnya 'live_chat'
      if (aduan && aduan.chat_status === "live_chat") {
        // Simpan pesan user ke tabel chat_messages
        await db.query(
          "INSERT INTO chat_messages (aduan_layanan_id, sender_type, message) VALUES (?, ?, ?)",
          [aduan.id, "user", text]
        );

        // Kirim notifikasi real-time ke dashboard CS
        io.emit("new_message_from_user", {
          aduan_layanan_id: aduan.id,
          sender_type: "user",
          message: text,
          created_at: new Date().toISOString(), // Kirim timestamp juga
        });

        console.log(
          `💬 Pesan live chat dari ${user} disimpan dan diteruskan ke dashboard.`
        );
        return; // Hentikan proses, jangan tampilkan menu bot
      }

      // Jika tidak ada tiket aktif atau statusnya 'automated', jalankan logika bot
      await handleUserResponse(client, user, message);
    } catch (error) {
      console.error("❌ Error di alur utama onMessage:", error);
      sendDebugError(client, user, error);
    }
  });
}

function start(client) {
  // ==================================================================
  // MODIFIKASI UTAMA: Logika Penerima Pesan
  // ==================================================================
  client.onMessage(async (message) => {
    const user = message.from;
    const text = message.body;

    // Prioritas 1: Jika user sedang dalam proses menu bot, lanjutkan
    if (userState[user]) {
      await handleUserResponse(client, user, message);
      return;
    }

    // Prioritas 2: Cek status chat di database
    try {
      // Cari tiket aduan yang masih open (status=0) dari user ini
      const [rows] = await db.query(
        "SELECT id, chat_status FROM aduan_layanans WHERE user_id = ? AND status = '0' ORDER BY created_at DESC LIMIT 1",
        [user]
      );

      const aduan = rows[0];

      // Jika ada tiket aktif dan statusnya 'live_chat'
      if (aduan && aduan.chat_status === "live_chat") {
        // Simpan pesan user ke tabel chat_messages
        await db.query(
          "INSERT INTO chat_messages (aduan_layanan_id, sender_type, message) VALUES (?, ?, ?)",
          [aduan.id, "user", text]
        );

        // Kirim notifikasi real-time ke dashboard CS
        io.emit("new_message_from_user", {
          aduan_layanan_id: aduan.id,
          sender_type: "user",
          message: text,
          created_at: new Date().toISOString(), // Kirim timestamp juga
        });

        console.log(
          `💬 Pesan live chat dari ${user} disimpan dan diteruskan ke dashboard.`
        );
        return; // Hentikan proses, jangan tampilkan menu bot
      }

      // Jika tidak ada tiket aktif atau statusnya 'automated', jalankan logika bot
      await handleUserResponse(client, user, message);
    } catch (error) {
      console.error("❌ Error di alur utama onMessage:", error);
      sendDebugError(client, user, error);
    }
  });
}

function showMainMenu(client, user) {
  const menu = `*HALO!*
Selamat datang di *Layanan Bidang TIK & Persandian Diskominfo Subang*

*Silahkan pilih menu layanan yang Anda butuhkan:*
1️⃣ Aduan Layanan
2️⃣ Permohonan Virtual Meeting
3️⃣ Permohonan VPS
4️⃣ Permohonan BOD
5️⃣ Permohonan Infrastruktur Jaringan Baru
6️⃣ Permohonan Reset Email Dinas
7️⃣ Permohonan Pentest
8️⃣ Penerbitan TTE
9️⃣ Cek Status Tiket

*Catatan:*
🔸 Mohon dijawab dengan mengetik angka saja (contoh: 9)
🔸 Layanan ini dijawab oleh mesin secara otomatis.
🔸 Unduh template formulir permohonan layanan pada link berikut: https://bit.ly/Formulir-Permohonan-Layanan`;
  client.sendText(user, menu);
  resetUserTimeout(client, user);
}

async function handleUserResponse(client, user, message) {
  const step = userState[user].step;
  if (message.body === "0") {
    clearTimeout(userState[user]?.timeout);
    userState[user] = { step: "main_menu" };
    showMainMenu(client, user);
    return;
  }
  // ==================== Menu Utama ====================
  if (step === "main_menu") {
    if (message.body === "1") {
      clearTimeout(userState[user]?.timeout);
      userState[user].step = "collecting_nama_aduan";
      client.sendText(
        user,
        "Anda memilih Aduan Layanan. Silakan sampaikan kendala atau keluhan terkait layanan yang Anda gunakan, agar dapat segera kami tindak lanjuti.\n*(Ketik 0 jika Anda salah memasuki menu)*"
      );
      client.sendText(user, "Silahkan masukan Nama Lengkap Anda:");
      resetUserTimeout(client, user);
    } else if (message.body === "2") {
      clearTimeout(userState[user]?.timeout);
      userState[user].step = "collecting_name_vm";
      askNamaLengkapVM(client, user);
      resetUserTimeout(client, user);
    } else if (message.body === "3") {
      clearTimeout(userState[user]?.timeout);
      userState[user] = { step: "collecting_name_vps", vpsData: {} };
      askNamaLengkapVPS(client, user);
      resetUserTimeout(client, user);
    } else if (message.body === "4") {
      clearTimeout(userState[user]?.timeout);
      userState[user].step = "collecting_nama_lengkap_bod";
      askNamaLengkapBOD(client, user);
      resetUserTimeout(client, user);
    } else if (message.body === "5") {
      clearTimeout(userState[user]?.timeout);
      userState[user].step = "collecting_nama_lengkap_infra";
      askNamaLengkapInfra(client, user);
      resetUserTimeout(client, user);
    } else if (message.body === "6") {
      clearTimeout(userState[user]?.timeout);
      userState[user].step = "collecting_nama_lengkap_reset";
      askNamaLengkapResetEmail(client, user);
      resetUserTimeout(client, user);
    } else if (message.body === "7") {
      clearTimeout(userState[user]?.timeout);
      userState[user].step = "collecting_nama_lengkap_pentest";
      askNamaLengkapPentest(client, user);
      resetUserTimeout(client, user);
    } else if (message.body === "8") {
      clearTimeout(userState[user]?.timeout);
      userState[user].step = "collecting_nama_lengkap_tte";
      askNamaLengkapTTE(client, user);
      resetUserTimeout(client, user);
    } else if (message.body === "9") {
      clearTimeout(userState[user]?.timeout);
      userState[user].step = "cek_status";
      client.sendText(user, "Silahkan masukan Nomor Tiket yang ingin dicek:");
      resetUserTimeout(client, user);
    } else {
      clearTimeout(userState[user]?.timeout);
      client.sendText(user, "Pilihan tidak valid. Silahkan coba lagi.");
      resetUserTimeout(client, user);
    }
  }

  // ==================== Fitur Cek Status ====================
  else if (step === "cek_status") {
    clearTimeout(userState[user]?.timeout);
    const nomorTiket = message.body;
    await checkTicketStatus(client, user, nomorTiket);
    delete userState[user];
  }

  // ==================== Fitur 1: Aduan Layanan ====================
  else if (step === "collecting_nama_aduan") {
    clearTimeout(userState[user]?.timeout);
    userState[user].aduanData = { name: message.body };
    userState[user].step = "collecting_instansi_aduan";
    client.sendText(
      user,
      "Silahkan masukan Nama Instansi atau Organisasi Anda:"
    );
    resetUserTimeout(client, user);
  } else if (step === "collecting_instansi_aduan") {
    clearTimeout(userState[user]?.timeout);
    userState[user].aduanData.instansi = message.body;
    userState[user].step = "collecting_isi_aduan";
    client.sendText(user, "Silahkan masukan detail aduan Anda:");
    resetUserTimeout(client, user);
  } else if (step === "collecting_isi_aduan") {
    clearTimeout(userState[user]?.timeout);
    userState[user].aduanData.isi_aduan = message.body;
    const { name, instansi, isi_aduan } = userState[user].aduanData;
    const nomorTiket = generateNomorTiket("AD");

    db.query(
      "INSERT INTO aduan_layanan (nomor_tiket, user_id, nama_lengkap, instansi, isi_aduan) VALUES (?, ?, ?, ?, ?)",
      [nomorTiket, name, instansi, isi_aduan],
      (err) => {
        if (err) {
          console.error("❌ Gagal menyimpan aduan ke database:", err);
          client.sendText(user, "Terjadi kesalahan saat menyimpan aduan Anda.");
        } else {
          client.sendText(
            user,
            `✅ Aduan Anda telah diterima. Nomor Tiket Anda: ${nomorTiket}\n\n*Catatan:*\n🔸Ketik #menu untuk kembali ke halaman menu.\n🔸Silahkan menunggu, tim akan segera menghubungi Anda untuk status tindak lanjutnya.\n🔸Silahkan pilih opsi 9 pada menu utama untuk cek status tiket.\nTerimakasih🙏`
          );
        }
        delete userState[user];
      }
    );
    // resetUserTimeout(client, user);
  }

  // ==================== Fitur 2: Permohonan Virtual Meeting ====================
  else if (step === "collecting_name_vm") {
    clearTimeout(userState[user]?.timeout);
    userState[user].vmData = { name: message.body };
    userState[user].step = "collecting_instansi";
    askInstansiVM(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_instansi") {
    clearTimeout(userState[user]?.timeout);
    userState[user].vmData.instansi = message.body;
    userState[user].step = "collecting_topik";
    askTopikVM(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_topik") {
    clearTimeout(userState[user]?.timeout);
    userState[user].vmData.topik = message.body;
    userState[user].step = "collecting_waktu";
    askWaktuVM(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_waktu") {
    clearTimeout(userState[user]?.timeout);
    userState[user].vmData.waktu = message.body;
    userState[user].step = "collecting_partisipan";
    askPartisipanVM(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_partisipan") {
    clearTimeout(userState[user]?.timeout);
    userState[user].vmData.partisipan = message.body;
    userState[user].step = "collecting_durasi";
    askDurasiVM(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_durasi") {
    clearTimeout(userState[user]?.timeout);
    userState[user].vmData.durasi = message.body;
    userState[user].step = "collecting_lokasi";
    askLokasiVM(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_lokasi") {
    clearTimeout(userState[user]?.timeout);
    userState[user].vmData.lokasi = message.body || "Virtual";
    userState[user].step = "collecting_link_operator";
    askLinkOperatorVM(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_link_operator") {
    clearTimeout(userState[user]?.timeout);
    userState[user].vmData.link_operator = message.body || "Tidak Ada";
    userState[user].step = "waiting_for_file_vm";
    askUploadFileVM(client, user);
    resetUserTimeout(client, user);
  } else if (step === "waiting_for_file_vm" && message.mimetype && message.id) {
    clearTimeout(userState[user]?.timeout);
    await downloadAndSaveFileVM(client, user, message);
    // resetUserTimeout(client, user);
  }

  // ==================== Fitur 3: Permohonan VPS ====================
  else if (step === "collecting_name_vps") {
    clearTimeout(userState[user]?.timeout);
    userState[user].vpsData.name = message.body;
    userState[user].step = "collecting_instansi_vps";
    askInstansiVps(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_instansi_vps") {
    clearTimeout(userState[user]?.timeout);
    userState[user].vpsData.instansivps = message.body;
    userState[user].step = "collecting_spesifikasi_vps";
    askSpesifikasiVps(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_spesifikasi_vps") {
    clearTimeout(userState[user]?.timeout);
    userState[user].vpsData.spesifikasivps = message.body;
    userState[user].step = "waiting_for_file_vps";
    askUploadFileVps(client, user);
    resetUserTimeout(client, user);
  } else if (
    step === "waiting_for_file_vps" &&
    message.mimetype &&
    message.id
  ) {
    clearTimeout(userState[user]?.timeout);
    await downloadAndSaveFileVps(client, user, message);
    // resetUserTimeout(client, user);
  }

  // ==================== Fitur 4: Permohonan BOD ====================
  else if (step === "collecting_nama_lengkap_bod") {
    clearTimeout(userState[user]?.timeout);
    if (!userState[user].bodData) {
      userState[user].bodData = {};
    }
    userState[user].bodData.namaLengkap = message.body;
    userState[user].step = "collecting_instansi_bod";
    askInstansiBOD(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_instansi_bod") {
    clearTimeout(userState[user]?.timeout);
    userState[user].bodData.instansi = message.body;
    userState[user].step = "collecting_jenis_koneksi_bod";
    askJenisKoneksiBOD(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_jenis_koneksi_bod") {
    clearTimeout(userState[user]?.timeout);
    userState[user].bodData.jenisKoneksi = message.body;
    userState[user].step = "collecting_lokasi_bod";
    askLokasiBOD(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_lokasi_bod") {
    clearTimeout(userState[user]?.timeout);
    userState[user].bodData.lokasi = message.body;
    userState[user].step = "waiting_for_file_bod";
    askUploadSuratBOD(client, user);
    resetUserTimeout(client, user);
  } else if (
    step === "waiting_for_file_bod" &&
    message.mimetype &&
    message.id
  ) {
    clearTimeout(userState[user]?.timeout);
    await downloadAndSaveFileBOD(client, user, message);
    // resetUserTimeout(client, user);
  }

  // ==================== Fitur 5: Permohonan Infrastruktur Jaringan Baru ====================
  else if (step === "collecting_nama_lengkap_infra") {
    clearTimeout(userState[user]?.timeout);
    userState[user].infraData = { namaLengkap: message.body };
    userState[user].step = "collecting_instansi_infra";
    askInstansiInfra(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_instansi_infra") {
    clearTimeout(userState[user]?.timeout);
    userState[user].infraData.instansi = message.body;
    userState[user].step = "collecting_jenis_koneksi_infra";
    askJenisKoneksiInfra(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_jenis_koneksi_infra") {
    clearTimeout(userState[user]?.timeout);
    userState[user].infraData.jenisKoneksi = message.body;
    userState[user].step = "collecting_lokasi_infra";
    askLokasiInfra(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_lokasi_infra") {
    clearTimeout(userState[user]?.timeout);
    userState[user].infraData.lokasi = message.body;
    userState[user].step = "waiting_for_file_infra";
    askUploadSuratInfra(client, user);
    resetUserTimeout(client, user);
  } else if (
    step === "waiting_for_file_infra" &&
    message.mimetype &&
    message.id
  ) {
    clearTimeout(userState[user]?.timeout);
    await downloadAndSaveFileInfra(client, user, message);
    // resetUserTimeout(client, user);
  }

  // ==================== Fitur 6: Permohonan Reset Email Dinas ====================
  else if (step === "collecting_nama_lengkap_reset") {
    clearTimeout(userState[user]?.timeout);
    userState[user].resetEmailData = { namaLengkap: message.body };
    userState[user].step = "collecting_instansi_reset";
    askInstansiResetEmail(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_instansi_reset") {
    clearTimeout(userState[user]?.timeout);
    userState[user].resetEmailData.instansi = message.body;
    userState[user].step = "collecting_email_reset";
    askAlamatEmailResetEmail(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_email_reset") {
    clearTimeout(userState[user]?.timeout);
    userState[user].resetEmailData.emailDinas = message.body;
    userState[user].step = "waiting_for_file_reset";
    askUploadSuratResetEmail(client, user);
    resetUserTimeout(client, user);
  } else if (
    step === "waiting_for_file_reset" &&
    message.mimetype &&
    message.id
  ) {
    clearTimeout(userState[user]?.timeout);
    await downloadAndSaveFileResetEmail(client, user, message);
    // resetUserTimeout(client, user);
  }

  // ==================== Fitur 7: Permohonan Pentest ====================
  else if (step === "collecting_nama_lengkap_pentest") {
    clearTimeout(userState[user]?.timeout);
    userState[user].pentestData = { namaLengkap: message.body };
    userState[user].step = "collecting_instansi_pentest";
    askInstansiPentest(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_instansi_pentest") {
    clearTimeout(userState[user]?.timeout);
    userState[user].pentestData.instansi = message.body;
    userState[user].step = "collecting_nama_aplikasi_pentest";
    askNamaAplikasiPentest(client, user);
    resetUserTimeout(client, user);
  } else if (step === "collecting_nama_aplikasi_pentest") {
    clearTimeout(userState[user]?.timeout);
    userState[user].pentestData.namaAplikasi = message.body;
    userState[user].step = "waiting_for_file_pentest";
    askUploadSuratPentest(client, user);
    resetUserTimeout(client, user);
  } else if (
    step === "waiting_for_file_pentest" &&
    message.mimetype &&
    message.id
  ) {
    clearTimeout(userState[user]?.timeout);
    await downloadAndSaveFilePentest(client, user, message);
    // resetUserTimeout(client, user);
  }

  // ==================== Fitur 8: Penerbitan TTE ====================
  else if (step === "collecting_nama_lengkap_tte") {
    clearTimeout(userState[user]?.timeout);
    userState[user].tteData = { namaLengkap: message.body };
    // userState[user].step = "collecting_instansi_tte";
    // askInstansiTTE(client, user);
    resetUserTimeout(client, user);
  }
  // else if (step === "collecting_instansi_tte") {
  //   clearTimeout(userState[user]?.timeout);
  //   userState[user].tteData.instansi = message.body;
  //   userState[user].step = "collecting_email_tte";
  //   askEmailDinasTTE(client, user);
  //   resetUserTimeout(client, user);
  // } else if (step === "collecting_email_tte") {
  //   clearTimeout(userState[user]?.timeout);
  //   userState[user].tteData.emailDinas = message.body;
  //   const nomorTiket = generateNomorTiket("TTE");
  //   const { namaLengkap, instansi, emailDinas } = userState[user].tteData;
  //   db.query(
  //     "INSERT INTO penerbitan_tte (nomor_tiket, user_id, nama_lengkap, instansi, email_dinas) VALUES (?, ?, ?, ?, ?)",
  //     [nomorTiket, user, namaLengkap, instansi, emailDinas],
  //     (err) => {
  //       if (err) {
  //         console.error("❌ Gagal menyimpan data TTE ke database:", err);
  //         client.sendText(user, "Terjadi kesalahan saat menyimpan data.");
  //       } else {
  //         client.sendText(user, `✅ Permohonan penerbitan TTE berhasil disimpan. Nomor tiket Anda adalah: ${nomorTiket}\n\n*Catatan:*\n🔸Ketik #menu untuk kembali ke halaman menu.\n🔸Silahkan menunggu, tim akan segera menghubungi Anda untuk status tindak lanjutnya.\n🔸Silahkan pilih opsi 9 pada menu utama untuk cek status tiket.\nTerimakasih🙏`);
  //       }
  //       delete userState[user];
  //     }
  //   );
  //   // resetUserTimeout(client, user);
  // }
}

// [All the supporting functions remain the same...]
// ... (All askNamaLengkap*, downloadAndSaveFile*, etc functions remain the same)

// ==================== Fitur Virtual Meeting ====================
function askNamaLengkapVM(client, user) {
  client.sendText(
    user,
    "Anda memilih Permohonan Virtual Meeting. Silakan ajukan permintaan untuk pembuatan sesi virtual meeting beserta jadwal dan kebutuhan teknisnya berikan penjelasan apakah hanya link atau beserta operator.\n*(Ketik 0 jika Anda salah memasuki menu)*"
  );
  client.sendText(user, "Silahkan masukan Nama Lengkap Anda:");
}
function askInstansiVM(client, user) {
  client.sendText(user, "Silahkan masukan Nama Instansi atau Organisasi Anda:");
}
function askTopikVM(client, user) {
  client.sendText(user, "Silahkan masukan Topik Meeting:");
}
function askWaktuVM(client, user) {
  client.sendText(
    user,
    "Silahkan masukan Waktu Pelaksanaan (format: YYYY-MM-DD HH:MM):"
  );
}
function askPartisipanVM(client, user) {
  client.sendText(user, "Silahkan masukan Jumlah Partisipan:");
}
function askDurasiVM(client, user) {
  client.sendText(
    user,
    "Silahkan masukan Estimasi Durasi Meeting (dalam menit):"
  );
}
function askLokasiVM(client, user) {
  client.sendText(
    user,
    "Silahkan masukan Lokasi Meeting (atau ketik 'Virtual' jika online):"
  );
}
function askLinkOperatorVM(client, user) {
  client.sendText(
    user,
    "Jika ada, masukan Link Operator (Opsional). Jika tidak, ketik 'Tidak Ada':"
  );
}
function askUploadFileVM(client, user) {
  client.sendText(user, "Silahkan upload dokumen surat permohonan (PDF)");
}
async function downloadAndSaveFileVM(client, user, message) {
  const nomorTiket2 = generateNomorTiket("VM");
  try {
    const mediaData = await client.downloadMedia(message.id);
    if (!mediaData) {
      client.sendText(user, "❗ Gagal mengunduh file.");
      return;
    }
    const base64Data = mediaData.includes(";base64,")
      ? mediaData.split(";base64,").pop()
      : mediaData;
    const fileBuffer = Buffer.from(base64Data, "base64");
    const fileExtension = message.mimetype.split("/")[1] || "bin";
    const fileName = `${Date.now()}-${user}.${fileExtension}`;
    const filePath = path.join(__dirname, "uploads", fileName);
    fs.writeFileSync(filePath, fileBuffer);
    console.log("✅ File berhasil disimpan:", filePath);
    if (fs.statSync(filePath).size === 0)
      throw new Error("File kosong setelah disimpan.");

    db.query(
      "INSERT INTO permohonan_virtual_meeting (nomor_tiket, user_id, nama_lengkap, instansi, topik_meeting, waktu_pelaksanaan, jumlah_partisipan, durasi_meeting, lokasi_meeting, link_operator, surat_permohonan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
      [
        nomorTiket2,
        user,
        userState[user].vmData.name,
        userState[user].vmData.instansi,
        userState[user].vmData.topik,
        userState[user].vmData.waktu,
        userState[user].vmData.partisipan,
        userState[user].vmData.durasi,
        userState[user].vmData.lokasi,
        userState[user].vmData.link_operator,
        filePath,
      ],
      (err) => {
        if (err) {
          console.error(
            "❌ Gagal menyimpan data Virtual Meeting ke database:",
            err
          );
          client.sendText(user, "Terjadi kesalahan saat menyimpan data.");
        } else {
          client.sendText(
            user,
            `✅ Permohonan Virtual Meeting berhasil disimpan. Nomor tiket Anda adalah: ${nomorTiket2}\n\n*Catatan:*\n🔸Ketik #menu untuk kembali ke halaman menu.\n🔸Silahkan menunggu, tim akan segera menghubungi Anda untuk status tindak lanjutnya.\n🔸Silahkan pilih opsi 9 pada menu utama untuk cek status tiket.\nTerimakasih🙏`
          );
          delete userState[user];
        }
      }
    );
  } catch (error) {
    console.error("❌ Error saat upload file VM:", error);
    client.sendText(
      user,
      `⚠️ Terjadi kesalahan saat upload file. Nomor tiket percobaan: ${nomorTiket2}`
    );
  }
}

// ==================== Fitur VPS ====================
function askNamaLengkapVPS(client, user) {
  client.sendText(
    user,
    "Anda memilih Permohonan VPS. Silakan lengkapi informasi terkait kebutuhan server virtual Anda, seperti spesifikasi (vCpu,vRam,Storage), dan lama pemakaian.\n*(Ketik 0 jika Anda salah memasuki menu)*"
  );
  client.sendText(user, "Silahkan isi Nama Lengkap:");
}
function askInstansiVps(client, user) {
  client.sendText(user, "Silahkan masukan Nama Instansi Anda:");
}
function askSpesifikasiVps(client, user) {
  client.sendText(user, "Silahkan masukan spesifikasi VPS:");
}
function askUploadFileVps(client, user) {
  client.sendText(user, "Silahkan upload dokumen surat permohonan (PDF)");
}

async function downloadAndSaveFileVps(client, user, message) {
  const nomorTiket3 = generateNomorTiket("VPS");
  try {
    const mediaData = await client.downloadMedia(message.id);
    if (!mediaData) {
      client.sendText(user, "❗ Gagal mengunduh file.");
      return;
    }
    const base64Data = mediaData.includes(";base64,")
      ? mediaData.split(";base64,").pop()
      : mediaData;
    const fileBuffer = Buffer.from(base64Data, "base64");
    const fileExtension = message.mimetype.split("/")[1] || "bin";
    const fileName = `${Date.now()}-${user}.${fileExtension}`;
    const filePath = path.join(__dirname, "uploads", fileName);
    fs.writeFileSync(filePath, fileBuffer);
    console.log("✅ File berhasil disimpan:", filePath);
    if (fs.statSync(filePath).size === 0)
      throw new Error("File kosong setelah disimpan.");

    db.query(
      "INSERT INTO permohonan_vps (nomor_tiket, user_id, nama_lengkap, instansi, spesifikasi, surat_permohonan) VALUES (?, ?, ?, ?, ?, ?)",
      [
        nomorTiket3,
        user,
        userState[user].vpsData.name,
        userState[user].vpsData.instansivps,
        userState[user].vpsData.spesifikasivps,
        filePath,
      ],
      (err) => {
        if (err) {
          console.error("❌ Gagal menyimpan data VPS ke database:", err);
          client.sendText(user, "Terjadi kesalahan saat menyimpan data.");
        } else {
          client.sendText(
            user,
            `✅ Permohonan VPS berhasil disimpan. Nomor tiket Anda adalah: ${nomorTiket3}\n\n*Catatan:*\n🔸Ketik #menu untuk kembali ke halaman menu.\n🔸Silahkan menunggu, tim akan segera menghubungi Anda untuk status tindak lanjutnya.\n🔸Silahkan pilih opsi 9 pada menu utama untuk cek status tiket.\nTerimakasih🙏`
          );
          delete userState[user];
        }
      }
    );
  } catch (error) {
    console.error("❌ Error saat upload file VPS:", error);
    client.sendText(
      user,
      `⚠️ Terjadi kesalahan saat upload file. Nomor tiket percobaan: ${nomorTiket3}`
    );
  }
}

// ==================== Fitur BOD ====================
function askTanggalBOD(client, user) {
  client.sendText(user, "Silahkan masukan Tanggal (format: YYYY-MM-DD):");
}
function askNamaLengkapBOD(client, user) {
  client.sendText(
    user,
    "Anda memilih Permohonan BOD. Silakan jelaskan lokasi yang diperlukan perbantuan layanan internet, apakah sudah ada internet Diskominfo sebelumnya atau belum ada sama sekali.\n*(Ketik 0 jika Anda salah memasuki menu)*"
  );
  client.sendText(user, "Silahkan masukan Nama Lengkap Anda:");
}
function askInstansiBOD(client, user) {
  client.sendText(user, "Silahkan masukan Nama Instansi/OPD:");
}
function askJenisKoneksiBOD(client, user) {
  client.sendText(user, "Silahkan masukan Jenis Koneksi & Peruntukan:");
}
function askLokasiBOD(client, user) {
  client.sendText(user, "Silahkan masukan Lokasi dan Waktu:");
}
function askUploadSuratBOD(client, user) {
  client.sendText(user, "Silahkan upload dokumen surat permohonan (PDF)");
}
async function downloadAndSaveFileBOD(client, user, message) {
  const nomorTiketBOD = generateNomorTiket("BOD");
  try {
    const mediaData = await client.downloadMedia(message.id);
    if (!mediaData) {
      client.sendText(user, "❗ Gagal mengunduh file.");
      return;
    }
    const base64Data = mediaData.includes(";base64,")
      ? mediaData.split(";base64,").pop()
      : mediaData;
    const fileBuffer = Buffer.from(base64Data, "base64");
    const fileExtension = message.mimetype.split("/")[1] || "bin";
    const fileName = `${Date.now()}-${user}.${fileExtension}`;
    const filePath = path.join(__dirname, "uploads", fileName);
    fs.writeFileSync(filePath, fileBuffer);
    console.log("✅ File berhasil disimpan:", filePath);
    if (fs.statSync(filePath).size === 0)
      throw new Error("File kosong setelah disimpan.");

    const { namaLengkap, instansi, jenisKoneksi, lokasi } =
      userState[user].bodData;
    db.query(
      "INSERT INTO permohonan_bod (nomor_tiket, user_id, nama_lengkap, instansi, jenis_koneksi_peruntukan, lokasi, surat_permohonan) VALUES (?, ?, ?, ?, ?, ?, ?)",
      [
        nomorTiketBOD,
        user,
        namaLengkap,
        instansi,
        jenisKoneksi,
        lokasi,
        filePath,
      ],
      (err) => {
        if (err) {
          console.error("❌ Gagal menyimpan data BOD ke database:", err);
          client.sendText(user, "Terjadi kesalahan saat menyimpan data.");
        } else {
          client.sendText(
            user,
            `✅ Permohonan BOD berhasil disimpan. Nomor tiket Anda adalah: ${nomorTiketBOD}\n\n*Catatan:*\n🔸Ketik #menu untuk kembali ke halaman menu.\n🔸Silahkan menunggu, tim akan segera menghubungi Anda untuk status tindak lanjutnya.\n🔸Silahkan pilih opsi 9 pada menu utama untuk cek status tiket.\nTerimakasih🙏`
          );
          delete userState[user];
        }
      }
    );
  } catch (error) {
    console.error("❌ Error saat upload file BOD:", error);
    client.sendText(
      user,
      `⚠️ Terjadi kesalahan saat upload file. Nomor tiket percobaan: ${nomorTiketBOD}`
    );
  }
}

// ==================== Fitur Infrastruktur Jaringan Baru ====================
function askNamaLengkapInfra(client, user) {
  client.sendText(
    user,
    "Anda memilih Permohonan Infrastruktur Jaringan Baru. Silakan jelaskan kebutuhan instalasi jaringan baru apakah Fiber Optik atau LAN, lokasi, serta spesifikasi teknis yang diinginkan.\n*(Ketik 0 jika Anda salah memasuki menu)*"
  );
  client.sendText(user, "Silahkan masukan Nama Lengkap Anda:");
}
function askInstansiInfra(client, user) {
  client.sendText(user, "Silahkan masukan Nama Instansi/OPD:");
}
function askJenisKoneksiInfra(client, user) {
  client.sendText(user, "Silahkan masukan Jenis Koneksi:");
}
function askLokasiInfra(client, user) {
  client.sendText(user, "Silahkan masukan Lokasi:");
}
function askUploadSuratInfra(client, user) {
  client.sendText(user, "Silahkan upload dokumen surat permohonan (PDF)");
}

async function downloadAndSaveFileInfra(client, user, message) {
  const nomorTiketInfra = generateNomorTiket("INFRA");
  try {
    const mediaData = await client.downloadMedia(message.id);
    if (!mediaData) {
      client.sendText(user, "❗ Gagal mengunduh file.");
      return;
    }
    const base64Data = mediaData.includes(";base64,")
      ? mediaData.split(";base64,").pop()
      : mediaData;
    const fileBuffer = Buffer.from(base64Data, "base64");
    const fileExtension = message.mimetype.split("/")[1] || "bin";
    const fileName = `${Date.now()}-${user}.${fileExtension}`;
    const filePath = path.join(__dirname, "uploads", fileName);
    fs.writeFileSync(filePath, fileBuffer);
    console.log("✅ File berhasil disimpan:", filePath);
    if (fs.statSync(filePath).size === 0)
      throw new Error("File kosong setelah disimpan.");

    const { namaLengkap, instansi, jenisKoneksi, lokasi } =
      userState[user].infraData;
    db.query(
      "INSERT INTO permohonan_infrastruktur (nomor_tiket, user_id, nama_lengkap, instansi, jenis_koneksi, lokasi, surat_permohonan) VALUES (?, ?, ?, ?, ?, ?, ?)",
      [
        nomorTiketInfra,
        user,
        namaLengkap,
        instansi,
        jenisKoneksi,
        lokasi,
        filePath,
      ],
      (err) => {
        if (err) {
          console.error(
            "❌ Gagal menyimpan data Infrastruktur ke database:",
            err
          );
          client.sendText(user, "Terjadi kesalahan saat menyimpan data.");
        } else {
          client.sendText(
            user,
            `✅ Permohonan Infrastruktur Jaringan Baru berhasil disimpan. Nomor tiket Anda adalah: ${nomorTiketInfra}\n\n*Catatan:*\n🔸Ketik #menu untuk kembali ke halaman menu.\n🔸Silahkan menunggu, tim akan segera menghubungi Anda untuk status tindak lanjutnya.\n🔸Silahkan pilih opsi 9 pada menu utama untuk cek status tiket.\nTerimakasih🙏`
          );
          delete userState[user];
        }
      }
    );
  } catch (error) {
    console.error("❌ Error saat upload file Infra:", error);
    client.sendText(
      user,
      `⚠️ Terjadi kesalahan saat upload file. Nomor tiket percobaan: ${nomorTiketInfra}`
    );
  }
}

// ==================== Fitur Reset Email Dinas ====================
function askNamaLengkapResetEmail(client, user) {
  client.sendText(
    user,
    "Anda memilih Permohonan Reset Email Dinas. Silakan berikan informasi akun email dinas yang perlu di-reset untuk memproses permintaan Anda.\n*(Ketik 0 jika Anda salah memasuki menu)*"
  );
  client.sendText(user, "Silahkan masukan Nama Lengkap Anda:");
}
function askInstansiResetEmail(client, user) {
  client.sendText(user, "Silahkan masukan Nama Instansi/OPD:");
}
function askAlamatEmailResetEmail(client, user) {
  client.sendText(user, "Silahkan masukan Alamat Email Dinas:");
}
function askUploadSuratResetEmail(client, user) {
  client.sendText(user, "Silahkan upload dokumen surat permohonan (PDF)");
}

async function downloadAndSaveFileResetEmail(client, user, message) {
  const nomorTiketReset = generateNomorTiket("RESET");
  try {
    const mediaData = await client.downloadMedia(message.id);
    if (!mediaData) {
      client.sendText(user, "❗ Gagal mengunduh file.");
      return;
    }
    const base64Data = mediaData.includes(";base64,")
      ? mediaData.split(";base64,").pop()
      : mediaData;
    const fileBuffer = Buffer.from(base64Data, "base64");
    const fileExtension = message.mimetype.split("/")[1] || "bin";
    const fileName = `${Date.now()}-${user}.${fileExtension}`;
    const filePath = path.join(__dirname, "uploads", fileName);
    fs.writeFileSync(filePath, fileBuffer);
    console.log("✅ File berhasil disimpan:", filePath);
    if (fs.statSync(filePath).size === 0)
      throw new Error("File kosong setelah disimpan.");

    const { namaLengkap, instansi, emailDinas } =
      userState[user].resetEmailData;
    db.query(
      "INSERT INTO permohonan_reset_email (nomor_tiket, user_id, nama_lengkap, instansi, email_dinas, surat_permohonan) VALUES (?, ?, ?, ?, ?, ?)",
      [nomorTiketReset, user, namaLengkap, instansi, emailDinas, filePath],
      (err) => {
        if (err) {
          console.error(
            "❌ Gagal menyimpan data Reset Email ke database:",
            err
          );
          client.sendText(user, "Terjadi kesalahan saat menyimpan data.");
        } else {
          client.sendText(
            user,
            `✅ Permohonan Reset Email Dinas berhasil disimpan. Nomor tiket Anda adalah: ${nomorTiketReset}\n\n*Catatan:*\n🔸Ketik #menu untuk kembali ke halaman menu.\n🔸Silahkan menunggu, tim akan segera menghubungi Anda untuk status tindak lanjutnya.\n🔸Silahkan pilih opsi 9 pada menu utama untuk cek status tiket.\nTerimakasih🙏`
          );
          delete userState[user];
        }
      }
    );
  } catch (error) {
    console.error("❌ Error saat upload file Reset Email:", error);
    client.sendText(
      user,
      `⚠️ Terjadi kesalahan saat upload file. Nomor tiket percobaan: ${nomorTiketReset}`
    );
  }
}

// ==================== Fitur Pentest ====================
function askNamaLengkapPentest(client, user) {
  client.sendText(
    user,
    "Anda memilih Permohonan Pentest. Silakan sampaikan permohonan pengujian keamanan sistem (penetration test) beserta detail aplikasi atau sistem yang akan diuji.\n*(Ketik 0 jika Anda salah memasuki menu)*"
  );
  client.sendText(user, "Silahkan masukan Nama Lengkap Anda:");
}
function askInstansiPentest(client, user) {
  client.sendText(user, "Silahkan masukan Nama Instansi/OPD:");
}
function askNamaAplikasiPentest(client, user) {
  client.sendText(user, "Silahkan masukan Nama Aplikasi:");
}
function askUploadSuratPentest(client, user) {
  client.sendText(user, "Silahkan upload dokumen surat permohonan (PDF)");
}

async function downloadAndSaveFilePentest(client, user, message) {
  const nomorTiketPentest = generateNomorTiket("PENTEST");
  try {
    const mediaData = await client.downloadMedia(message.id);
    if (!mediaData) {
      client.sendText(user, "❗ Gagal mengunduh file.");
      return;
    }
    const base64Data = mediaData.includes(";base64,")
      ? mediaData.split(";base64,").pop()
      : mediaData;
    const fileBuffer = Buffer.from(base64Data, "base64");
    const fileExtension = message.mimetype.split("/")[1] || "bin";
    const fileName = `${Date.now()}-${user}.${fileExtension}`;
    const filePath = path.join(__dirname, "uploads", fileName);
    fs.writeFileSync(filePath, fileBuffer);
    console.log("✅ File berhasil disimpan:", filePath);
    if (fs.statSync(filePath).size === 0)
      throw new Error("File kosong setelah disimpan.");

    const { namaLengkap, instansi, namaAplikasi } = userState[user].pentestData;
    db.query(
      "INSERT INTO permohonan_pentest (nomor_tiket, user_id, nama_lengkap, instansi, nama_aplikasi, surat_permohonan) VALUES (?, ?, ?, ?, ?, ?)",
      [nomorTiketPentest, user, namaLengkap, instansi, namaAplikasi, filePath],
      (err) => {
        if (err) {
          console.error("❌ Gagal menyimpan data Pentest ke database:", err);
          client.sendText(user, "Terjadi kesalahan saat menyimpan data.");
        } else {
          client.sendText(
            user,
            `✅ Permohonan Pentest berhasil disimpan. Nomor tiket Anda adalah: ${nomorTiketPentest}\n\n*Catatan:*\n🔸Ketik #menu untuk kembali ke halaman menu.\n🔸Silahkan menunggu, tim akan segera menghubungi Anda untuk status tindak lanjutnya.\n🔸Silahkan pilih opsi 9 pada menu utama untuk cek status tiket.\nTerimakasih🙏`
          );
          delete userState[user];
        }
      }
    );
  } catch (error) {
    console.error("❌ Error saat upload file Pentest:", error);
    client.sendText(
      user,
      `⚠️ Terjadi kesalahan saat upload file. Nomor tiket percobaan: ${nomorTiketPentest}`
    );
  }
}

// ==================== Fungsi Cek Status ====================
async function checkTicketStatus(client, user, nomorTiket) {
  try {
    console.log("🔍 Memeriksa tiket:", nomorTiket);
    const [rows] = await dbPromise.query(
      "SELECT nomor_tiket, jenis_layanan, status FROM view_semua_nomor_tiket WHERE nomor_tiket = ? LIMIT 1",
      [nomorTiket]
    );
    console.log("📦 Hasil query:", rows);

    if (rows.length === 0) {
      await client.sendText(
        user,
        `❌ Nomor Tiket *${nomorTiket}* tidak ditemukan, silahkan buat laporan terlebih dahulu.`
      );
      return;
    }

    const tiket = rows[0];

    // Mapping jenis layanan (jika ingin lebih rapi)
    const serviceNames = {
      aduan_layanan: "Aduan Layanan",
      permohonan_virtual_meeting: "Virtual Meeting",
      permohonan_vps: "Permohonan VPS",
      permohonan_bod: "Permohonan BOD",
      permohonan_infrastruktur: "Infrastruktur Jaringan",
      permohonan_reset_email: "Reset Email Dinas",
      permohonan_pentest: "Permohonan Pentest",
      penerbitan_tte: "Penerbitan TTE",
    };

    const statusStr = tiket.status == 1 ? "✅ Selesai" : "⏳ Masih Diproses";

    const message =
      `📋 *LAPORAN STATUS TIKET*\n\n` +
      `🆔 Nomor Tiket: ${tiket.nomor_tiket}\n` +
      `📮 Jenis Layanan: ${
        serviceNames[tiket.jenis_layanan] || tiket.jenis_layanan
      }\n` +
      `🔄 Status: ${statusStr}\n\n` +
      `ℹ️ Untuk pertanyaan lebih lanjut, hubungi admin.` +
      `ℹ️ Ketik #menu untuk kembali ke bagian menu.`;

    await client.sendText(user, message);
  } catch (err) {
    console.error("❌ Gagal cek status tiket:", err);
    await client.sendText(
      user,
      `⚠️ Terjadi kesalahan saat cek tiket: ${err.message}`
    );
  }
}

// Fitur auto akhiri sesi
function resetUserTimeout(client, user) {
  if (userState[user]?.timeout) {
    clearTimeout(userState[user].timeout);
  }

  userState[user].timeout = setTimeout(() => {
    client.sendText(
      user,
      "⏰ Sesi Anda telah berakhir karena tidak ada respon selama 5 menit. Silahkan mulai kembali dengan mengetik #menu."
    );
    delete userState[user];
  }, 300000); // 5 menit
}

// ==================== Fitur Penerbitan TTE ====================
function askNamaLengkapTTE(client, user) {
  client.sendText(
    user,
    "Anda memilih Penerbitan TTE. Silakan lengkapi data yang diperlukan untuk proses penerbitan Tanda Tangan Elektronik (TTE) Anda.\n*(Ketik 0 jika Anda salah memasuki menu)*"
  );
  client.sendText(
    user,
    "Silahkan lengkapi data yang diperluka di form ini: s.id/layanan-sandi"
  );
}
function askInstansiTTE(client, user) {
  client.sendText(user, "Silahkan masukan Nama Instansi/OPD:");
}
function askEmailDinasTTE(client, user) {
  client.sendText(user, "Silahkan masukan Alamat Email Dinas:");
}
