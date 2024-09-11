@extends('layouts.app')
@section('content')
<main>
   <div class="container home-background">
       <div class="opaco"></div>
   </div>
   <div class="container-search">
        <div class="container-searchsection">
            <!-- Barra di ricerca -->
            <nav class="navbar navbar-custom bg-body-tertiary bg-primary border-radius" data-bs-theme="dark">
                <div class="container-fluid">
                    <form class="d-flex w-100" role="search">
                        <input class="form-control me-2 searchbar border-radius" type="search" placeholder="Inserisci un indirizzo o città" aria-label="Search">
                    </form>
                </div>
            </nav>
        </div>
   </div>

   <!-- Sezione Filtri sotto la barra di ricerca -->
   <div class="container mt-3">
        <!-- Dropdown Menu per i servizi -->
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle w-100 " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" >
                Seleziona Servizi
            </button>
            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item " href="#"><input type="checkbox" name="wifi" id="wifi"> WiFi</a></li>
                <li><a class="dropdown-item" href="#"><input type="checkbox" name="parking" id="parking"> Parcheggio</a></li>
                <li><a class="dropdown-item" href="#"><input type="checkbox" name="pool" id="pool"> Piscina</a></li>
                <li><a class="dropdown-item" href="#"><input type="checkbox" name="air_conditioning" id="air_conditioning"> Aria Condizionata</a></li>
                <li><a class="dropdown-item" href="#"><input type="checkbox" name="pets" id="pets"> Animali ammessi</a></li>
            </ul>
        </div>

        <!-- Campi aggiuntivi per stanze, letti e range di prezzo -->
        <div class="row mt-3">
            <div class="col-md-4">
                <label for="numStanze" class="form-label">Numero di Stanze</label>
                <input type="number" class="form-control" id="numStanze" placeholder="Inserisci il numero di stanze">
            </div>
            <div class="col-md-4">
                <label for="numLetti" class="form-label">Numero di Letti</label>
                <input type="number" class="form-control" id="numLetti" placeholder="Inserisci il numero di letti">
            </div>
            <div class="col-md-4">
                <label for="priceRange" class="form-label">Prezzo (Min-Max)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="priceMin" placeholder="Min €">
                    <input type="number" class="form-control" id="priceMax" placeholder="Max €">
                </div>
            </div>
        </div>
   </div>
</main>
@endsection

