<div class="basis-1/8 h-[43px] flex gap-2.5">
    <label for="measurement_time" class="basis-1/2 text-right">
        Measurement Time
    </label>
    <input 
        type="datetime-local" 
        id="measurement_time" 
        name="measurement_time" 
        value="{{ old('measurement_time', $isCreate ? '' : ($measurement->measurement_time ?? '')) }}" 
        class="input input-bordered nmorphu w-full max-w-xs" 
        required 
    />
    @error('measurement_time')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<div class="basis-1/8 h-[43px] flex gap-2.5">
    <label for="after_meal" class="basis-1/2  text-right">
        After a Meal?
    </label>
    <div class="basis-1/2">
        <input 
            type="hidden" 
            name="after_meal" 
            value="0"
        /> {{-- Nilai default untuk toogle agar nilai defaultnya tidak string (on) --}}
        <input 
            type="checkbox" 
            id="after_meal" 
            name="after_meal" 
            value="1" {{ old('after_meal', isset($measurementDetail) ? $measurementDetail->after_meal : false) ? 'checked' : '' }} 
            class="toggle toggle-success" 
        />
    </div>
    @error('after_meal')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<div class="basis-1/8 h-[43px] flex gap-2.5">
    <label for="loacation" class="basis-1/2 text-right">Location</label>
    <input 
        type="text" 
        id="loacation" 
        name="location" 
        placeholder="Type here" 
        value="{{ old('location', isset($measurementDetail) ? $measurementDetail->location : '') }}" 
        class="input input-bordered nmorphu w-full max-w-xs" 
    />
    @error('location')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<div class="basis-1/8 h-[43px] flex gap-2.5">
    <label for="device" class="basis-1/2 text-right">Device</label>
    <input 
        type="text" 
        id="device" 
        name="device" 
        placeholder="Type here" 
        value="{{ old('device', isset($measurementDetail) ? $measurementDetail->device : '') }}" 
        class="input input-bordered nmorphu w-full max-w-xs"
    />
    @error('device')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<div class="basis-2/8 h-[107px] flex gap-2.5">
    <label for="note" class="basis-1/2 text-right">Note</label>
    <textarea 
        name="note" 
        id="note" 
        placeholder="Note" 
        class="textarea textarea-bordered textarea-lg nmorphu w-full max-w-xs"
        >
        {{ old('note', $measurement->note ?? '') }}
    </textarea>
    @error('note')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>

<script>
    //Waktu lokal pengguna
    document.addEventListener('DOMContentLoaded', function() {
        const measurementTimeField = document.getElementById('measurement_time');
        if (measurementTimeField && measurementTimeField.value === '') {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            
            measurementTimeField.max = formattedDateTime;

            if (measurementTimeField.value === '' && "{{ $isCreate }}") {
                measurementTimeField.value = formattedDateTime;
            }
        }
    });
</script>