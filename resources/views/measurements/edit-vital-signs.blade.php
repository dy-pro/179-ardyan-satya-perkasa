@extends('layouts.app')

@section('title', 'Edit Your Vital Signs | VitaLog App')

@section('content')
    <div id="vital-signs-edit" class="nmorphu rounded-3xl p-6 flex flex-col gap-6 h-[600px]font-metropolis font-semibold text-sm">
        <div class="h-[56px] flex items-center justify-between">
            <p id="input-title" class="font-metropolis font-semibold text-2xl">
                Edit Your Measurement
            </p>
            <div class="join nmorphn">
                <input id="body-temperature" class="join-item btn bg-base-100" type="radio" name="options" value="Body Temperature" aria-label="Body Temperature" {{ old('measurement_type', $measurement->type->name) == 'Body Temperature' ? 'checked' : '' }} />
                <input id="blood-pressure" class="join-item btn bg-base-100" type="radio" name="options" value="Blood Pressure" aria-label="Blood Pressure" {{ old('measurement_type', $measurement->type->name) == 'Blood Pressure' ? 'checked' : '' }} />
                <input id="oxygen-saturation" class="join-item btn bg-base-100" type="radio" name="options" value="Oxygen Saturation" aria-label="Spo2" {{ old('measurement_type', $measurement->type->name) == 'Oxygen Saturation' ? 'checked' : '' }} />
                <input id="respiration-rate" class="join-item btn bg-base-100" type="radio" name="options" value="Respiration Rate" aria-label="RR" {{ old('measurement_type', $measurement->type->name) == 'Respiration Rate' ? 'checked' : '' }} />
                <input id="heart-rate" class="join-item btn bg-base-100" type="radio" name="options" value="Heart Rate" aria-label="Pulse" {{ old('measurement_type', $measurement->type->name) == 'Heart Rate' ? 'checked' : '' }} />
            </div>
        </div>

        <div class="nmorphn rounded-xl flex flex-col h-[555px] ">
            <form 
                action="{{ route('measurements.update', ['id' => $id, 'measurementId' => $measurement->id]) }}" 
                method="POST" 
                class="flex gap-4 h-full"
                >
                @csrf
                @method('PUT')
                <div class="basis-1/2 flex flex-col gap-5 py-6">
                    <input 
                        type="hidden" 
                        id="selected-option" 
                        name="measurement_type" 
                        value="{{ old('measurement_type', $measurement->type->name) }}"
                    > <!-- Hidden input for storing selected radio button value -->
                    
                    @include('measurements._form_fields', ['measurement' => $measurement, 'measurementDetail' => $measurementDetail])
                </div>

                <div class="basis-1/2 flex flex-col justify-between items-center gap-2.5 py-20">
                    <div id="value-field" class="flex flex-col gap-2.5 items-center">
                        <label for="value">value</label>
                        <input 
                            type="text" 
                            id="value" 
                            name="value" 
                            value="{{ old('value', $measurement->value) }}" 
                            class="input input-bordered w-[204px] h-[72px] nmorphu max-w-xs text-center font-omegle text-[40px]"
                        >
                        @error('value')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="blood-pressure-value-field" class="flex flex-col gap-2.5 items-center hidden">
                        <label for="value_systolic">Systolic</label>
                        <input 
                            type="text" 
                            id="value_systolic" 
                            name="value_systolic" 
                            value="{{ old('value_systolic', $measurement->value_systolic) }}"
                            class="input input-bordered w-[204px] h-[72px] nmorphu max-w-xs text-center font-omegle text-[40px]" 
                        />
                        @error('value_systolic')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
            
                        <label for="value_diastolic">Diastolic</label>
                        <input 
                            type="text" 
                            id="value_diastolic" 
                            name="value_diastolic" 
                            value="{{ old('value_diastolic', $measurement->value_diastolic) }}"
                            class="input input-bordered w-[204px] h-[72px] nmorphu max-w-xs text-center font-omegle text-[40px]" 
                        />
                        @error('value_diastolic')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        {{-- <span>Status:</span> --}}
                    </div>
                    
                    <input type="submit" value="Update" class="btn nmorphn bg-base-100 w-[204px]" />

                </div>
            </form>
        </div>
    </div>

    
    <script>
        // Dynamic title according to radio button
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll('input[name="options"]');
            const title = document.getElementById('input-title');

            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.checked) {
                    title.textContent = 'Input Your ' + this.value;
                    }
                });
            });

            // Set the initial title based on the selected radio button
            const selectedRadio = document.querySelector('input[name="options"]:checked');
            if (selectedRadio) {
                title.textContent = 'Edit Your ' + selectedRadio.value;
            }
        });

        

        //Updating measurement type value
        document.addEventListener('DOMContentLoaded', (event) => {
            const radioButtons = document.querySelectorAll('input[name="options"]');
            const hiddenInput = document.getElementById('selected-option');
            const singleValueField = document.getElementById('value-field');
            const doubleValueFields = document.getElementById('blood-pressure-value-field');

            radioButtons.forEach(radio => {
                radio.addEventListener('change', (event) => {
                    hiddenInput.value = event.target.value;

                    if (event.target.value === 'Blood Pressure') {
                        singleValueField.classList.add('hidden');
                        doubleValueFields.classList.remove('hidden');
                    } else {
                        singleValueField.classList.remove('hidden');
                        doubleValueFields.classList.add('hidden');
                    }
                });
            });
        
            // Set the hidden input value based on the selected radio button initially
            const selectedRadio = document.querySelector('input[name="options"]:checked');
            if (selectedRadio) {
                hiddenInput.value = selectedRadio.value;

                if (selectedRadio.value === 'Blood Pressure') {
                    singleValueField.classList.add('hidden');
                    doubleValueFields.classList.remove('hidden');
                }
            }
        });
    </script>
        
@endsection