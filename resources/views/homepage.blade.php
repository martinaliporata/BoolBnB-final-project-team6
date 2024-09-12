@extends('layouts.app')
@section('content')
<main>
   <div class="container home-background">
       <div class="opaco"></div>
   </div>

   <!-- Form di ricerca -->
   <form action="{{ route('search') }}" method="GET">
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
                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#"><input type="checkbox" name="services[]" value="wifi"> WiFi</a></li>
                    <li><a class="dropdown-item" href="#"><input type="checkbox" name="services[]" value="parking"> Parcheggio</a></li>
                    <li><a class="dropdown-item" href="#"><input type="checkbox" name="services[]" value="pool"> Piscina</a></li>
                    <li><a class="dropdown-item" href="#"><input type="checkbox" name="services[]" value="air_conditioning"> Aria Condizionata</a></li>
                    <li><a class="dropdown-item" href="#"><input type="checkbox" name="services[]" value="pets"> Animali ammessi</a></li>
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
