@extends('layouts.app')

@section('title', 'VitaLog App')

@section('content')
<div class="grid grid-cols-3 grid-rows-2 gap-10 font-metropolis">
    <div class="relative bg-base-100 nmorphn w-full max-h-full rounded-3xl shadow dark:bg-base-100 p-4 md:p-6">
      {{-- <div class="bg-primary w-[350px] h-[290px] absolute opacity-75 rounded-xl flex justify-center items-center font-semibold font-metropolis">
        Upgrade
      </div> --}}
        <div class="bg-base-100 flex justify-between pb-2.5 mb-2.5 border-b border-gray-200 dark:border-gray-700">
          <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
              <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-29.7 -29.7 356.40 356.40" xml:space="preserve" fill="#ffffff">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <g> <circle style="fill:#f3f4f6;" cx="148.5" cy="148.5" r="148.5"></circle> </g> </g> </g> <path style="fill:#f3f4f6;" d="M205.655,59.941C172.917,97.978,140.613,142.459,143.5,192.5 c1.571,20.425,6.152,50.034-4.571,69.536l33.102,33.102c69.95-11.138,123.611-71.117,124.934-143.887L205.655,59.941z"></path> <g> <g> <path style="fill:#6b7280 ;" d="M148.5,223.75L148.5,223.75c37.003,0,67-29.997,67-67V82.547 c0-17.167-13.916-31.083-31.083-31.083h-71.834C95.416,51.464,81.5,65.38,81.5,82.547v74.203 C81.5,193.753,111.497,223.75,148.5,223.75z"></path> </g> <g> <rect x="138.929" y="204.607" style="fill:#d1d1d1;" width="19.143" height="57.429"></rect> </g> <g> <path style="fill:#fff;" d="M117.127,147.179h62.746c3.818,0,6.913-3.095,6.913-6.913V77.52c0-3.818-3.095-6.913-6.913-6.913 h-62.746c-3.818,0-6.913,3.095-6.913,6.913v62.746C110.214,144.084,113.309,147.179,117.127,147.179z"></path> </g> <g> <g> <path style="fill:#fff;" d="M146.76,157.62h-27.747c-4.859,0-8.798,3.939-8.798,8.798c0,11.8,9.566,21.366,21.366,21.366 h15.179V157.62z"></path> </g> <g> <path style="fill:#fff;" d="M177.988,157.62H150.24v30.165h15.179c11.8,0,21.366-9.566,21.366-21.366 C186.786,161.559,182.847,157.62,177.988,157.62z"></path> </g> </g> </g> <g> <path style="fill:#d10049;" d="M132,115.5c0-9.113,16.5-33,16.5-33s16.5,23.887,16.5,33s-7.387,16.5-16.5,16.5 S132,124.613,132,115.5z"></path> </g> </g> </g>
              </svg>
            </div>
            <div>
              <h5 class="leading-none text-xl font-bold text-gray-900 dark:text-white pb-1">{{ round($averageGlucose, 2) }} mg/dL</h5>
              <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Average Glucose</p>
            </div>
          </div>
          <div>
            <span class="{{ $avgGlucoseIndicatorColor }} text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-green-900 dark:text-green-300">
              {!! $avgGlucoseStatus !!}
            </span>
          </div>
        </div>
      
        {{-- <div class="grid grid-cols-2">
          <dl class="flex items-center">
              <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Money spent:</dt>
              <dd class="text-gray-900 text-sm dark:text-white font-semibold">$3,232</dd>
          </dl>
          <dl class="flex items-center justify-end">
              <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Conversion rate:</dt>
              <dd class="text-gray-900 text-sm dark:text-white font-semibold">1.2%</dd>
          </dl>
        </div> --}}
      
        <div id="column-chart">

        </div>
        <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
            <div class="dropdown-container flex justify-between items-center pt-2.5">
              <!-- Button -->
                <button
                  id="dropdownGlucoseButton"
                  data-dropdown-toggle="glucoseLastDaysDropdown"
                  data-dropdown-placement="bottom"
                  class="range-button text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                  type="button"
                  >
                    {{ ucfirst(str_replace('last', 'Last ', str_replace('days', ' Days', $selectedGluRange))) }}
                    <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="glucoseLastDaysDropdown" class="range-menu z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                  <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownGlucoseButton">
                    @foreach (['yesterday', 'today', 'last7days', 'last30days', 'last90days'] as $range )
                      <li>
                        <a href="{{ route('user-dashboard', ['id' => $id, 'rangeGlu' => $range,  'rangeChol' => $selectedCholRange, 'rangeUric' => $selectedUricRange, 'rangeVs' => $selectedVsRange]) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ ucfirst(str_replace('last', 'Last ', str_replace('days', ' Days', $range))) }}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
                <a
                  href="#"
                  class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2"
                  >
                    Medical Report
                    <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-base-100 nmorphn w-full max-h-full rounded-3xl shadow dark:bg-base-100 p-4 md:p-6">
      {{-- <div class="bg-primary w-[350px] h-[290px] absolute opacity-75 rounded-xl flex justify-center items-center font-semibold font-metropolis">
        Upgrade
      </div> --}}
        <div class="bg-base-100 flex justify-between pb-2.5 mb-2.5 border-b border-gray-200 dark:border-gray-700">
          <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
              <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-29.7 -29.7 356.40 356.40" xml:space="preserve" fill="#ffffff">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <g> <circle style="fill:#f3f4f6;" cx="148.5" cy="148.5" r="148.5"></circle> </g> </g> </g> <path style="fill:#f3f4f6;" d="M205.655,59.941C172.917,97.978,140.613,142.459,143.5,192.5 c1.571,20.425,6.152,50.034-4.571,69.536l33.102,33.102c69.95-11.138,123.611-71.117,124.934-143.887L205.655,59.941z"></path> <g> <g> <path style="fill:#6b7280 ;" d="M148.5,223.75L148.5,223.75c37.003,0,67-29.997,67-67V82.547 c0-17.167-13.916-31.083-31.083-31.083h-71.834C95.416,51.464,81.5,65.38,81.5,82.547v74.203 C81.5,193.753,111.497,223.75,148.5,223.75z"></path> </g> <g> <rect x="138.929" y="204.607" style="fill:#d1d1d1;" width="19.143" height="57.429"></rect> </g> <g> <path style="fill:#fff;" d="M117.127,147.179h62.746c3.818,0,6.913-3.095,6.913-6.913V77.52c0-3.818-3.095-6.913-6.913-6.913 h-62.746c-3.818,0-6.913,3.095-6.913,6.913v62.746C110.214,144.084,113.309,147.179,117.127,147.179z"></path> </g> <g> <g> <path style="fill:#fff;" d="M146.76,157.62h-27.747c-4.859,0-8.798,3.939-8.798,8.798c0,11.8,9.566,21.366,21.366,21.366 h15.179V157.62z"></path> </g> <g> <path style="fill:#fff;" d="M177.988,157.62H150.24v30.165h15.179c11.8,0,21.366-9.566,21.366-21.366 C186.786,161.559,182.847,157.62,177.988,157.62z"></path> </g> </g> </g> <g> <path style="fill:#d10049;" d="M132,115.5c0-9.113,16.5-33,16.5-33s16.5,23.887,16.5,33s-7.387,16.5-16.5,16.5 S132,124.613,132,115.5z"></path> </g> </g> </g>
              </svg>
            </div>
            <div>
              <h5 class="leading-none text-xl font-bold text-gray-900 dark:text-white pb-1">
                {{ round($averageCholesterol, 2) }} mg/dL
              </h5>
              <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Average Cholesterol</p>
            </div>
          </div>
          <div>
            <span class="{{ $avgCholesterolIndicatorColor }} text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-green-900 dark:text-green-300">
              {!! $avgCholesterolStatus !!}
            </span>
          </div>
        </div>
      
        {{-- <div class="grid grid-cols-2">
          <dl class="flex items-center">
              <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Money spent:</dt>
              <dd class="text-gray-900 text-sm dark:text-white font-semibold">$3,232</dd>
          </dl>
          <dl class="flex items-center justify-end">
              <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Conversion rate:</dt>
              <dd class="text-gray-900 text-sm dark:text-white font-semibold">1.2%</dd>
          </dl>
        </div> --}}
      
        <div id="cholesterol-chart">

        </div>
        <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
            <div class="dropdown-container flex justify-between items-center pt-2.5">
              <!-- Button -->
                <button
                  id="dropdownCholesterolButton"
                  data-dropdown-toggle="cholLastDaysdropdown"
                  data-dropdown-placement="bottom"
                  class="range-button text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                  type="button"
                  >
                    {{ ucfirst(str_replace('last', 'Last ', str_replace('days', ' Days', $selectedCholRange))) }}
                    <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="cholLastDaysdropdown" class="range-menu z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                  <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCholesterolButton">
                    @foreach (['yesterday', 'today', 'last7days', 'last30days', 'last90days'] as $range)
                      <li>
                        <a href="{{ route('user-dashboard', ['id' => $id, 'rangeGlu' => $selectedGluRange, 'rangeChol' => $range, 'rangeUric' => $selectedUricRange, 'rangeVs' => $selectedVsRange]) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ ucfirst(str_replace('last', 'Last ', str_replace('days', ' Days', $range))) }}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
                <a
                  href="#"
                  class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2"
                  >
                    Medical Report
                    <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-base-100 nmorphn w-full max-h-full rounded-3xl shadow dark:bg-base-100 p-4 md:p-6">
      {{-- <div class="bg-primary w-[350px] h-[290px] absolute opacity-75 rounded-xl flex justify-center items-center font-semibold font-metropolis">
        Upgrade
      </div> --}}
        <div class="bg-base-100 flex justify-between pb-2.5 mb-2.5 border-b border-gray-200 dark:border-gray-700">
          <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
              <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-29.7 -29.7 356.40 356.40" xml:space="preserve" fill="#ffffff">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <g> <circle style="fill:#f3f4f6;" cx="148.5" cy="148.5" r="148.5"></circle> </g> </g> </g> <path style="fill:#f3f4f6;" d="M205.655,59.941C172.917,97.978,140.613,142.459,143.5,192.5 c1.571,20.425,6.152,50.034-4.571,69.536l33.102,33.102c69.95-11.138,123.611-71.117,124.934-143.887L205.655,59.941z"></path> <g> <g> <path style="fill:#6b7280 ;" d="M148.5,223.75L148.5,223.75c37.003,0,67-29.997,67-67V82.547 c0-17.167-13.916-31.083-31.083-31.083h-71.834C95.416,51.464,81.5,65.38,81.5,82.547v74.203 C81.5,193.753,111.497,223.75,148.5,223.75z"></path> </g> <g> <rect x="138.929" y="204.607" style="fill:#d1d1d1;" width="19.143" height="57.429"></rect> </g> <g> <path style="fill:#fff;" d="M117.127,147.179h62.746c3.818,0,6.913-3.095,6.913-6.913V77.52c0-3.818-3.095-6.913-6.913-6.913 h-62.746c-3.818,0-6.913,3.095-6.913,6.913v62.746C110.214,144.084,113.309,147.179,117.127,147.179z"></path> </g> <g> <g> <path style="fill:#fff;" d="M146.76,157.62h-27.747c-4.859,0-8.798,3.939-8.798,8.798c0,11.8,9.566,21.366,21.366,21.366 h15.179V157.62z"></path> </g> <g> <path style="fill:#fff;" d="M177.988,157.62H150.24v30.165h15.179c11.8,0,21.366-9.566,21.366-21.366 C186.786,161.559,182.847,157.62,177.988,157.62z"></path> </g> </g> </g> <g> <path style="fill:#d10049;" d="M132,115.5c0-9.113,16.5-33,16.5-33s16.5,23.887,16.5,33s-7.387,16.5-16.5,16.5 S132,124.613,132,115.5z"></path> </g> </g> </g>
              </svg>
            </div>
            <div>
              <h5 class="leading-none text-xl font-bold text-gray-900 dark:text-white pb-1">
                {{ round($averageUricAcid, 2) }} mg/dL
              </h5>
              <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Average Uric Acid</p>
            </div>
          </div>
          <div>
            <span class="{{ $avgUricAcidIndicatorColor }} text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-green-900 dark:text-green-300">
              {!! $avgUricAcidStatus !!}
            </span>
          </div>
        </div>
      
        {{-- <div class="grid grid-cols-2">
          <dl class="flex items-center">
              <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Money spent:</dt>
              <dd class="text-gray-900 text-sm dark:text-white font-semibold">$3,232</dd>
          </dl>
          <dl class="flex items-center justify-end">
              <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Conversion rate:</dt>
              <dd class="text-gray-900 text-sm dark:text-white font-semibold">1.2%</dd>
          </dl>
        </div> --}}
      
        <div id="uric-acid-chart">

        </div>
        <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
            <div class="dropdown-container flex justify-between items-center pt-2.5">
              <!-- Button -->
                <button
                  id="dropdownUricAcidButton"
                  data-dropdown-toggle="uricacidLastDaysdropdown"
                  data-dropdown-placement="bottom"
                  class="range-button text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                  type="button"
                  >
                    {{ ucfirst(str_replace('last', 'Last ', str_replace('days', ' Days', $selectedUricRange))) }}
                    <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="uricacidLastDaysdropdown" class="range-menu z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                  <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownUricAcidButton">
                    @foreach (['yesterday', 'today', 'last7days', 'last30days', 'last90days'] as $range)
                      <li>
                        <a href="{{ route('user-dashboard', ['id' => $id, 'rangeGlu' => $selectedGluRange, 'rangeChol' => $selectedCholRange, 'rangeUric' => $range, 'rangeVs' => $selectedVsRange]) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ ucfirst(str_replace('last', 'Last ', str_replace('days', ' Days', $range))) }}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
                <a
                  href="#"
                  class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                    Medical Report
                    <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div id="vs-avg" class="nmorphn relative col-span-2 p-4 rounded-3xl flex flex-row gap-4 content-between">
      {{-- <div class="bg-primary w-[805px] h-[310px] absolute opacity-75 rounded-xl flex justify-center items-center font-semibold font-metropolis">
        Upgrade
      </div> --}}
        
      <div class="nmorphu basis-2/3 w-full bg-base-100 rounded-xl shadow dark:bg-base-100 p-4 md:p-6">
        <div class="flex justify-between">
          <div>
            <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-2"> {{ round($averageHeartRate, 0) }} bpm</h5>
            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Heart rate this week</p>
          </div>
          <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
            {{-- 12% --}}
            {{-- <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
            </svg> --}}
          </div>
        </div>
        <div id="vs-chart"></div>
        <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
          <div class="flex justify-between items-center pt-5">
            <!-- Button -->
              <button
                id="dropdownDefaultButton"
                data-dropdown-toggle="lastDaysdropdown"
                data-dropdown-placement="bottom"
                class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                type="button">
                {{ ucfirst(str_replace('last', 'Last ', str_replace('days', ' Days', $selectedVsRange))) }}
                  <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                  </svg>
              </button>
            <!-- Dropdown menu -->
              <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                  @foreach (['yesterday', 'today', 'last7days', 'last30days', 'last90days'] as $range)
                    <li>
                      <a href="{{ route('user-dashboard', ['id' => $id, 'rangeGlu' => $selectedGluRange, 'rangeChol' => $selectedCholRange, 'rangeUric' => $selectedUricRange, 'rangeVs' => $range]) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ ucfirst(str_replace('last', 'Last ', str_replace('days', ' Days', $range))) }}</a>
                    </li>
                  @endforeach
                </ul>
              </div>
              <a
                href="#"
                class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                  Medical Report
                  <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                  </svg>
              </a>
          </div>
        </div>
      </div>

      <div class="basis-1/3 grid grid-cols-5 grid-rows-5 gap-4">
          <p class="col-span-2 font-medium italic ">Vital Signs</p>
          {{-- <div class="col-span-3">
              <button class="bg-base-100 btn nmorphn w-full">
                  Weekly
              </button>
          </div> --}}
          <div class="col-span-5">
              {{-- <button class="bg-base-100 btn nmorphn w-full">
                  Heart Rate
              </button> --}}
          </div>
          <div id="status-wrapper" class="col-span-5 text-center pt-4">
              <p class="text-sm font-metropolis font-semibold">Powered By:</p>
          </div>
          <div class="nmorphu rounded-xl col-span-5 row-span-2 flex justify-center items-center">
            <a href="https://digitalacademy.jabarprov.go.id/" target="_blank" rel="noopener noreferrer">
              <img class="w-[75px] h-[75px]" src="{{ '/images/jda-logo.png' }}" alt="logo jabar digital academy">
            </a>
            <a href="https://alkademi.id/" target="_blank" rel="noopener noreferrer">
              <img class="w-[75px] h-[75px]" src="{{ '/images/alkademi-logo.png' }}" alt="logo alkademi">
            </a>
            <a href="https://aws.amazon.com/id/about-aws/global-infrastructure/aws-incommunities/" target="_blank" rel="noopener noreferrer">
              <img class="w-[75px] h-[75px]" src="{{ '/images/aws-logo.png' }}" alt="logo aws incommunities">
            </a>
            
          </div>
      </div>
    </div>

    <div id="ads" class="nmorphu rounded-3xl">
        <img class="nmorphu rounded-3xl h-full" alt="ads" src="{{ asset('images/ads.jpg') }}">
    </div>
