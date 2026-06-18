const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const express = require('express');
const axios = require('axios');
require('dotenv').config();

const app = express();
app.use(express.json());

const PORT = process.env.PORT || 3000;
const LARAVEL_API_URL = process.env.LARAVEL_API_URL || 'http://localhost:8000/api/bot/webhook';

// Inisialisasi WhatsApp Client
const client = new Client({
    authStrategy: new LocalAuth(),
    puppeteer: {
        args: ['--no-sandbox', '--disable-setuid-sandbox'],
    }
});

let botState = {
    status: 'DISCONNECTED',
    qr: null,
    phone: null
};

client.on('qr', (qr) => {
    console.log('SCAN QR CODE INI MENGGUNAKAN WHATSAPP ANDA:');
    qrcode.generate(qr, { small: true });
    botState.qr = qr;
    botState.status = 'AWAITING_SCAN';
    botState.phone = null;
});

client.on('ready', () => {
    console.log('✅ WhatsApp Bot is Ready and Connected!');
    botState.status = 'CONNECTED';
    botState.qr = null;
    botState.phone = client.info && client.info.wid ? client.info.wid.user : null;
});

client.on('disconnected', (reason) => {
    console.log('❌ WhatsApp Disconnected:', reason);
    botState.status = 'DISCONNECTED';
    botState.qr = null;
    botState.phone = null;
});

client.on('message', async (message) => {
    // Abaikan pesan status atau dari grup (jika hotline hanya private)
    if (message.isStatus || message.author) return;

    console.log(`Pesan masuk dari ${message.from}: ${message.body} (hasMedia: ${message.hasMedia})`);

    let base64Media = null;
    let mimetype = null;
    let filename = null;

    if (message.hasMedia) {
        try {
            const media = await message.downloadMedia();
            if (media) {
                base64Media = media.data;
                mimetype = media.mimetype;
                filename = media.filename || ('media_' + Date.now());
            }
        } catch (err) {
            console.error('Gagal mengunduh media:', err.message);
        }
    }

    try {
        // Teruskan pesan ke Webhook Laravel
        const response = await axios.post(LARAVEL_API_URL, {
            from: message.from,
            name: message._data?.notifyName || 'User',
            body: message.body,
            hasMedia: message.hasMedia,
            media: base64Media,
            mimetype: mimetype,
            filename: filename,
            timestamp: message.timestamp
        }, {
            maxContentLength: Infinity,
            maxBodyLength: Infinity
        });

        // Jika Laravel merespon dengan pesan teks, kirim kembali ke user
        if (response.data && response.data.reply) {
            client.sendMessage(message.from, response.data.reply);
        }
    } catch (error) {
        console.error('Error saat meneruskan pesan ke Laravel:', error.message);
    }
});

client.initialize();

// Endpoint Express untuk menerima perintah kirim pesan dari Laravel (Opsional/Tahap selanjutnya)
app.post('/api/send', async (req, res) => {
    const { to, message } = req.body;
    if (!to || !message) {
        return res.status(400).json({ error: 'Parameter "to" dan "message" wajib diisi.' });
    }

    try {
        await client.sendMessage(to, message);
        res.json({ success: true, message: 'Pesan berhasil dikirim.' });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

app.get('/api/status', (req, res) => {
    res.json(botState);
});

app.post('/api/logout', async (req, res) => {
    try {
        await client.logout();
        botState.status = 'DISCONNECTED';
        botState.qr = null;
        botState.phone = null;
        
        // Inisialisasi ulang agar QR code baru bisa di-generate
        setTimeout(() => {
            client.initialize();
        }, 2000);
        
        res.json({ success: true, message: 'Bot berhasil logout.' });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

app.listen(PORT, () => {
    console.log(`🤖 Node.js Bot Service berjalan di http://localhost:${PORT}`);
});
