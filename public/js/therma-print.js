/**
 * Thermal Printer Class untuk BP-ECO58
 * ENHANCED VERSION - Compatible dengan Android Tablet
 * Dengan deteksi browser, fallback, dan troubleshooting guide
 */
class ThermalPrinter {
    constructor() {
        this.device = null;
        this.characteristic = null;
        this.encoder = new TextEncoder();
        this.isConnecting = false;
        this.restorePromise = null;
        this.browserSupport = this.checkBrowserSupport();

        // ESC/POS Commands
        this.ESC = '\x1B';
        this.GS = '\x1D';
        this.CMD = {
            INIT: '\x1B\x40',
            ALIGN_LEFT: '\x1B\x61\x00',
            ALIGN_CENTER: '\x1B\x61\x01',
            ALIGN_RIGHT: '\x1B\x61\x02',
            FONT_NORMAL: '\x1B\x21\x00',
            FONT_BOLD: '\x1B\x21\x08',
            FONT_LARGE: '\x1B\x21\x30',
            FONT_MEDIUM: '\x1B\x21\x10',
            CUT: '\x1D\x56\x00',
            FEED: '\x1B\x64\x02',
            LINE: '\n',
        };

        // Setup
        this.setupDisconnectHandler();
        this.restorePromise = this.loadSavedDevice();
        this.userGestureListenerAttached = false;

        // Show browser compatibility warning
        this.showBrowserWarningIfNeeded();
    }

    /**
     * ✅ BARU - Check browser support untuk Web Bluetooth
     */
    checkBrowserSupport() {
        const result = {
            bluetooth: false,
            https: false,
            browser: 'Unknown',
            os: 'Unknown',
            supported: false,
            issues: []
        };

        // Detect browser
        const ua = navigator.userAgent;
        if (ua.indexOf('Chrome') > -1 && ua.indexOf('Edg') === -1) {
            result.browser = 'Chrome';
        } else if (ua.indexOf('Safari') > -1 && ua.indexOf('Chrome') === -1) {
            result.browser = 'Safari';
        } else if (ua.indexOf('Firefox') > -1) {
            result.browser = 'Firefox';
        } else if (ua.indexOf('Edg') > -1) {
            result.browser = 'Edge';
        }

        // Detect OS
        if (ua.indexOf('Android') > -1) {
            result.os = 'Android';
        } else if (ua.indexOf('iPhone') > -1 || ua.indexOf('iPad') > -1) {
            result.os = 'iOS';
        } else if (ua.indexOf('Windows') > -1) {
            result.os = 'Windows';
        } else if (ua.indexOf('Mac') > -1) {
            result.os = 'MacOS';
        } else if (ua.indexOf('Linux') > -1) {
            result.os = 'Linux';
        }

        // Check HTTPS
        result.https = window.location.protocol === 'https:' ||
                       window.location.hostname === 'localhost' ||
                       window.location.hostname === '127.0.0.1';

        if (!result.https) {
            result.issues.push('Website harus menggunakan HTTPS');
        }

        // Check Web Bluetooth API
        result.bluetooth = typeof navigator.bluetooth !== 'undefined' &&
                          typeof navigator.bluetooth.requestDevice === 'function';

        if (!result.bluetooth) {
            result.issues.push('Web Bluetooth API tidak tersedia');
        }

        // Determine overall support
        result.supported = result.bluetooth && result.https;

        // Browser-specific issues
        if (result.browser === 'Safari' || result.browser === 'Firefox') {
            result.issues.push(`${result.browser} tidak mendukung Web Bluetooth`);
            result.supported = false;
        }

        if (result.os === 'iOS') {
            result.issues.push('iOS tidak mendukung Web Bluetooth di browser apapun');
            result.supported = false;
        }

        return result;
    }

    /**
     * ✅ BARU - Show browser compatibility warning
     */
    showBrowserWarningIfNeeded() {
        if (!this.browserSupport.supported && typeof document !== 'undefined') {
            console.warn('⚠️ Web Bluetooth tidak didukung:', this.browserSupport);

            // Create warning banner if not exists
            setTimeout(() => {
                if (!document.getElementById('bluetooth-warning')) {
                    this.createWarningBanner();
                }
            }, 1000);
        }
    }

