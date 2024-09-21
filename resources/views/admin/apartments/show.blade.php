@extends('layouts.app')
@section('content')
    <div class="general_background">
        <div class="row justify-content-center">
            <!-- Manteniamo il formato card -->
            <div class="col-7 mt-5 text-start">
                <div class="card shadow background-color-minicard" style="width: 100%;">
                    <!-- Immagine ridimensionata con classi per larghezza -->
                    <img class="card-img-top" src="{{ filter_var($apartment->Img, FILTER_VALIDATE_URL) ? $apartment->Img : asset('storage/images_apartment/' . $apartment->Img) }}" alt="{{ $apartment->Img }}" style="width: 100%; height: auto; max-height: 200px; object-fit: cover;">
                    <div class="card-show-ap p-3">
                        <!-- Titolo dell'appartamento -->
                        <h4 class="card-title">{{ $apartment->Nome }}</h4>
                        <!-- Informazioni aggiuntive dell'appartamento -->
                        <ul class="list-unstyled">
                            <li><strong>Stanze:</strong> {{ $apartment->Stanze }}</li>
                            <li><strong>Letti:</strong> {{ $apartment->Letti }}</li>
                            <li><strong>Bagni:</strong> {{ $apartment->Bagni }}</li>
                            <li><strong>Prezzo:</strong> &euro;{{ $apartment->Prezzo }}</li>
                            <li><strong>Metri quadrati:</strong> {{ $apartment->Metri_quadrati }} mq</li>
                            <li><strong>Indirizzo:</strong> {{ $apartment->Indirizzo }}</li>
                        </ul>

                        <!-- Contenitore servizi e pulsante, impostati in colonna -->
                        <div class="d-flex flex-column">
                            <!-- Servizi in riga -->
                            <div class="d-flex flex-wrap mb-3">
                                @forelse ($apartment->services as $service)
                                    <span class="badge text button-color me-2 mb-2">{{ $service->Nome}}</span>
                                @empty
                                    <span>Non ci sono servizi</span>
                                @endforelse
                            </div>

                            <!-- Pulsante per tornare alla lista appartamenti, centrato -->
                            <div class="mt-1 text-center">
                                <a href="/home" class="btn btn-primary">Torna alla lista appartamenti</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
