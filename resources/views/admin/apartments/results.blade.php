@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Risultati della Ricerca</h1>

    @if($apartments->isEmpty())
        <p>Nessun appartamento trovato con i criteri forniti.</p>
    @else
        <div class="row">
            @foreach($apartments as $apartment)
            <article class="col-4 text-center">
                <div class="card shadow">
                    <img class="w-100 h-100 object-fit-cover" src="{{ $apartment->Img }}" alt="">
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
    @endif
</div>
@endsection