    /**
     * ✅ BARU - Create warning banner with instructions
     */
    createWarningBanner() {
        const banner = document.createElement('div');
        banner.id = 'bluetooth-warning';
        banner.style.cssText = `
            position: fixed;
            top: 60px;
            left: 50%;
            transform: translateX(-50%);
            background: #ff9800;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            z-index: 10000;
            max-width: 90%;
            font-size: 14px;
            line-height: 1.6;
        `;

        let message = '<strong>⚠️ Web Bluetooth Tidak Didukung</strong><br>';
        message += `Browser: ${this.browserSupport.browser} | OS: ${this.browserSupport.os}<br>`;
        message += '<small>';

        if (this.browserSupport.issues.length > 0) {
            message += 'Masalah: ' + this.browserSupport.issues.join(', ') + '<br>';
        }

        if (this.browserSupport.os === 'Android') {
            message += `
                <strong>SOLUSI untuk Redmi Pad 2:</strong><br>
                1. Pastikan menggunakan Chrome (bukan Mi Browser)<br>
                2. Buka: chrome://flags<br>
                3. Cari: "Bluetooth" dan aktifkan semua<br>
                4. Restart Chrome<br>
                5. Buka Settings Chrome → Site Settings → Bluetooth → Izinkan
            `;
        } else if (this.browserSupport.os === 'iOS') {
            message += 'iOS tidak mendukung Web Bluetooth. Gunakan perangkat Android atau Desktop.';
        } else {
            message += 'Gunakan Chrome/Edge versi terbaru di Android atau Desktop.';
        }

        message += '</small>';
        message += '<button onclick="this.parentElement.remove()" style="margin-left:10px;padding:5px 10px;background:white;color:#ff9800;border:none;border-radius:4px;cursor:pointer;">Tutup</button>';

        banner.innerHTML = message;
        document.body.appendChild(banner);
    }

    /**
     * ✅ ENHANCED - Connect dengan error handling yang lebih baik
     */
    async connect() {
        // Check browser support first
        if (!this.browserSupport.supported) {
            const errorMsg = this.getDetailedErrorMessage();
            alert(errorMsg);
            throw new Error(errorMsg);
        }

        if (this.isConnecting) {
            throw new Error('Koneksi sedang berlangsung');
        }

        // Check if already connected
        if (this.isConnected()) {
            console.log('Already connected');
            return true;
        }

        // Try to reconnect to saved device first
        const savedDeviceId = localStorage.getItem('thermal_device_id');
        const savedDeviceName = localStorage.getItem('thermal_device_name');

        if (savedDeviceId && !this.device) {
            await this.restorePromise;
            if (!this.device) {
                await this.loadSavedDevice();
            }
        }

        if (savedDeviceId && this.device) {
            console.log('Attempting to reconnect to saved device:', savedDeviceName);
            try {
                await this.reconnect();
                localStorage.setItem('thermal_connected', 'true');
                return true;
            } catch (error) {
                console.log('Reconnect failed, will request new pairing');
            }
        }

        this.isConnecting = true;

        try {
            console.log('Mencari printer bluetooth...');

            // ✅ ENHANCED - Request device dengan error handling
            try {
                this.device = await navigator.bluetooth.requestDevice({
                    filters: [
                        { namePrefix: 'BP' },
                        { namePrefix: 'BlueTooth Printer' },
                        { namePrefix: 'Printer' },
                        { services: ['000018f0-0000-1000-8000-00805f9b34fb'] }
                    ],
                    optionalServices: [
                        '000018f0-0000-1000-8000-00805f9b34fb',
                        '49535343-fe7d-4ae5-8fa9-9fafd205e455'
                    ]
                });
            } catch (error) {
                if (error.name === 'NotFoundError') {
                    throw new Error('Tidak ada printer yang dipilih atau ditemukan. Pastikan printer sudah ON dan dalam mode pairing.');
                } else if (error.name === 'SecurityError') {
                    throw new Error('Web Bluetooth diblokir oleh browser. Pastikan HTTPS aktif dan permission diberikan.');
                } else if (error.name === 'NotSupportedError') {
                    throw new Error('Browser tidak mendukung Web Bluetooth. ' + this.getDetailedErrorMessage());
                }
                throw error;
            }

            console.log('Printer ditemukan:', this.device.name);

            // Save device info
            localStorage.setItem('thermal_device_id', this.device.id);
            localStorage.setItem('thermal_device_name', this.device.name);

            // Connect to GATT server
            const server = await this.device.gatt.connect();
            console.log('Terhubung ke GATT server');

            // Setup disconnect handler
            this.setupDisconnectHandler();

            // Get service and characteristic
            await this.setupServiceAndCharacteristic(server);

            console.log('✅ Berhasil terhubung ke printer!');
            this.isConnecting = false;
            localStorage.setItem('thermal_connected', 'true');

            // Remove warning banner if exists
            const warningBanner = document.getElementById('bluetooth-warning');
            if (warningBanner) {
                warningBanner.remove();
            }

            return true;

        } catch (error) {
            console.error('❌ Gagal connect:', error);
            this.isConnecting = false;
            this.handleDisconnect();

            // Show detailed error
            let errorMsg = 'Gagal terhubung ke printer: ' + error.message;
            if (!this.browserSupport.supported) {
                errorMsg += '\n\n' + this.getDetailedErrorMessage();
            }
            throw new Error(errorMsg);
        }
    }

