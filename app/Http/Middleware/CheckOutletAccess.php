<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOutletAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
   public function handle(Request $request, Closure $next)
{
    $user = auth()->user();

    // Admin bypass semua pengecekan
    if ($user->level == 1) {
        return $next($request);
    }

    // BARU - Cek session outlet, kalau belum ada redirect ke select
    if (!session()->has('id_outlet')) {
        // Coba auto-select kalau user hanya punya 1 outlet
        $outlets = $user->getAccessibleOutlets();

        if ($outlets->count() == 1) {
            session()->put('id_outlet', $outlets->first()->id_outlet);
            session()->save();
            return $next($request);
        }

        return redirect()->route('outlet.select')
            ->with('error', 'Silakan pilih outlet terlebih dahulu');
    }

    $outletId = session('id_outlet');

    // Validasi akses masih berlaku
    if (!$user->hasAccessToOutlet($outletId)) {
        session()->forget('id_outlet'); // Hapus session yang invalid
        return redirect()->route('outlet.select')
            ->with('error', 'Akses outlet tidak valid');
    }

    return $next($request);
}
}
