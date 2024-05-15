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
    <header>
        <div id="title-container">
            <h1>VitaLog</h1>
            <p>Hai, Ardy<br />
                Catat gula darahmu, yuk!
            </p>
        </div>

        <div id="util-container">
            <div id="menu-container">

            </div>
            <div id="measurement-container">
                <a href="/input-glucose">Measure Now</a>
            </div>
        </div>
    </header>
        
    <main>
        <div id="glucose-avg">
            <p>Average Glucose</p>
        </div>

        <div id="cholesterol-avg">
            <p>Average Cholesterol</p>
        </div>

        <div id="urid-acid-avg">
            <p>Average Urid Acid</p>
        </div>

        <div id="vs-avg">
            <p>Vital Signs</p>
        </div>

        <div id="ads">
            <img src="" alt="">
        </div>

    </main>

    <aside>
        <section id="user-info">

            <div id="user-photo">

            </div>

            <p>Ardyan Satya</p>
            <p>ardyan.satya@gmail.com</p>

        </section>

        <section id="last-measurement">
            <div id="last-glucose">
                <img src="" alt="">
                <p>Glucose</p>
            </div>

            <div id="last-cholesterol">
                <img src="" alt="">
                <p>Cholesterol</p>
            </div>
            
            <div id="last-urid-acid">
                <img src="" alt="">
                <p>Urid Acid</p>
            </div>

            <div id="last-bt">
                <img src="" alt="">
                <p>Temperature</p>
            </div>

            <div id="last-bp">
                <img src="" alt="">
                <p>Blood Pressure</p>
            </div>

            <div id="last-spo2">
                <img src="" alt="">
                <p>Oxygen Saturation</p>
            </div>

            <div id="last-rr">
                <img src="" alt="">
                <p>Respiration Rate</p>
            </div>

            <div id="last-hr">
                <img src="" alt="">
                <p>Heart Rate</p>
            </div>
        </section>
    </aside>
    
</body>
</html>
