import React, { useEffect, useState, useRef } from 'react';
import { router, Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Html5QrcodeScanner } from 'html5-qrcode';
import toast, { Toaster } from 'react-hot-toast';

export default function QRScanner() {
    const [scanResult, setScanResult] = useState('Silahkan scan terlebih dahulu');
    const [scanTime, setScanTime] = useState('');
    const audioRef = useRef(null);

    const scannerRef = useRef(null);

    useEffect(() => {
        if (scannerRef.current) return;

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", 
            {
                fps: 10,
                qrbox: { width: 300, height: 300 },
                rememberLastUsedCamera: true,
                showTorchButtonIfSupported: true,
                supportedScanTypes: [0] // 0 = SCAN_TYPE_CAMERA
            },
            /* verbose= */ false
        );
        
        scannerRef.current = html5QrcodeScanner;

        const onScanSuccess = (decodedText, decodedResult) => {
            // Pause scanner slightly to prevent multiple calls
            html5QrcodeScanner.pause();
            
            axios.post('/penjemput-datang', { data: decodedText })
                .then(response => {
                    console.log(response.data);
                    if(audioRef.current) {
                        audioRef.current.play().catch(e => console.log('Audio play blocked:', e));
                    }
                    setScanResult(response.data.data);
                    setScanTime(response.data.time);
                    toast.success('Berhasil di-scan!');
                    
                    // Resume scanning after 3 seconds
                    setTimeout(() => {
                        html5QrcodeScanner.resume();
                    }, 3000);
                })
                .catch(error => {
                    console.error('Error during scan:', error);
                    toast.error('Gagal scan, coba lagi.');
                    html5QrcodeScanner.resume();
                });
        };

        const onScanFailure = (error) => {
            // handle scan failure, usually better to ignore and keep scanning
        };

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        // Cleanup
        return () => {
            if (scannerRef.current) {
                scannerRef.current.clear().catch(error => {
                    console.error("Failed to clear html5QrcodeScanner. ", error);
                });
                scannerRef.current = null;
            }
        };
    }, []);

    return (
        <AuthenticatedLayout>
            <Head title="QR Scanner Penjemputan" />
            <Toaster />
            <div className="max-w-2xl mx-auto mt-8">
                <div className="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700 overflow-hidden">
                    <div className="p-6 border-b border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-900/50">
                        <h2 className="text-xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                            <i className="ph ph-qr-code"></i> Scan QR Penjemputan
                        </h2>
                    </div>
                    
                    <div className="p-6 flex flex-col items-center">
                        <div id="qr-reader" className="w-full max-w-sm mb-8 overflow-hidden rounded-xl border border-surface-200 dark:border-surface-700"></div>
                        
                        <div className="w-full bg-surface-100 dark:bg-surface-900 rounded-xl p-6 text-center border border-surface-200 dark:border-surface-700">
                            <h3 className="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Hasil Pemindaian</h3>
                            <p className="text-2xl font-bold text-brand-600 dark:text-brand-400">{scanResult}</p>
                            {scanTime && (
                                <p className="text-sm text-slate-500 mt-2"><i className="ph ph-clock"></i> {scanTime}</p>
                            )}
                        </div>
                    </div>
                </div>
                
                {/* Audio Element */}
                <audio ref={audioRef} src="/sounds/qrcode.mp3" preload="auto" />
            </div>
        </AuthenticatedLayout>
    );
}
