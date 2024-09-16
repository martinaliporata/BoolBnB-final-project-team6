@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <article class="col-12 p-3 text-center">
                <div class="card p-3" style="w-100">
                    <img class="card-img-top w-100" src="{{ $apartment->Img }}" alt="">
                    <div class="card-body">
                        <h5 class="card-title">
                            <p class="card-text">Nome: {{$apartment->Nome}}</p>
                        </h5>
                    </div>
                    <ul class="list-unstyled">
                        <li>Prezzo: &euro;{{ $apartment->Prezzo }}</li>
                        <li>Stanze: {{ $apartment->Stanze }}</li>
                        <li>Letti: {{ $apartment->Letti }}</li>
                        <li>Bagni: {{ $apartment->Bagni }}</li>
                        <li>Metri quadrati: {{ $apartment->Metri_quadrati }} mq</li>
                        <li>Indirizzo: {{ $apartment->Indirizzo }}</li>
                        <li>
                            @forelse ($apartment->services as $service)
                            <span class="badge text bg-primary">{{ $service->Nome}}</span>
                            @empty
                            Non ci sono servizi
                            @endforelse

                        </li>
                    </ul>
                    <div class="card-footer">
                        <a href="{{ route('apartments.index') }}" class="btn btn-primary">Torna alla lista appartamenti</a>

                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection
{{--
@section('custom-scripts')
    @vite('resources/js/delete-confirm.js')
@endsection --}}
