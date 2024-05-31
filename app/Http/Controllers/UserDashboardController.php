<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Measurement;
use Illuminate\Http\Request;
use App\Models\MeasurementType;
use Illuminate\Support\Facades\Log;

class UserDashboardController extends Controller
{
    
    public function show($id) {

        // Mengambil data pengguna
        $user = User::findOrFail($id);

        //Passing Data Last Measurement 
        $measurementTypes = MeasurementType::where('category', 'GCU')->pluck('name'); // Mengambil jenis pengukuran dari tabel measurement_types

        $vsTypes = MeasurementType::where('category', 'Vital Signs')->pluck('name');

        $lastMeasurements = []; // Mengambil last measurement untuk masing-masing jenis pengukuran

        foreach ($measurementTypes as $type) {
            $lastMeasurement = Measurement::where('user_id', $id)
                ->whereHas('type', function ($query) use ($type) {
                    $query->where('name', $type);
                })
                ->orderBy('measurement_time', 'desc')
                ->with('detail')
                ->first();

                if ($lastMeasurement) {
                    $lastMeasurement->indicatorColor = $this->getIndicatorColor($type, $lastMeasurement);
                }

            $lastMeasurements[$type] = $lastMeasurement ?: null;
        }

        $lastVitalSigns = [];

        foreach ($vsTypes as $vsType) {
            $lastVitalSign = Measurement::where('user_id', $id)->whereHas('type', function ($query) use ($vsType) {
                $query->where('name', $vsType);
            })->orderBy('measurement_time', 'desc')->first();

            if ($lastVitalSign) {
                $unit = $lastVitalSign->type->units()->first(); // Asumsi unit utama adalah unit pertama
                $lastVitalSign->unit = $unit ? $unit->unit : 'N/A';
            }    

            $lastVitalSigns[$vsType] = $lastVitalSign ?: null;
        }

        // Color Indicator

        return view('home', [
            'id' => $id,
            'users' => $user,
            'lastMeasurements' => $lastMeasurements,
            'lastVitalSigns' => $lastVitalSigns,
        ]);
    }


    private function getIndicatorColor($type, $measurement) {
        $value = $measurement->value;
        $afterMeal = $measurement->detail->after_meal ?? false;

        // Debugging output
    Log::info("Type: $type, Value: $value, After Meal: $afterMeal");
    
        switch ($type) {
            case 'Glucose':
                return $this->getGlucoseIndicatorColor($value, $afterMeal);
            case 'Cholesterol':
                return $this->getCholesterolIndicatorColor($value);
            case 'Uric Acid':
                return $this->getUricAcidIndicatorColor($value);
            default:
                return 'bg-base-100';
        }
    }
    
    private function getGlucoseIndicatorColor($value, $afterMeal) {
        if ($afterMeal) {
            if ($value < 140) {
                return 'bg-green-200';
            } elseif ($value <= 199) {
                return 'bg-yellow-200';
            } else {
                return 'bg-red-200';
            }
        } else {
            if ($value < 100) {
                return 'bg-green-200';
            } elseif ($value <= 125) {
                return 'bg-yellow-200';
            } else {
                return 'bg-red-200';
            }
        }
    }
    
    private function getCholesterolIndicatorColor($value) {
        if ($value < 200) {
            return 'bg-green-200';
        } elseif ($value <= 239) {
            return 'bg-yellow-200';
        } else {
            return 'bg-red-200';
        }
    }
    
    private function getUricAcidIndicatorColor($value) {
        if ($value < 2.4) {
            return 'bg-yellow-200';
        } elseif ($value <= 7.0) {
            return 'bg-green-200';
        } else {
            return 'bg-red-200';
        }
    }

}