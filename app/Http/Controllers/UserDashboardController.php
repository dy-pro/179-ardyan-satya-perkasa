<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Measurement;
use Illuminate\Http\Request;
use App\Models\MeasurementType;
use Illuminate\Support\Facades\Log;

class UserDashboardController extends Controller
{
    
    public function show($id, Request $request) {

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

        // Mengambil parameter query string atau menggunakan nilai default
        $rangeGlu = $request->query('rangeGlu', 'last7days');
        $rangeChol = $request->query('rangeChol', 'last7days');
        $rangeUric = $request->query('rangeUric', 'last7days');
        $rangeVs = $request->query('rangeVs', 'last7days');


        // Menghitung rata-rata glucose berdasarkan rentang waktu
        $averageGlucose = $this->calculateAverage($id, $rangeGlu, 'Glucose');
        $averageCholesterol = $this->calculateAverage($id, $rangeChol, 'Cholesterol');
        $averageUricAcid = $this->calculateAverage($id, $rangeUric, 'Uric Acid');
        $averageHeartRate = $this->calculateAverage($id, $rangeVs, 'Heart Rate');

        $avgGlucoseStatus = $this->getAvgGlucoseStatus($averageGlucose);
        $avgGlucoseIndicatorColor = $this->getAvgGlucoseIndicatorColor($averageGlucose);
        $avgCholesterolStatus = $this->getAvgCholesterolStatus($averageCholesterol);
        $avgCholesterolIndicatorColor = $this->getAvgCholesterolIndicatorColor($averageCholesterol);
        $avgUricAcidStatus = $this->getAvgUricAcidStatus($averageUricAcid);
        $avgUricAcidIndicatorColor = $this->getAvgUricAcidIndicatorColor($averageUricAcid);

        return view('home', [
            'id' => $id,
            'users' => $user,
            'lastMeasurements' => $lastMeasurements,
            'lastVitalSigns' => $lastVitalSigns,
            'averageGlucose' => $averageGlucose,
            'averageCholesterol' => $averageCholesterol,
            'averageUricAcid' => $averageUricAcid,
            'averageHeartRate' => $averageHeartRate,
            'selectedGluRange' => $rangeGlu,
            'selectedCholRange' => $rangeChol,
            'selectedUricRange' => $rangeUric,
            'selectedVsRange' => $rangeVs,
            'avgGlucoseStatus' => $avgGlucoseStatus,
            'avgCholesterolStatus' => $avgCholesterolStatus,
            'avgUricAcidStatus' => $avgUricAcidStatus,
            'avgGlucoseIndicatorColor' => $avgGlucoseIndicatorColor,
            'avgCholesterolIndicatorColor' => $avgCholesterolIndicatorColor,
            'avgUricAcidIndicatorColor' => $avgUricAcidIndicatorColor,
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




    //Statistic Dashboard
    private function getAvgGlucoseIndicatorColor($value) {
        if ($value < 140) {
            return 'bg-green-100 text-green-800';
        } elseif ($value <= 199) {
            return 'bg-yellow-100 text-yellow-800';
        } else {
            return 'bg-red-200 text-red-800';
        }
    }

    private function getAvgGlucoseStatus($value) {
        if ($value < 140) {
            return '<svg class="w-4 h-4 me-1.5 {{$getAvgGlucoseIndicatorColor}}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z" clip-rule="evenodd"/>
          </svg>
          Normal';
        } elseif ($value <= 199) {
            return '<svg class="w-4 h-4 me-1.5 {{$getAvgGlucoseIndicatorColor}}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207"/>
          </svg>
          Pre-Diabetes';
        } else {
            return '<svg class="w-4 h-4 me-1.5 {{$getAvgGlucoseIndicatorColor}}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207"/>
          </svg>
          Diabetes';
        }
    }

    private function getAvgCholesterolIndicatorColor($value) {
        if ($value < 200) {
            return 'bg-green-100 text-green-800';
        } elseif ($value <= 239) {
            return 'bg-yellow-100 text-yellow-800';
        } else {
            return 'bg-red-100 text-red-800';
        }
    }

    private function getAvgCholesterolStatus($value) {
        if ($value < 200) {
            return '<svg class="w-4 h-4 me-1.5 {{$getAvgCholesterolIndicatorColor}}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z" clip-rule="evenodd"/>
          </svg>Normal';
        } elseif ($value <= 239) {
            return '<svg class="w-4 h-4 me-1.5 {{$getAvgCholesterolIndicatorColor}}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207"/>
          </svg>
          Borderline High';
        } else {
            return '<svg class="w-4 h-4 me-1.5 {{$getAvgCholesterolIndicatorColor}}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207"/>
          </svg>
          High';
        }
    }

    private function getAvgUricAcidIndicatorColor($value) {
        if ($value < 2.4) {
            return 'bg-yellow-100 text-yellow-800';
        } elseif ($value <= 7.0) {
            return 'bg-green-100 text-green-800';
        } else {
            return 'bg-red-100 text-red-800';
        }
    }

    private function getAvgUricAcidStatus($value) {
        if ($value < 2.4) {
            return '<svg class="w-4 h-4 me-1.5 {{$getAvgUricAcidIndicatorColor}}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207"/>
          </svg>
          Low';
        } elseif ($value <= 7.0) {
            return '<svg class="w-4 h-4 me-1.5 {{$getAvgUricAcidIndicatorColor}}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z" clip-rule="evenodd"/></svg>
            Normal';
        } else {
            return '<svg class="w-4 h-4 me-1.5 {{$getAvgUricAcidIndicatorColor}}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207"/>
          </svg>
          High';
        }
    }
    
    //Statistic in User Dashboard
    private function calculateAverage($userId, $range, $type) {
        $query = Measurement::where('user_id', $userId)
            ->whereHas('type', function ($query) use ($type) {
                $query->where('name', $type);
            });

        switch ($range) {
            case 'yesterday':
                $query->whereDate('measurement_time', now()->subDay());
                break;
            case 'today':
                $query->whereDate('measurement_time', now());
                break;
            case 'last7days':
                $query->whereBetween('measurement_time', [now()->subDays(7), now()]);
                break;
            case 'last30days':
                $query->whereBetween('measurement_time', [now()->subDays(30), now()]);
                break;
            case 'last90days':
                $query->whereBetween('measurement_time', [now()->subDays(90), now()]);
                break;
        }

        return $query->avg('value');
    }

    // Metode untuk mengambil data pengukuran gula darah selama 7 hari terakhir
    public function getGlucoseData($id) {
        $data = $this->getAverageMeasurementData($id, 'Glucose');
        return response()->json($data);
    
    }
    // Metode untuk mengambil data pengukuran cholesterol selama 7 hari terakhir
    public function getCholesterolData($id) {
        $data = $this->getAverageMeasurementData($id, 'Cholesterol');
        return response()->json($data);
    
    }
    // Metode untuk mengambil data pengukuran uric acid selama 7 hari terakhir
    public function getUricAcidData($id) {
        $data = $this->getAverageMeasurementData($id, 'Uric Acid');
        return response()->json($data);
    }
    // Metode untuk mengambil data pengukuran heart rate selama 7 hari terakhir
    public function getHeartRateData($id) {
        $data = $this->getAverageMeasurementData($id, 'Heart Rate');
        return response()->json($data);
    }

    // Metode untuk kalkulasi rata-rata pengukuran selama 7 hari terakhir
    private function getAverageMeasurementData($id, $type) {
        $data = Measurement::where('user_id', $id)
            ->whereHas('type', function ($query) use ($type) {
                $query->where('name', $type);
            })
            ->whereBetween('measurement_time', [now()->subDays(7), now()])
            ->orderBy('measurement_time')
            ->get(['measurement_time', 'value'])
            ->groupBy(function($date) {
                return Carbon::parse($date->measurement_time)->format('Y-m-d'); // Mengelompokkan berdasarkan tanggal
            })
            ->map(function ($day) {
                return [
                    'x' => Carbon::parse($day->first()->measurement_time)->format('D'),
                    'y' => round($day->avg('value'), 2),
                ];
            })
            ->values(); // Menghilangkan kunci yang berupa tanggal

        return $data;
    }

}