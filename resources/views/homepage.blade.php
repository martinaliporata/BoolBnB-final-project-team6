@extends('layouts.app')
@section('content')
<main>
   <div class="container home-background">
       <div class="opaco"></div>
   </div>

 <!-- Form di ricerca -->
 <form action="{{ route('search') }}" method="GET">
    @csrf
       <div class="container-search">
            <div class="container-searchsection">
                <!-- Barra di ricerca -->
                <nav class="navbar navbar-custom bg-body-tertiary bg-primary border-radius" data-bs-theme="dark">
                    <div class="container-fluid">
                        <div class="d-flex w-100">
                            <input class="form-control me-2 searchbar border-radius" name="city" type="search" placeholder="Inserisci un indirizzo o città" aria-label="Search">
                        </div>
                    </div>
                </nav>
            </div>
       </div>

       <!-- Sezione Filtri sotto la barra di ricerca -->
       <div class="container mt-3">
            <!-- Dropdown Menu per i servizi -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle w-100 bg-dark" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Seleziona Servizi
                </button>
                <div class="btn-group flex-wrap" role="group" aria-label="Basic checkbox toggle button group">
                    @foreach ($servizi as $servizio)
                    <input name="services[]" type="checkbox" class="btn-check" id="service-check-{{$servizio->id}}" autocomplete="off" value="{{$servizio->id}}">
                    <label class="btn btn-outline-primary m-1 btn-sm rounded mb-2" for="service-check-{{$servizio->id}}">
                        {{$servizi->Nome}}
                    </label>
                    @endforeach
                </div>

                <!--'WiFi gratuito',
                'Colazione inclusa',
                'Aria condizionata',
                'Parcheggio gratuito',
                'Servizio in camera',
                'Animali ammessi',
                'Piscina',
                'Palestra',
                'Spa e centro benessere',
                'TV satellitare',
                'Minibar',
                'Cassaforte in camera',
                'Accesso per disabili',
                'Deposito bagagli',
                'Servizio navetta',
                'Noleggio biciclette',
                'Area giochi per bambini',
                'Sala conferenze',
                'Bar',
                'Ristorante',
                'Servizio lavanderia',
                'Asciugacapelli',
                'Ferro da stiro',
                'Reception 24 ore su 24'-->
                </ul>
            </div>

            <!-- Campi aggiuntivi per stanze, letti, prezzo e numero di persone -->
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="numStanze" class="form-label">Numero di Stanze</label>
                    <input type="number" class="form-control" name="numStanze" id="numStanze" placeholder="Inserisci il numero di stanze">
                </div>
                <div class="col-md-3">
                    <label for="numLetti" class="form-label">Posti letto</label>
                    <input type="number" class="form-control" name="numLetti" id="numLetti" placeholder="Inserisci il numero di letti">
                </div>
                <div class="col-md-3">
                    <label for="numBagni" class="form-label">Bagni</label>
                    <input type="number" class="form-control" name="numBagni" id="numBagni" placeholder="Inserisci il numero di bagni ">
                </div>
                <div class="col-md-3">
                    <label for="priceRange" class="form-label">Prezzo (Min-Max)</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="priceMin" id="priceMin" placeholder="Min €">
                        <input type="number" class="form-control" name="priceMax" id="priceMax" placeholder="Max €">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Cerca</button>
       </div>
   </form>
</main>
@endsection
