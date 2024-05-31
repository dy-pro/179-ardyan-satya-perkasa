<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Measurement;
use Illuminate\Http\Request;
use App\Models\MeasurementType;
use App\Models\MeasurementDetail;
use App\Models\UserUnitPreference;
use Illuminate\Support\Facades\Log;

class MeasurementController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {

        // Mengambil data pengguna tabel users
        $user = User::findOrFail($id);

    //Begining of passing Last Measurement data 
        $measurementTypes = MeasurementType::where('category', 'GCU')->pluck('name'); // Mengambil jenis pengukuran dari tabel measurement_types

        $vsTypes = MeasurementType::where('category', 'Vital Signs')->pluck('name');
        
        $lastMeasurements = []; // Mengambil pengukuran terakhir untuk masing-masing jenis pengukuran

        foreach ($measurementTypes as $type) {
            $lastMeasurement = Measurement::where('user_id', $id)
                ->whereHas('type', function ($query) use ($type) {
                    $query->where('name', $type);
                })
                ->orderBy('measurement_time', 'desc')
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
                $unit = $lastVitalSign->type->units()->first();
                $lastVitalSign->unit = $unit ? $unit->unit : 'N/A';
            }    

            $lastVitalSigns[$vsType] = $lastVitalSign ?: null;
        }
    //End of passing Last Measurement data 


        // mengambil data dari table measurements
    	$measurements = Measurement::where('user_id', $id)
            ->orderBy('measurement_time', 'desc') // Urutkan dari yang terbaru ke yang paling lama
            ->paginate(6); // Batasi jumlah data per halaman
    	
        // mengirim data measurements ke view measurements.all
    	return view('measurements.all',[
            'id' => $id,
            'users' => $user,
            'measurements' => $measurements,
            'lastMeasurements' => $lastMeasurements,
            'lastVitalSigns' => $lastVitalSigns,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($inputType, $id)
    {

        // Mengambil data pengguna dari tabel users
        $user = User::findOrFail($id);

        //Begining of Passing Data Last Measurement 
        $measurementTypes = MeasurementType::where('category', 'GCU')->pluck('name'); // Mengambil jenis pengukuran dari tabel measurement_types

        $vsTypes = MeasurementType::where('category', 'Vital Signs')->pluck('name');
           
        $lastMeasurements = []; // Mengambil pengukuran terakhir untuk masing-masing jenis pengukuran

        foreach ($measurementTypes as $type) {
            $lastMeasurement = Measurement::where('user_id', $id)
                ->whereHas('type', function ($query) use ($type) {
                    $query->where('name', $type);
                })
                ->orderBy('measurement_time', 'desc')
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
        //End of Passing Data Last Measurement

        $defaultDateTime = now()->format('Y-m-d\TH:i');

        if ($inputType === 'gcu') {
            return view('measurements.input-gcu', [
                'id' => $id,
                'users' => $user,
                'lastMeasurements' => $lastMeasurements,
                'lastVitalSigns' => $lastVitalSigns,
                'isCreate' => true, 
                'defaultDateTime' => $defaultDateTime,
            ]);

        } elseif ($inputType === 'vital-signs') {
            return view('measurements.input-vital-signs', [
                'id' => $id,
                'users' => $user,
                'lastMeasurements' => $lastMeasurements,
                'lastVitalSigns' => $lastVitalSigns,
                'isCreate' => true,
                'defaultDateTime' => $defaultDateTime,
            ]);
        } else {
            abort(404, 'Measurement type not found');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $inputType, $id)
    {

        // Validasi input
        $validatedData = $request->validate([
            'measurement_type' => 'required|string|exists:measurement_types,name',
            'measurement_time' => 'required|date|before_or_equal:now',
            'value' => 'required_if:measurement_type,!Blood Pressure|nullable|numeric|min:0|max:1000',
            'value_systolic' => 'required_if:measurement_type,Blood Pressure|nullable|numeric|min:0|max:300',
            'value_diastolic' => 'required_if:measurement_type,Blood Pressure|nullable|numeric|min:0|max:300',
            'note' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'after_meal' => 'nullable|boolean',
            'device' => 'nullable|string|max:255',
        ]);

        // Cari ID measurement type berdasarkan nama
        $measurementType = MeasurementType::where('name', $validatedData['measurement_type'])->first();

        // Buat data pengukuran baru
        $measurement = Measurement::create([
            'user_id' => $id,
            'type_id' => $measurementType->id,
            'measurement_time' => $validatedData['measurement_time'],
            'value' => $validatedData['value'] ?? null,
            'value_systolic' => $validatedData['value_systolic'] ?? null,
            'value_diastolic' => $validatedData['value_diastolic'] ?? null,
            'note' => $validatedData['note'],
        ]);

        // Buat data detail pengukuran
        MeasurementDetail::create([
            'measurement_id' => $measurement->id,
            'location' => $validatedData['location'],
            'after_meal' => $validatedData['after_meal'] ?? 0,
            'device' => $validatedData['device'],
        ]);


        if ($inputType === 'gcu') {
            return redirect()->route('measurements.index', ['id' => $id])
                ->with('success', 'Measurement stored successfully.');
        } elseif ($inputType === 'vital-signs') {
            return redirect()->route('measurements.index', ['id' => $id])
                ->with('success', 'Measurement stored successfully.');
        } else {
            abort(404, 'Measurement type not found');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, $measurementId)
    {
        // Mengambil data pengguna dari tabel users
        $user = User::findOrFail($id);

    //Begining of Passing Data Last Measurement
        $measurementTypes = MeasurementType::where('category', 'GCU')->pluck('name'); // Mengambil jenis pengukuran dari tabel measurement_types

        $vsTypes = MeasurementType::where('category', 'Vital Signs')->pluck('name');
        
        $lastMeasurements = []; // Mengambil pengukuran terakhir untuk masing-masing jenis pengukuran

        foreach ($measurementTypes as $type) {
            $lastMeasurement = Measurement::where('user_id', $id)
                ->whereHas('type', function ($query) use ($type) {
                    $query->where('name', $type);
                })
                ->orderBy('measurement_time', 'desc')
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
     //End of Passing Data Last Measurement

        $measurement = Measurement::with(['type', 'detail', 'type.units'])
            ->where('id', $measurementId)
            ->where('user_id', $id)
            ->firstOrFail();

        $userUnitPreference = UserUnitPreference::where('user_id', $id)
            ->whereHas('itemUnit', function ($query) use ($measurement) {
                $query->where('type_id', $measurement->type_id);
            })->with('itemUnit.unit')->first();

        return view('measurements.detail', [
            'id' => $id,
            'users' => $user,
            'lastMeasurements' => $lastMeasurements,
            'lastVitalSigns' => $lastVitalSigns,
            'measurement' => $measurement,
            'userUnitPreference' => $userUnitPreference,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $measurementId)
    {

        // Mengambil data pengguna dari tabel users
        $user = User::findOrFail($id);

        //Begining of Passing Data Last Measurement
        $measurementTypes = MeasurementType::where('category', 'GCU')->pluck('name'); // Mengambil jenis pengukuran dari tabel measurement_types

        $vsTypes = MeasurementType::where('category', 'Vital Signs')->pluck('name');
        
        $lastMeasurements = []; // Mengambil pengukuran terakhir untuk masing-masing jenis pengukuran

        foreach ($measurementTypes as $type) {
            $lastMeasurement = Measurement::where('user_id', $id)
                ->whereHas('type', function ($query) use ($type) {
                    $query->where('name', $type);
                })
                ->orderBy('measurement_time', 'desc')
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
        //End of Passing Data Last Measurement

        $measurement = Measurement::findOrFail($measurementId);
        $measurementDetail = MeasurementDetail::where('measurement_id', $measurementId)->first();

        // Tentukan kategori dari measurement type
        $category = $measurement->type->category;

        // Passing data yang dibutuhkan ke view yang sesuai
        $view = $category == 'GCU' ? 'measurements.edit-gcu' : 'measurements.edit-vital-signs';

        return view($view, [
            'id' => $id,
            'users' => $user,
            'measurement' => $measurement,
            'measurementDetail' => $measurementDetail,
            'lastMeasurements' => $lastMeasurements,
            'lastVitalSigns' => $lastVitalSigns,
            'isCreate' => false,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $measurementId)
    {   

        //Validasi input
        $validatedData = $request->validate([
            'measurement_type' => 'required|string|exists:measurement_types,name',
            'measurement_time' => 'required|date|before_or_equal:now',
            'value' => 'required_if:measurement_type,!Blood Pressure|nullable|numeric|min:0|max:1000',
            'value_systolic' => 'required_if:measurement_type,Blood Pressure|nullable|numeric|min:0|max:300',
            'value_diastolic' => 'required_if:measurement_type,Blood Pressure|nullable|numeric|min:0|max:300',
            'note' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'after_meal' => 'nullable|boolean',
            'device' => 'nullable|string|max:255',
        ]);

        // Cari ID measurement type berdasarkan nama
        $measurementType = MeasurementType::where('name', $validatedData['measurement_type'])->first();

        // Temukan dan update data pengukuran
        $measurement = Measurement::findOrFail($measurementId);
        $measurement->update([
            'type_id' => $measurementType->id,
            'measurement_time' => $validatedData['measurement_time'],
            'value' => $validatedData['value'] ?? null,
            'value_systolic' => $validatedData['value_systolic'] ?? null,
            'value_diastolic' => $validatedData['value_diastolic'] ?? null,
            'note' => $validatedData['note'],
        ]);

        // Temukan dan update data detail pengukuran
        $measurementDetail = MeasurementDetail::where('measurement_id', $measurementId)->first();
        $measurementDetail->update([
            'location' => $validatedData['location'],
            'after_meal' => $validatedData['after_meal'] ?? 0,
            'device' => $validatedData['device'],
        ]);


        return redirect()->route('measurements.index', ['id' => $id])
            ->with('success', 'Measurement updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $measurementId)
    {
        // Find the measurement by ID
        $measurement = Measurement::findOrFail($measurementId);

        // Delete the measurement detail first due to the foreign key constraint
        $measurement->detail()->delete();

        // Delete the measurement
        $measurement->delete();

        // Fetch updated measurements and user details
        $measurements = Measurement::where('user_id', $id)
            ->orderBy('measurement_time', 'desc')
            ->paginate(5);

        // Mengambil data pengguna dari tabel users
        $user = User::findOrFail($id);

        //Passing Data Last Measurement
        $measurementTypes = MeasurementType::where('category', 'GCU')->pluck('name'); // Mengambil jenis pengukuran dari tabel measurement_types

        $vsTypes = MeasurementType::where('category', 'Vital Signs')->pluck('name');
        
        $lastMeasurements = []; // Mengambil pengukuran terakhir untuk masing-masing jenis pengukuran

        foreach ($measurementTypes as $type) {
            $lastMeasurement = Measurement::where('user_id', $id)
                ->whereHas('type', function ($query) use ($type) {
                    $query->where('name', $type);
                })
                ->orderBy('measurement_time', 'desc')
                ->first();

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

        // Redirect to the measurements list with a success message
        return redirect()->route('measurements.index', ['id' => $id])
            ->with('success', 'Measurement deleted successfully')
            ->with('measurements', $measurements)
            ->with('users', $user)
            ->with('lastMeasurements', $lastMeasurements)
            ->with('lastVitalSigns', $lastVitalSigns);
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
 