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
                                        {{ $apartment->id }}
                                    </h5>
                                    <p class="card-text">
                                        <br> Stanze: {{ $apartment->Stanze }}
                                        <br> Letti: {{ $apartment->Letti }}
                                        <br> Bagni: {{ $apartment->Bagni }}
                                        <br> Metri quadrati: {{ $apartment->Metri_quadrati }}
                                        <br> Indirizzo: {{ $apartment->Indirizzo }}
                                        <br> Latitudine: {{ $apartment->Latitudine }}
                                        <br> Longitudine: {{ $apartment->Longitudine }}
                                    </p>
                                    <a href="{{ route('apartments.show', $apartment) }}" class="btn btn-primary">Mostra dettagli</a>
                                    <a href="{{ route('apartments.edit', $apartment) }}" class="btn btn-warning">Modifica</a>
                                    <form action="{{ route('apartments.destroy', $apartment) }}" method="POST" class="d-inline-block delete-form mx-2" data_apartment_id="{{ $apartment->id }}" data_apartment_name="{{ $apartment->Nome }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
{{--
@section('custom-scripts')
    @vite('resources/js/delete-confirm.js')
@endsection --}}
