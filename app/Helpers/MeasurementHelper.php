<?php

namespace App\Helpers;

class MeasurementHelper {
    public static function getMeasurementsById($id) {

        $icons = [
            'temp' => '/images/temp.png',
            'bp' => '/images/blood-pressure.png',
            'spo2' => '/images/spo2.png',
            'rr' => '/images/rr.png',
            'hr' => '/images/heart-rate.png',
        ];
        
        $measurements = [
            ['id' => 1, 'user_id' => 1, 'type' => 'Glucose', 'category' => 'GCU', 'value' => 120, 'unit' => 'mg/dL'],
            ['id' => 2, 'user_id' => 1, 'type' => 'Cholesterol', 'category' => 'GCU','value' => 180, 'unit' => 'mg/dL'],
            ['id' => 3, 'user_id' => 1, 'type' => 'Urid Acid', 'category' => 'GCU','value' => 5.5, 'unit' => 'mg/dL'],
            ['id' => 4, 'user_id' => 1, 'type' => 'Temperature', 'category' => 'Vital Signs', 'icon' => $icons['temp'],'value' => 36, 'unit' => '°C'],
            ['id' => 5, 'user_id' => 1, 'type' => 'Blood Pressure', 'category' => 'Vital Signs', 'icon' => $icons['bp'], 'value_systolic' => 110, 'value_diastolic' => 76, 'unit' => 'mmHg'],
            ['id' => 6, 'user_id' => 1, 'type' => 'Oxygen Saturation', 'category' => 'Vital Signs', 'icon' => $icons['spo2'], 'value' => 100, 'unit' => '%'],
            ['id' => 7, 'user_id' => 1, 'type' => 'Respiration Rate', 'category' => 'Vital Signs', 'icon' => $icons['rr'], 'value' => 18, 'unit' => 'bpm'],
            ['id' => 8, 'user_id' => 1, 'type' => 'Heart Rate', 'category' => 'Vital Signs', 'icon' => $icons['hr'], 'value' => 85, 'unit' => 'bpm'],
            ['id' => 9, 'user_id' => 2, 'type' => 'Glucose', 'category' => 'GCU','value' => 110, 'unit' => 'mg/dL'],
            ['id' => 10, 'user_id' => 2, 'type' => 'Cholesterol', 'category' => 'GCU','value' => 175, 'unit' => 'mg/dL'],
            ['id' => 11, 'user_id' => 2, 'type' => 'Urid Acid', 'category' => 'GCU','value' => 5.0, 'unit' => 'mg/dL'],
            ['id' => 12, 'user_id' => 2, 'type' => 'Temperature', 'category' => 'Vital Signs', 'icon' => $icons['temp'], 'value' => 35.5, 'unit' => '°C'],
            ['id' => 13, 'user_id' => 2, 'type' => 'Blood Pressure', 'category' => 'Vital Signs', 'icon' => $icons['bp'], 'value_systolic' => 140, 'value_diastolic' => 73, 'unit' => 'mmHg'],
            ['id' => 14, 'user_id' => 2, 'type' => 'Oxygen Saturation', 'category' => 'Vital Signs', 'icon' => $icons['spo2'], 'value' => 98, 'unit' => '%'],
            ['id' => 15, 'user_id' => 2, 'type' => 'Respiration Rate', 'category' => 'Vital Signs', 'icon' => $icons['rr'], 'value' => 20, 'unit' => 'bpm'],
            ['id' => 16, 'user_id' => 2, 'type' => 'Heart Rate', 'category' => 'Vital Signs', 'icon' => $icons['hr'], 'value' => 80, 'unit' => 'bpm'],
            ['id' => 17, 'user_id' => 3, 'type' => 'Glucose', 'category' => 'GCU','value' => 130, 'unit' => 'mg/dL'],
            ['id' => 18, 'user_id' => 3, 'type' => 'Cholesterol', 'category' => 'GCU','value' => 190, 'unit' => 'mg/dL'],
            ['id' => 19, 'user_id' => 3, 'type' => 'Urid Acid', 'category' => 'GCU','value' => 6.0, 'unit' => 'mg/dL'],
            ['id' => 20, 'user_id' => 3, 'type' => 'Temperature', 'category' => 'Vital Signs', 'icon' => $icons['temp'], 'value' => 38, 'unit' => '°C'],
            ['id' => 21, 'user_id' => 3, 'type' => 'Blood Pressure', 'category' => 'Vital Signs', 'icon' => $icons['bp'], 'value_systolic' => 98, 'value_diastolic' => 77, 'unit' => 'mmHg'],
            ['id' => 22, 'user_id' => 3, 'type' => 'Oxygen Saturation', 'category' => 'Vital Signs', 'icon' => $icons['spo2'], 'value' => 72, 'unit' => '%'],
            ['id' => 23, 'user_id' => 3, 'type' => 'Respiration Rate', 'category' => 'Vital Signs', 'icon' => $icons['rr'], 'value' => 21, 'unit' => 'bpm'],
            ['id' => 24, 'user_id' => 3, 'type' => 'Heart Rate', 'category' => 'Vital Signs', 'icon' => $icons['hr'], 'value' => null, 'unit' => 'bpm'],
        ];

        return $measurements;
    }
     
}