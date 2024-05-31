@extends('layouts.app')

@section('title', 'Detail | VitaLog App')

@section('content')
<div id="all-measurements" class="nmorphn p-6 rounded-3xl flex flex-col  gap-6 font-metropolis">
    <div class="h-[56px]">
        <p class="font-semibold text-2xl">
            Detail Pengukuran
        </p>
    </div>

    <div>
        <table class="table">
            <tr>
                <th>ID Pengukuran</th>
                <td>{{ $measurement->id }}</td>
            </tr>
            <tr>
                <th>Tipe Pengukuran</th>
                <td>{{ $measurement->type->name }}</td>
            </tr>
            <tr>
                <th>Measurement Time</th>
                <td>{{ $measurement->measurement_time }}</td>
            </tr>
            <tr>
                <th>Nilai Pengukuran</th>
                <td>
                    @if($measurement->type->name == 'Blood Pressure')
                        {{ $measurement->value_systolic }}/{{ $measurement->value_diastolic }}
                    @else
                        {{ $measurement->value }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Unit</th>
                <td>
                    {{ $userUnitPreference ? $userUnitPreference->itemUnit->unit->unit : 'N/A' }}
                </td>
            </tr>
            <tr>
                <th>After Meal</th>
                <td>{{ $measurement->detail->after_meal ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th>Location</th>
                <td>{{ $measurement->detail->location }}</td>
            </tr>
            <tr>
                <th>Device</th>
                <td>{{ $measurement->detail->device }}</td>
            </tr>
            <tr>
                <th>Note</th>
                <td>{{ $measurement->note }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
