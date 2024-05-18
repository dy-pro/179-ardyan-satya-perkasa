@extends('layouts.app')

@section('title', 'VitaLog App')

@section('content')
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
@endsection