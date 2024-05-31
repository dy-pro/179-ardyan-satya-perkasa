@extends('layouts.app')

@section('title', 'Input Your Vital Signs | VitaLog App')

@section('content')
    <div id="vital-signs-input" class="nmorphu rounded-3xl p-6 flex flex-col gap-6 h-[600px]font-metropolis font-semibold text-sm">
        <div class="h-[56px] flex items-center justify-between">
            <p id="input-title" class="font-metropolis font-semibold text-2xl">
                Input Your Temperature
            </p>
            <div class="join nmorphn">
                <input id="body-temperature" class="join-item btn bg-base-100" type="radio" name="options" value="Body Temperature" aria-label="Body Temperature" checked />
                <input id="blood-pressure"  class="join-item btn bg-base-100" type="radio" name="options" value="Blood Pressure" aria-label="Blood Pressure" />
                <input id="oxygen-saturation" class="join-item btn bg-base-100" type="radio" name="options" value="Oxygen Saturation" aria-label="Oxygen Saturation" />
                <input id="respiration-rate" class="join-item btn bg-base-100" type="radio" name="options" value="Respiration Rate" aria-label="Respiration Rate" />
                <input id="heart-rate" class="join-item btn bg-base-100" type="radio" name="options" value="Heart Rate" aria-label="Heart Rate" />
            </div>
        </div>

        <div class="nmorphn rounded-xl flex flex-col h-[555px] ">
            <form 
                action="{{ route('measurements.store', ['inputType' => 'vital-signs', 'id' => $id]) }}" 
                method="POST" 
                class="flex gap-4 h-full"
                >
                @csrf
                <div class="basis-1/2 flex flex-col gap-5 py-6">
                    <input 
                        type="hidden" 
                        id="selected-option" 
                        name="measurement_type" 
                        value="Body Temperature"
                    /> <!-- Hidden input for storing selected radio button value -->
                    
                    @include('measurements._form_fields')
                </div>

                <div class="basis-1/2 flex flex-col justify-between items-center gap-2.5 py-20">
                    
                    <div id="value-field" class="flex flex-col gap-2.5 items-center">
                        <label for="value">value</label>
                        <input 
                            type="text" 
                            id="value" 
                            name="value" 
                            placeholder="000" 
                            class="input input-bordered w-[204px] h-[72px] nmorphu max-w-xs text-center font-omegle text-[40px]"
                        />
                        @error('value')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="blood-pressure-value-fields" class="flex flex-col gap-2.5 items-center hidden">
                        <label for="value_systolic">Systolic</label>
                        <input 
                            type="text" 
                            id="value_systolic" 
                            name="value_systolic" 
                            placeholder="000" 
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
                            placeholder="000" 
                            class="input input-bordered w-[204px] h-[72px] nmorphu max-w-xs text-center font-omegle text-[40px]" 
                        />
                        @error('value_diastolic')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        {{-- <span>Status:</span> --}}
                    </div>
                    
                    <input type="submit" value="Save" class="btn bg-base-100 nmorphn w-[204px]" />

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
        });

        //Updating measurement type value
        document.addEventListener('DOMContentLoaded', (event) => {
            const radioButtons = document.querySelectorAll('input[name="options"]');
            const hiddenInput = document.getElementById('selected-option');
            const singleValueField = document.getElementById('value-field');
            const doubleValueFields = document.getElementById('blood-pressure-value-fields');

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
        });
    </script>
        
@endsection