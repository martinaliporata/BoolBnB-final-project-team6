@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1>
                    Appartamenti
                </h1>
                <div class="row">
                    @foreach ($apartments as $apartment)
                        <article class="col-4 text-center">
                            <div class="card shadow" style="w-100">
                                <img class="card-img-top" src="{{ $apartment->Img }}" alt="">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{ $apartment->Nome }}
                                    </h5>
                                    <p class="card-text">
                                        <br> Stanze: {{ $apartment->Stanze }}
                                        <br> Letti: {{ $apartment->Letti }}
                                        <br> Bagni: {{ $apartment->Bagni }}
                                        <br> Prezzo: &euro;{{ $apartment->Prezzo }}
                                        <br> Metri quadrati: {{ $apartment->Metri_quadrati }} mq
                                        <br> Indirizzo: {{ $apartment->Indirizzo }}
                                    </p>
                                    <a href="{{ route('apartments.show', $apartment) }}" class="btn btn-primary">Mostra dettagli</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