</div>

<input type="hidden" id="user-id" value="{{ $id }}">


<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Glucose Dropdown
    const dropdownButtonGlu = document.getElementById('dropdownGlucoseButton');
    const dropdownMenuGlu = document.getElementById('glucoseLastDaysDropdown');
    
    dropdownButtonGlu.addEventListener('click', function () {
        dropdownMenuGlu.classList.toggle('hidden');
    });
    document.addEventListener('click', function (event) {
        if (!dropdownButtonGlu.contains(event.target) && !dropdownMenuGlu.contains(event.target)) {
            dropdownMenuGlu.classList.add('hidden');
        }
    });

    // Cholesterol Dropdown
    const dropdownButtonChol = document.getElementById('dropdownCholesterolButton');
    const dropdownMenuChol = document.getElementById('cholesterolLastDaysDropdown');

    dropdownButtonChol.addEventListener('click', function () {
        dropdownMenuChol.classList.toggle('hidden');
    });
    document.addEventListener('click', function (event) {
        if (!dropdownButtonChol.contains(event.target) && !dropdownMenuChol.contains(event.target)) {
            dropdownMenuChol.classList.add('hidden');
        }
    });

    // Uric Acid Dropdown
    const dropdownButtonUric = document.getElementById('dropdownUricAcidButton');
    const dropdownMenuUric = document.getElementById('uricacidLastDaysDropdown');

    dropdownButtonUric.addEventListener('click', function () {
        dropdownMenuUric.classList.toggle('hidden');
    });
    document.addEventListener('click', function (event) {
        if (!dropdownButtonUric.contains(event.target) && !dropdownMenuUric.contains(event.target)) {
            dropdownMenuUric.classList.add('hidden');
        }
    });
  });
</script>
@endsection