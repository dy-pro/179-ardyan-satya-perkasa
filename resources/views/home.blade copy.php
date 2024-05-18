<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('/styles.css') }}">
    <title>VitaLog Apps</title>
</head>
<body>
    <div id="hm-wrapper">
        <header>
            <div id="title-container">
                <h1>VitaLog</h1>
                <p>{!! $name != null ? "Hi, ".$name."<br /> Catat gula darahmu, yuk!"  : "Hi!<br /> Sudah catat gula darah hari ini?" !!}</p>
            </div>
    
            <div id="util-container">
                <div id="dm-wrapper">
                    <div id="date-container">
                        <p id="date">27</p>
                        <p id="month">Dec '24</p>
                    </div>
        
                    <div id="menu-container">
                        <nav>
                            <img src="{{ asset('images/menu.png') }}" alt="menu icon">
                        </nav>
                    </div>
                </div>
    
                <div id="measurement-container">
                    <div id="measurement-button">
                        <button class="button">Measure Now</button>
                        <div class="dropdown-content">
                            <a id="glucose" href="/input-glucose">Glucose</a>
                            <a id="cholesterol" href="/input-cholesterol">Cholesterol</a>
                            <a id="urid-acid" href="/input-urid-acid">Urid Acid</a>
                          </div>
                    </div>
                </div>
            </div>
        </header>
            
        <main>
            <div id="glucose-avg" class="card-avg">
                <p>Average Glucose</p>
                <div class="btn-time-range">
                    <button>
                        Weekly
                    </button>
                </div>
                <div class="chart-container"></div>
            </div>
    
            <div id="cholesterol-avg" class="card-avg">
                <p>Average Cholesterol</p>
                <div class="btn-time-range">
                    <button>
                        Weekly
                    </button>
                </div>
                <div class="chart-container"></div>
            </div>
    
            <div id="urid-acid-avg" class="card-avg">
                <p>Average Urid Acid</p>
                <div class="btn-time-range">
                    <button>
                        Weekly
                    </button>
                </div>
                <div class="chart-container"></div>
            </div>
    
            <div id="vs-avg" class="card-avg">
                <div class="chart-container"></div>
                <div class="wrapper">
                    <p>Vital Signs</p>
                    <div class="btn-time-range">
                        <button>
                            Weekly
                        </button>
                    </div>
                    <div class="btn-vs-option">
                        <button>
                            Blood Pressure
                        </button>
                    </div>
                    <div id="status-wrapper">
                        <p>Status: Normal</p>
                    </div>
                    <div class="value-container"></div>
                </div>
            </div>
    
            <div id="ads" class="card-avg">
                <img id="img" alt="ads" src="{{ asset('images/ads.jpg') }}">
            </div>
        </main>
    </div>
    

    <aside>
        <div class="wrapper">
            <section id="user-info" class="inner-wrapper">

                <div id="user-photo">
                    <img src="{{ asset('images/user-photo.png') }}" alt="user-photo">
                </div>
    
                <p>{{ $name }}</p>
                <p>{{ $email }}</p>
    
            </section>
    
            <section id="last-gcu-measurement" class="inner-wrapper">
                <div id="last-glucose" class="last-gcu">
                    <img src="{{ asset('images/glucometer.png') }}" alt="gcu icon">
                    <p>Glucose</p>
                    <div class="value-container">
                        <p>300</p>
                        <p class="unit">mg/dL</p>
                    </div>
                </div>
    
                <div id="last-cholesterol" class="last-gcu">
                    <img src="{{ asset('images/glucometer.png') }}" alt="gcu icon">
                    <p>Cholesterol</p>
                    <div class="value-container">
                        <p>286</p>
                        <p class="unit">mg/dL</p>
                    </div>
                </div>
                
                <div id="last-urid-acid" class="last-gcu">
                    <img src="{{ asset('images/glucometer.png') }}" alt="gcu icon">
                    <p>Urid Acid</p>
                    <div class="value-container">
                        <p>179</p>
                        <p class="unit">mg/dL</p>
                    </div>
                </div>
            </section>

            <section id="last-vs-measurement" class="inner-wrapper">
                <div id="last-bt" class="last-vs">
                    <img src="{{ asset('images/temp.png') }}" alt="temperature icon">
                    <p>Temperature</p>
                    <div class="value-container">
                        <p>36</p>
                        <p class="unit">°C</p>
                    </div>
                </div>
    
                <div id="last-bp" class="last-vs">
                    <img src="{{ asset('images/blood-pressure.png') }}" alt="blood-pressure icon">
                    <p>Blood Pressure</p>
                    <div class="value-container">
                        <p>110/75</p>
                        <p class="unit">mmHg</p>
                    </div>
                </div>
    
                <div id="last-spo2" class="last-vs">
                    <img src="{{ asset('images/spo2.png') }}" alt="oxygen saturation icon">
                    <p>Oxygen Saturation</p>
                    <div class="value-container">
                        <p>100</p>
                        <p class="unit">%</p>
                    </div>
                </div>
    
                <div id="last-rr" class="last-vs">
                    <img src="{{ asset('images/rr.png') }}" alt="respiration rate icon">
                    <p>Respiration Rate</p>
                    <div class="value-container">
                        <p>18</p>
                        <p class="unit">bpm</p>
                    </div>
                </div>
    
                <div id="last-hr" class="last-vs">
                    <img src="{{ asset('images/heart-rate.png') }}" alt="heart rate icon">
                    <p>Heart Rate</p>
                    <div class="value-container">
                        <p>80</p>
                        <p class="unit">bpm</p>
                    </div>
                </div>
            </section>
        </div>
    </aside>
    
</body>
</html>
