<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Measurement;
use Illuminate\Http\Request;
use App\Models\MeasurementType;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LastMeasurementsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Mendapatkan ID pengguna dari route parameter
        $user = Auth::user();

        if ($user) {
            // Mengambil semua jenis pengukuran dari tabel measurement_types
            $measurementTypes = MeasurementType::where('category', 'GCU')->pluck('name');

            // Mengambil pengukuran terakhir untuk masing-masing jenis pengukuran
            $lastMeasurements = [];

            foreach ($measurementTypes as $type) {
                $lastMeasurement = Measurement::where('user_id', $user->id)
                    ->whereHas('type', function ($query) use ($type) {
                        $query->where('name', $type);
                    })
                    ->orderBy('measurement_time', 'desc')
                    ->first();

                $lastMeasurements[$type] = $lastMeasurement ?: null;
            }

            // Menambahkan data ke view
            view()->share('lastMeasurements', $lastMeasurements);
        }

        return $next($request);
    }
}
