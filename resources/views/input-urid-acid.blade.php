@extends('layouts.app')

@section('title', 'Input Your Urid Acid| VitaLog App')

@section('content')
    <div id="urid-acid-input" class="card-input">
        <div class="form-title">
            <h1>Input Your Urid Acid</h1>
        </div>

        <div class="form-wrapper">
            <form action="">
                <div class="form-left-section">
                    <div>
                        <label for="">Date & Time Measurement</label>
                        <input type="text">
                    </div>
                    
                    <div>
                        <label for="">Measurement After a Meal</label>
                        <input type="checkbox" name="" id="">
                    </div>
                    
                    <div>
                        <label for="">Location</label>
                        <input type="text">
                    </div>
                    
                    <div>
                        <label for="">Device</label>
                        <input type="text">
                    </div>
                    
                    <div>
                        <label for="">Note</label>
                        <textarea name="" id="" cols="31" rows="5"></textarea>
                    </div>
                </div>

                <div class="form-right-section">
                    <label for="">value</label>
                    <input type="text">

                    <input type="submit" value="Save">

                </div>
                
            </form>
        </div>
        
    </div>
@endsection