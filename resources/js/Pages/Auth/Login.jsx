import { useEffect } from 'react';
import GuestLayout from '../../Layouts/GuestLayout';
import { Head, useForm, Link } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post('/login');
    };

    return (
        <GuestLayout title="Login">
            <div className="mb-8">
                <h2 className="text-3xl font-bold text-slate-800 dark:text-white tracking-tight mb-2">Masuk ke Akun</h2>
                <p className="text-slate-500 dark:text-slate-400">Silakan masukkan email dan password Anda untuk melanjutkan.</p>
            </div>

            {status && (
                <div className="mb-6 font-medium text-sm text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 p-4 rounded-xl border border-emerald-200 dark:border-emerald-500/20">
                    {status}
                </div>
            )}

            <form onSubmit={submit} className="space-y-5">
                <div>
                    <label htmlFor="email" className="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                    <div className="relative group">
                        <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i className="ph ph-envelope-simple text-slate-400 group-focus-within:text-blue-800 transition-colors text-lg"></i>
                        </div>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className={`block w-full pl-10 pr-4 py-2.5 bg-white dark:bg-surface-800 border ${errors.email ? 'border-rose-500 focus:ring-rose-500/50' : 'border-surface-200 dark:border-surface-700 focus:ring-blue-800/50 focus:border-blue-800'} rounded-xl text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 transition-all shadow-sm`}
                            autoComplete="username"
                            autoFocus
                            onChange={(e) => setData('email', e.target.value)}
                            placeholder="nama@avicenna.sch.id"
                        />
                    </div>
                    {errors.email && <p className="mt-1.5 text-sm font-medium text-rose-500">{errors.email}</p>}
                </div>

                <div>
                    <label htmlFor="password" className="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                    <div className="relative group">
                        <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i className="ph ph-lock-key text-slate-400 group-focus-within:text-blue-800 transition-colors text-lg"></i>
                        </div>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            className={`block w-full pl-10 pr-4 py-2.5 bg-white dark:bg-surface-800 border ${errors.password ? 'border-rose-500 focus:ring-rose-500/50' : 'border-surface-200 dark:border-surface-700 focus:ring-blue-800/50 focus:border-blue-800'} rounded-xl text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 transition-all shadow-sm`}
                            autoComplete="current-password"
                            onChange={(e) => setData('password', e.target.value)}
                            placeholder="••••••••"
                        />
                    </div>
                    {errors.password && <p className="mt-1.5 text-sm font-medium text-rose-500">{errors.password}</p>}
                </div>

                <div className="flex items-center justify-between">
                    <label className="flex items-center group cursor-pointer">
                        <input
                            type="checkbox"
                            name="remember"
                            checked={data.remember}
                            onChange={(e) => setData('remember', e.target.checked)}
                            className="rounded border-surface-300 dark:border-surface-600 text-blue-800 shadow-sm focus:ring-blue-800 dark:focus:ring-blue-800 dark:bg-surface-800 transition-all cursor-pointer w-4 h-4"
                        />
                        <span className="ml-2 text-sm font-medium text-slate-600 dark:text-slate-400 group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-colors">Ingat Saya</span>
                    </label>

                    {canResetPassword && (
                        <Link
                            href="/forgot-password"
                            className="text-sm font-bold text-blue-800 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 hover:underline transition-all"
                        >
                            Lupa password?
                        </Link>
                    )}
                </div>

                <div className="pt-4">
                    <button
                        className={`w-full flex items-center justify-center py-3 px-4 bg-blue-900 hover:bg-slate-900 text-white font-bold rounded-xl shadow-lg shadow-blue-900/30 transition-all ${processing && 'opacity-75 cursor-not-allowed scale-[0.98]'}`}
                        disabled={processing}
                    >
                        {processing ? (
                            <><i className="ph ph-spinner animate-spin text-xl mr-2"></i> Memproses...</>
                        ) : (
                            <><i className="ph ph-sign-in text-xl mr-2"></i> Masuk Sekarang</>
                        )}
                    </button>
                </div>
            </form>
        </GuestLayout>
    );
}
