<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveAcademicYear
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!activeAcademicYear()) {
            if (auth()->user()->hasRole('Admin')) {
                flashMessage('Tidak ada tahun ajaran yang aktif. Silahkan tambahkan terlebih dahulu', 'warning');
                return to_route('admin.academic-years.index');
            } else if (auth()->user()->hasRole('Student')) {
                flashMessage('Tidak ada tahun ajaran yang aktif. Harap hubungi Koordinator MBKM', 'warning');
                return back();
            }
        }
        return $next($request);
    }
}