    /**
     * ✅ BARU - Get detailed error message dengan solusi
     */
    getDetailedErrorMessage() {
        let msg = '❌ TROUBLESHOOTING:\n\n';

        msg += `Browser: ${this.browserSupport.browser}\n`;
        msg += `OS: ${this.browserSupport.os}\n`;
        msg += `HTTPS: ${this.browserSupport.https ? '✅' : '❌'}\n`;
        msg += `Bluetooth API: ${this.browserSupport.bluetooth ? '✅' : '❌'}\n\n`;

        if (this.browserSupport.os === 'Android') {
            msg += '📱 SOLUSI UNTUK ANDROID TABLET (Redmi Pad 2):\n\n';
            msg += '1️⃣ GUNAKAN CHROME (bukan Mi Browser)\n';
            msg += '   - Download Chrome dari Play Store jika belum ada\n\n';
            msg += '2️⃣ AKTIFKAN FLAG BLUETOOTH:\n';
            msg += '   - Buka: chrome://flags\n';
            msg += '   - Cari: "Bluetooth"\n';
            msg += '   - Aktifkan semua opsi Bluetooth\n';
            msg += '   - Restart Chrome\n\n';
            msg += '3️⃣ SETTING CHROME:\n';
            msg += '   - Buka Settings Chrome\n';
            msg += '   - Site Settings → Bluetooth\n';
            msg += '   - Pastikan "Izinkan" untuk website ini\n\n';
            msg += '4️⃣ SETTING ANDROID:\n';
            msg += '   - Aktifkan Bluetooth di Settings\n';
            msg += '   - Aktifkan Location/GPS\n';
            msg += '   - Berikan permission ke Chrome\n\n';
            msg += '5️⃣ RESTART:\n';
            msg += '   - Restart Chrome setelah ubah settings\n';
            msg += '   - Refresh halaman website\n';
        } else if (this.browserSupport.os === 'iOS') {
            msg += '📱 MAAF: iOS tidak mendukung Web Bluetooth\n';
            msg += 'Gunakan perangkat Android atau Desktop dengan Chrome.';
        } else {
            msg += '💻 GUNAKAN CHROME/EDGE VERSI TERBARU\n';
            msg += 'Pastikan browser sudah update ke versi terbaru.';
        }

        return msg;
    }

    /**
     * Setup disconnect event handler
     */
    setupDisconnectHandler() {
        if (this.device) {
            this.device.addEventListener('gattserverdisconnected', () => {
                console.warn('Printer disconnected unexpectedly');
                this.handleDisconnect();
            });
        }
    }

