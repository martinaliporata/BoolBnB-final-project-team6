@extends('layouts.app')

@section('content')
    <div class=" general_background">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card my-5 color-background-card">
                    <div class="card-header d-flex justify-content-between color-header-card">
                        <strong>{{ __('I miei appartamenti') }}</strong>
                        <a href="{{ route('apartments.create') }}" class="my-1 btn button-color btn-sm">Aggiungi appartamento</a>
                    </div>

                    <div class="card-body ">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row ">
                            @foreach ($apartments as $apartment)
                                <article class="col-4 text-center ">
                                    <div class="card shadow background-color-minicard" style="w-100">
                                        <img class="card-img-top" src="{{ filter_var($apartment->Img, FILTER_VALIDATE_URL) ? $apartment->Img : asset('storage/images_apartment/' . $apartment->Img) }}" alt="{{ $apartment->Img }}">
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
                                            <a href="{{ route('apartments.show', $apartment) }}" class="my-1 btn btn-primary btn-sm">Mostra dettagli</a>
                                            <a href="{{ route('apartments.edit', $apartment) }}" class="my-1 btn btn-warning btn-sm">Modifica</a>
                                            <form action="{{ route('apartments.destroy', $apartment) }}" method="POST" class="d-inline-block delete-form mx-2" data_apartment_id="{{ $apartment->id }}" data_apartment_name="{{ $apartment->Nome }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="my-1 btn btn-danger btn-sm">Elimina</button>
                                            </form>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
