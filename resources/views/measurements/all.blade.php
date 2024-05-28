@extends('layouts.app')

@section('title', 'All Measurments | VitaLog App')

@section('content')
    <div id="all-measurements" class="nmorphn p-6 rounded-3xl flex flex-col  gap-6 font-metropolis">
        <div class="h-[56px]">
            <p class="font-semibold text-2xl">
                All Measurements
            </p>
        </div>

        <div class="">
            @if(!empty($measurements))
            <table class="table text-sm">
                <thead class="text-sm">
                    <tr>
                        <th scope="col">Measurement Time</th>
                        <th scope="col">Measurement Type</th>
                        <th scope="col" class="text-center">Value</th>
                        {{-- <th scope="col">Input Time</th> --}}
                        {{-- <th scope="col">Update Time</th> --}}
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($measurements as $measurement)
                        <tr>
                            <td>{{ $measurement->measurement_time }}</td>
                            <td>{{ $measurement->type->name }}</td>
                            <td class="text-center">
                                @if($measurement->type->name == "Blood Pressure")
                                    {{ 'Systolic: '.$measurement->value_systolic }} / {{ 'Diastolic: '.$measurement->value_diastolic }}
                                @else
                                    {{ $measurement->value }}
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <div tabindex="0" role="button" class="btn bg-base-100 nmorphn m-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg></div>
                                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 rounded-box w-52 bg-base-100 nmorphn">
                                        <li><a>Detail</a></li>
                                        <li><a href="{{ route('measurements.edit', ['id' => $id, 'measurementId' => $measurement->id]) }}">Edit</a></li>
                                        <li>
                                            <form action="{{ route('measurements.destroy', ['id' => $id, 'measurementId' => $measurement->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                  </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $measurements->links('vendor.pagination.daisy') }} <!-- Pagination Links -->
            </div>
            @else
                <p>No measurement found.</p>
            @endif
        </div>
    </div>
@endsection