    /**
     * Attempt to load the previously authorized device
     */
    async loadSavedDevice() {
        const savedDeviceId = localStorage.getItem('thermal_device_id');

        if (!savedDeviceId || typeof navigator === 'undefined' ||
            !navigator.bluetooth || !navigator.bluetooth.getDevices) {
            return null;
        }

        try {
            const devices = await navigator.bluetooth.getDevices();
            const matchedDevice = devices.find(device => device.id === savedDeviceId);

            if (matchedDevice) {
                this.device = matchedDevice;
                this.setupDisconnectHandler();
                console.log('✅ Restored saved thermal printer:', matchedDevice.name || matchedDevice.id);
                return matchedDevice;
            }
        } catch (error) {
            console.warn('Failed to restore saved thermal printer:', error);
        }

        return null;
    }

    /**
     * Auto reconnect on page load
     */
    async autoReconnectOnLoad() {
        const shouldReconnect = localStorage.getItem('thermal_connected') === 'true';
        if (!shouldReconnect) {
            return false;
        }

        try {
            if (!this.device) {
                await this.restorePromise;
                if (!this.device) {
                    await this.loadSavedDevice();
                }
            }

            if (this.device) {
                await this.reconnect();
                localStorage.setItem('thermal_connected', 'true');
                return true;
            }
        } catch (error) {
            console.warn('Auto reconnect on load failed:', error);
        }

        return false;
    }

    /**
     * Setup user gesture reconnect
     */
    setupUserGestureReconnect() {
        if (this.userGestureListenerAttached || typeof document === 'undefined') {
            return;
        }

        this.userGestureListenerAttached = true;

        const handler = async () => {
            document.removeEventListener('click', handler);
            document.removeEventListener('keydown', handler);

            try {
                const success = await this.autoReconnectOnLoad();
                if (success) {
                    console.log('✅ Auto reconnect succeeded after user gesture');
                }
            } catch (error) {
                console.warn('Gesture based auto reconnect failed:', error);
            }
        };

        document.addEventListener('click', handler, { once: true });
        document.addEventListener('keydown', handler, { once: true });
    }

    /**
     * Force reconnect from UI
     */
    async reconnectFromUI() {
        try {
            await this.autoReconnectOnLoad();
        } catch (error) {
            console.error('UI reconnect failed:', error);
            throw error;
        }
    }

    /**
     * Handle disconnect event
     */
    handleDisconnect() {
        this.characteristic = null;

        if (typeof updateConnectionUI === 'function') {
            updateConnectionUI(false);
        }
        if (typeof updateModalUI === 'function') {
            updateModalUI(false);
        }

        localStorage.setItem('thermal_connected', 'false');
        console.log('Connection cleaned up');
    }

    /**
     * Check if connected
     */
    isConnected() {
        return this.device &&
            this.device.gatt &&
            this.device.gatt.connected &&
            this.characteristic !== null;
    }

    /**
     * Setup service and characteristic
     */
    async setupServiceAndCharacteristic(server) {
        let service;
        const serviceUUIDs = [
            '000018f0-0000-1000-8000-00805f9b34fb',
            '49535343-fe7d-4ae5-8fa9-9fafd205e455'
        ];

        for (let uuid of serviceUUIDs) {
            try {
                service = await server.getPrimaryService(uuid);
                console.log('Service ditemukan:', uuid);
                break;
            } catch (e) {
                console.log('Service tidak ditemukan:', uuid);
            }
        }

        if (!service) {
            throw new Error('Service printer tidak ditemukan');
        }

        const charUUIDs = [
            '00002af1-0000-1000-8000-00805f9b34fb',
            '49535343-8841-43f4-a8d4-ecbe34729bb3'
        ];

        for (let uuid of charUUIDs) {
            try {
                this.characteristic = await service.getCharacteristic(uuid);
                console.log('Characteristic ditemukan:', uuid);
                break;
            } catch (e) {
                console.log('Characteristic tidak ditemukan:', uuid);
            }
        }

        if (!this.characteristic) {
            throw new Error('Characteristic printer tidak ditemukan');
        }
    }

