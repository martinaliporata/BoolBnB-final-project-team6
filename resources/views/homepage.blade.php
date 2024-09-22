@extends('layouts.app')

@section('title', 'Benvenuto')

@section('content')

<div class="header text-center">
    <h1>Benvenuto su BoolBnb</h1>
    <p>Trova la tua casa perfetta, ovunque nel mondo!</p>
</div>

<div class="row mt-5">
    <div class="col-md-6 offset-md-3 text-center">
        <img src="https://www.visitscotland.com/binaries/content/gallery/visitscotland/cms-images/2022/12/01/exclusiveuse.jpg" class="img-fluid main-image" alt="BoolBnb Special">
        <p class="mt-4">
            BoolBnb ti offre una vasta selezione di alloggi unici, dagli appartamenti moderni ai
            rifugi immersi nella natura. Prenota ora e vivi esperienze indimenticabili ovunque tu
            vada!
        </p>
    </div>
</div>

<div class="footer row pt-5 text-center">
    <h2 class="mb-4">Perché scegliere BoolBnb?</h2>
    <div class="col-md-4">
        <img class="w-25" src="{{ Vite::asset('resources/images/customer-service.png') }}" alt="Assistenza 24/7">
        <p>Assistenza 24/7</p>
    </div>
    <div class="col-md-4">
        <img class="w-25" src="{{Vite::asset('resources/images/housepng.png')}}" alt="Alloggi Unici">
        <p>Alloggi Unici</p>
    </div>
    <div class="col-md-4">
        <img class="w-25" src="{{Vite::asset('resources/images/sheet_8861435.png')}}" alt="Prenotazione Facile">
        <p>Prenotazione Facile</p>
    </div>
</div>

@endsection
