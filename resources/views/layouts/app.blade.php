<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('/styles.css') }}">
    <title>@yield('title')</title>
</head>
<body class="bg-base-100 flex flex-row-reverse p-20 gap-10">
    <div id="hm-wrapper" class="basis-3/4 flex flex-col gap-10">
        <header class="max-h-[280px] flex flex-row gap-10">
            <div id="title-container" class="basis-2/3 flex flex-col gap-10">
                <h1 class="font-omegle text-[64px] leading-none h-1/2">
                    <a href="{{ route('user-dashboard', ['id' => $id]) }}">VitaLog</a>
                </h1>
                <p class="font-metropolis text-[54px] font-thin leading-[3.5rem] h-1/2">
                    {!! $users->name != null ? "Hi, ".$users->name."<br /> Catat gula darahmu, yuk!"  : "Hi!<br /> Sudah catat gula darah hari ini?" !!}
                </p>
            </div>

            <div id="util-container" class="basis-1/3 grid grid-cols-3 grid-rows-2 justify-items-center gap-10">
                <div id="date-container" class="basis-2/3 col-span-2 w-full flex flex-col items-center">
                    <span id="date" class="font-metropolis font-thin text-7xl">
                        {{ now()->format('d') }}
                    </span>
                    <span id="month" class="font-metropolis font-semibold text-4xl">
                        {{ now()->format('M \'y') }}
                    </span>
                </div>

                <div id="menu-container" class="drawer drawer-end basis-1/3 col-span-1 p-6 flex justify-center items-center">
                    <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
                    <div class="drawer-content nmorphn w-full h-full flex justify-center items-center rounded-box">
                        <!-- Page content here -->
                        <label for="my-drawer-4" class="drawer-button">
                            <img src="{{ asset('images/menu.png') }}" alt="menu icon">
                        </label>
                    </div>    
                    <div class="drawer-side z-[2]">
                        <label for="my-drawer-4" aria-label="close sidebar" class="drawer-overlay"></label>
                        <ul class="menu p-4 w-80 min-h-full bg-base-100">
                            
                            @if(isset($id))
                                <li>
                                    <a href="{{ route('measurements.index', ['id' => $id]) }}">All Measurements</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ url('all-measurements') }}">All Measurements</a>
                                </li>
                            @endif
                                <li><a href="/settings">Settings</a></li>
                                @if(session()->get('isLogged'))
                                <li>
                                    <a href="{{ route('auth.logout') }}">Logout</a>
                                </li>
                                @endif
                        </ul>
                    </div>       
                </div>
                
                <div id="measurement-button" class="basis-1/2 col-span-3 w-full p-6 dropdown">
                    <div tabindex="0" role="button" class="btn nmorphn bg-base-100 w-full h-full">
                        <img src="{{ asset('images/add.png') }}" alt="menu icon">
                        <span class="font-metropolis font-extrabold text-3xl mx-2 text-primary">Measure Now</span>
                    </div>
                    <ul tabindex="0" class="nmorphn dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-b-lg w-[15.5rem]">
                            <li>
                                <a id="input-gcu" href="{{ route('measurements.input', ['inputType' => 'gcu', 'id' => $id]) }}">GCU</a>
                            </li>
                            <li>
                                <a id="input-vital-signs" href="{{ route('measurements.input', ['inputType' => 'vital-signs', 'id' => $id]) }}">Vital Signs</a>
                            </li>       
                    </ul>
                </div>
            </div>
        </header>

        <main>
            @yield('content')
        </main>
    
    </div>
    
    <aside class="nmorphn rounded-3xl basis-1/4 p-4 flex flex-col gap-4 font-metropolis text-sm font-semibold">

        @if(!empty($users))
        <section id="user-info" class="basis-1/5 flex flex-col items-center gap-2.5">
            <div id="user-photo" class="nmorphn flex justify-center items-center rounded-xl">
                <div class="h-[107px] w-[107px] flex justify-center items-center">
                    <a href="{{ route('user-dashboard', ['id' => $id]) }}">
                    @if($users->photo)
                        <img 
                            class="rounded-md h-[95px] w-[95px]"
                            src="{{ asset($users->photo) }}"
                            alt="user-photo" 
                        />
                    @elseif($users->photo == null)
                        @if($users->gender == "L")
                        <img 
                            class="rounded-md h-[95px] w-[95px]"
                            src="{{ asset('images/user-photo-m.png') }}" 
                            alt="user-photo" 
                        />
                        @else
                        <img 
                            class="rounded-md h-[95px] w-[95px]"
                            src="{{ asset('images/user-photo-f.png') }}" 
                            alt="user-photo" 
                        />
                        @endif
                    @endif
                    </a>
                </div>
            </div>

            <div class="flex flex-col gap-2.5 items-center">
                <p>{!! $users->name ?? "Guest User" !!}</p>
                <p>{!! $users->email ?? "&nbsp;" !!}</p>
            </div>
        </section>

        <section id="last-gcu-measurement" class="basis-1/5 flex justify-between gap-4 font-metropolis text-sm font-semibold">
            @foreach($lastMeasurements as $type => $lastMeasurement)
                <div id="last-{{ strtolower(str_replace(' ', '-', $type)) }}" class="nmorphn basis-1/3 p-2.5 rounded-xl flex flex-col gap-2 items-center justify-between">
                    <div class="nmorphu-sm w-[35px] h-[35px] rounded-full flex justify-center items-center">
                        <img class="w-6 h-6" src="{{ asset('images/glucometer.png') }}" alt="{{ $type }} icon">
                    </div>
                    <div class="flex justify-center items-center">
                        <p>
                            {{ $type }}
                        </p>
                    </div>
                    <div class="{{ $lastMeasurement->indicatorColor ?? 'bg-base-100' }} nmorphu-g w-full rounded-md p-4 flex flex-col justify-center items-center">
                        <p class="font-omegle text-2xl leading-3.5 text-info-content">
                            {{ $lastMeasurement->value ?? 'N/A' }}
                        </p>
                        <p class="text-[10px] text-info-content">mg/dL</p>
                    </div>
                </div>
            @endforeach
        </section>

        <section id="last-vs-measurement" class="basis-3/5 grid grid-cols-2 grid-rows-3 gap-4">
            @forEach($lastVitalSigns as $vsType => $lastVitalSign)
            <div id="last-{{ strtolower(str_replace(' ', '-', $vsType)) }}" class="nmorphn rounded-xl p-4 flex flex-col gap-1.5 justify-between">
                <div class="nmorphu-sm w-[35px] h-[35px] rounded-full flex justify-center items-center">
                    <img 
                        class="w-6 h-6"
                        src="{{ asset('images/' . strtolower(str_replace(' ', '-', $vsType)) . '.png') }}"
                        alt="{{ $vsType }} icon">
                </div>
                <p>
                    {{ $vsType }}
                </p>
                <div class="nmorphu-g w-full rounded-md p-4 text-info-content">
                    @if(isset($id))
                        @if($vsType != 'Blood Pressure')          
                        <p class="font-omegle text-2xl">
                            {{ $lastVitalSign->value ?? 'N/A' }}
                        </p>
                        @else
                        <p class="font-omegle text-2xl">
                            {{ $lastVitalSign->value_systolic ?? 'N/A' }} / {{ $lastVitalSign->value_diastolic ?? 'N/A' }}
                        </p>
                        @endif
                    @else
                        <p class="font-omegle text-2xl">
                            -
                        </p>
                    @endif
                    <p class="text-[10px]">
                        {!! $lastVitalSign->unit ?? "&nbsp" !!}
                    </p>
                </div>
            </div>
            {{-- @endif --}}
            @endforeach
        </section>
        @else
            <div role="alert" class="alert alert-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>You have to login first.</span>
              </div>
        @endif
    </aside>

    {{-- JS --}}

    <script>
        document.getElementById('myDropdown').addEventListener('change', function() {
            var selectedValue = this.value;
            var currentUrl = window.location.href.split('?')[0];
            window.location.href = currentUrl + '?selectedOption=' + selectedValue;
        });
    </script>

    <script>
        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function myFunction() {
          document.getElementById("myDropdown").classList.toggle("show");
        }
        
        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
          if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("drop-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
              var openDropdown = dropdowns[i];
              if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
              }
            }
          }
        }
    </script>
</body>
</html>