    /**
     * Reconnect to previously paired device
     */
    async reconnect() {
        if (!this.device) {
            throw new Error('No device to reconnect');
        }

        console.log('Reconnecting to:', this.device.name);

        try {
            const server = await this.device.gatt.connect();
            await this.setupServiceAndCharacteristic(server);
            this.setupDisconnectHandler();
            console.log('✅ Reconnected successfully');
            localStorage.setItem('thermal_connected', 'true');
            return true;
        } catch (error) {
            console.error('Reconnect failed:', error);
            throw error;
        }
    }

    /**
     * Ensure connected before operation
     */
    async ensureConnected() {
        if (!this.isConnected()) {
            console.log('Not connected, attempting auto-reconnect...');

            if (this.device) {
                try {
                    await this.reconnect();
                    console.log('Auto-reconnect successful');
                    return true;
                } catch (error) {
                    console.error('Auto-reconnect failed:', error);
                }
            }

            throw new Error('Printer belum terhubung. Silakan hubungkan printer terlebih dahulu.');
        }
        return true;
    }

    /**
     * Disconnect from printer
     */
    async disconnect() {
        if (this.device && this.device.gatt.connected) {
            await this.device.gatt.disconnect();
            console.log('Disconnected dari printer');
        }
        this.handleDisconnect();
    }

    /**
     * Write data to printer
     */
    async write(data) {
        await this.ensureConnected();

        const encoded = typeof data === 'string'
            ? this.encoder.encode(data)
            : data;

        const chunkSize = 20;
        for (let i = 0; i < encoded.length; i += chunkSize) {
            const chunk = encoded.slice(i, i + chunkSize);

            try {
                await this.characteristic.writeValue(chunk);
                await this.sleep(10);
            } catch (error) {
                console.error('Write error:', error);
                throw new Error('Gagal mengirim data ke printer: ' + error.message);
            }
        }
    }

    /**
     * Helper: delay
     */
    sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    /**
     * Format text with padding
     */
    pad(text, length, char = ' ', align = 'left') {
        text = String(text).substring(0, length);
        const padLength = length - text.length;

        if (align === 'right') {
            return char.repeat(padLength) + text;
        } else if (align === 'center') {
            const leftPad = Math.floor(padLength / 2);
            const rightPad = padLength - leftPad;
            return char.repeat(leftPad) + text + char.repeat(rightPad);
        } else {
            return text + char.repeat(padLength);
        }
    }

    /**
     * Format number to Rupiah
     */
    formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    /**
     * Print sales receipt
     */
    async printNota(data) {
        try {
            await this.ensureConnected();

            console.log('Starting print job...');

            await this.write(this.CMD.INIT);
            await this.sleep(100);

            // Header
            await this.write(this.CMD.ALIGN_CENTER);
            await this.write(this.CMD.FONT_LARGE);
            await this.write(data.setting.nama_perusahaan + this.CMD.LINE);

            await this.write(this.CMD.FONT_NORMAL);
            await this.write(data.setting.alamat + this.CMD.LINE);
            await this.write('Telp: ' + data.setting.telepon + this.CMD.LINE);

            // Separator
            await this.write(this.CMD.ALIGN_LEFT);
            await this.write('='.repeat(32) + this.CMD.LINE);

            // Transaction info
            await this.write('No: ' + data.transaksi.no_transaksi + this.CMD.LINE);
            await this.write('Tgl: ' + data.transaksi.tanggal + this.CMD.LINE);
            await this.write('Kasir: ' + data.transaksi.kasir + this.CMD.LINE);
            await this.write('Outlet: ' + data.transaksi.outlet + this.CMD.LINE);

            // ✅ TAMBAHAN: NAMA PEMBELI
            if (data.transaksi.nama_pembeli && data.transaksi.nama_pembeli !== '-') {
                await this.write('Pembeli: ' + data.transaksi.nama_pembeli + this.CMD.LINE);
            }

            if (data.transaksi.member && data.transaksi.member !== 'UMUM') {
                await this.write('Member: ' + data.transaksi.member + this.CMD.LINE);
            }

            await this.write('-'.repeat(32) + this.CMD.LINE);

            // Items
            for (let item of data.items) {
                const nama = item.nama.substring(0, 32);
                await this.write(nama + this.CMD.LINE);

                const qtyPrice = `${item.qty} x ${this.formatRupiah(item.harga)}`;
                const subtotal = this.formatRupiah(item.subtotal);
                const line = this.pad(qtyPrice, 20) + this.pad(subtotal, 12, ' ', 'right');
                await this.write(line + this.CMD.LINE);
            }

            await this.write('-'.repeat(32) + this.CMD.LINE);

            // Total
            await this.write(this.CMD.FONT_BOLD);

            const subtotalLine = this.pad('Subtotal:', 20) +
                this.pad(this.formatRupiah(data.total.subtotal), 12, ' ', 'right');
            await this.write(subtotalLine + this.CMD.LINE);

            if (data.total.diskon > 0) {
                const diskonLabel = `Diskon (${data.total.diskon}%):`;
                const diskonLine = this.pad(diskonLabel, 20) +
                    this.pad(this.formatRupiah(data.total.diskon_nominal), 12, ' ', 'right');
                await this.write(diskonLine + this.CMD.LINE);
            }

            await this.write(this.CMD.FONT_LARGE);
            const totalLine = this.pad('TOTAL:', 20) +
                this.pad(this.formatRupiah(data.total.total), 12, ' ', 'right');
            await this.write(totalLine + this.CMD.LINE);

            await this.write(this.CMD.FONT_BOLD);
            const bayarLine = this.pad('Bayar:', 20) +
                this.pad(this.formatRupiah(data.total.bayar), 12, ' ', 'right');
            await this.write(bayarLine + this.CMD.LINE);

            const kembaliLine = this.pad('Kembali:', 20) +
                this.pad(this.formatRupiah(data.total.kembali), 12, ' ', 'right');
            await this.write(kembaliLine + this.CMD.LINE);

            // Footer
            await this.write(this.CMD.FONT_NORMAL);
            await this.write('='.repeat(32) + this.CMD.LINE);
            await this.write(this.CMD.ALIGN_CENTER);
            await this.write('Terima Kasih' + this.CMD.LINE);
            await this.write('Selamat Berbelanja Kembali' + this.CMD.LINE);

            // Feed and cut
            await this.write(this.CMD.FEED);
            await this.write(this.CMD.FEED);
            await this.write(this.CMD.CUT);

            console.log('✅ Print berhasil!');
            return true;

        } catch (error) {
            console.error('❌ Error print:', error);
            throw error;
        }
    }

    /**
     * Test print
     */
    async testPrint() {
        try {
            await this.ensureConnected();

            await this.write(this.CMD.INIT);
            await this.write(this.CMD.ALIGN_CENTER);
            await this.write(this.CMD.FONT_LARGE);
            await this.write('TEST PRINT' + this.CMD.LINE);
            await this.write(this.CMD.FONT_NORMAL);
            await this.write('Printer BP-ECO58' + this.CMD.LINE);
            await this.write(new Date().toLocaleString('id-ID') + this.CMD.LINE);
            await this.write('='.repeat(32) + this.CMD.LINE);
            await this.write(this.CMD.ALIGN_LEFT);
            await this.write('Status: CONNECTED' + this.CMD.LINE);
            await this.write('Status: READY' + this.CMD.LINE);
            await this.write(this.CMD.FEED);
            await this.write(this.CMD.CUT);

            console.log('✅ Test print berhasil!');
            return true;
        } catch (error) {
            console.error('❌ Test print gagal:', error);
            throw error;
        }
    }
}

// Create global instance
window.thermalPrinter = new ThermalPrinter();
window.triggerThermalReconnect = () => window.thermalPrinter.reconnectFromUI();

// Auto-check connection on page load
if (typeof document !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        console.log('🖨️ Thermal Printer initialized');
        console.log('Browser Support:', window.thermalPrinter.browserSupport);

        window.thermalPrinter.setupUserGestureReconnect();

        // Delegate reconnect buttons
        document.addEventListener('click', (event) => {
            const button = event.target.closest('[data-thermal-reconnect]');
            if (!button) {
                return;
            }

            event.preventDefault();
            window.thermalPrinter.reconnectFromUI();
        });
    });
}
