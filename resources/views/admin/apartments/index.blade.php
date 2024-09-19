@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="container home-background-2">
                <div class="opaco"></div>
            </div>
            {{-- Form di ricerca --}}
            <form action="{{ route('search') }}" method="GET">
                @csrf
                <div class="container-search">
                    <div class="container-searchsection">
                        <!-- Barra di ricerca -->
                        <nav class="navbar navbar-custom bg-body-tertiary bg-primary border-radius" data-bs-theme="dark">
                            <div class="container-fluid">
                                <div class="d-flex w-100">
                                    <input class="form-control me-2 searchbar border-radius" id="autocomplete" name="indirizzo" type="search" placeholder="Inserisci un indirizzo" aria-label="Search">
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
                            <!-- Opzioni dei servizi -->
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="1"> WiFi gratuito</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="2"> Colazione inclusa</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="3"> Aria condizionata</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="4"> Parcheggio gratuito</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="5"> Servizio in camera</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="6"> Animali ammessi</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="7"> Piscina</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="8"> Palestra</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="9"> Spa e centro benessere</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="10"> TV satellitare</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="11"> Minibar</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="12"> Cassaforte in camera</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="13"> Accesso per disabili</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="14"> Deposito bagagli</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="15"> Servizio navetta</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="16"> Noleggio biciclette</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="17"> Area giochi per bambini</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="18"> Sala conferenze</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="19"> Bar</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="20"> Ristorante</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="21"> Servizio lavanderia</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="22"> Asciugacapelli</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="23"> Ferro da stiro</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" name="services[]" value="24"> Reception 24 ore su 24</label></li>
                        </ul>
                    </div>


                    <!-- Campi aggiuntivi per stanze, letti, prezzo e numero di persone -->
                    <div class="row mt-3 justify-content-center">
                        <div class="col-md-2">
                            <label for="numStanze" class="form-label">Numero di stanze</label>
                            <input type="number" class="form-control" name="Stanze" id="Stanze" placeholder="Inserisci il numero di stanze">
                        </div>
                        <div class="col-md-2">
                            <label for="numLetti" class="form-label">Numero di posti letto</label>
                            <input type="number" class="form-control" name="Letti" id="Letti" placeholder="Inserisci il numero di letti">
                        </div>
                        <div class="col-md-2">
                            <label for="numBagni" class="form-label">Numero di bagni</label>
                            <input type="number" class="form-control" name="Bagni" id="Bagni" placeholder="Inserisci il numero di bagni ">
                        </div>
                        <div class="col-md-2">
                            <label for="priceRange" class="form-label">Prezzo (max)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="Prezzo" id="Prezzo" placeholder="Inserisci il prezzo">
                            </div>
                        </div>
                        <!-- Campo per il raggio di ricerca -->
                        <div class="col-md-2">
                            <label for="radius" class="form-label">Raggio di ricerca (km)</label>
                            <input type="number" class="form-control" name="radius" id="radius" min="1" max="20" value="20" placeholder="20 km">
                            <small class="form-text text-muted">Il raggio di ricerca può essere modificato solo per ridurre il valore.</small>
                        </div>
                        <!-- Pulsante con icona SVG -->
                        <button type="submit" class="btn btn-primary btn-custom d-flex align-items-center justify-content-center">
                            <!-- Icona SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search me-2" viewBox="0 0 16 16">
                                <path d="M11.742 10.742a5.5 5.5 0 1 0-1.415 1.415l3.8 3.8a1 1 0 0 0 1.414-1.414l-3.8-3.8zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                            Cerca
                        </button>
                    </div>
                </div>
            </form>

            <div class="col-12 text-center">
                <h1>
                    Appartamenti
                </h1>
                <div class="row">
                    @foreach ($apartments as $apartment)
                        <article class="col-4 text-center">
                            <div class="card shadow" style="w-100">
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
                                    <a href="{{ route('apartments.show', $apartment) }}" class="btn btn-primary">Mostra dettagli</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDltqF-8vne8sd6KUee2_G8eWD24UIBYWI&loading=async&libraries=places&callback=initMap"></script>
    <script>
    function initMap() {
        var input = document.getElementById('autocomplete');
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                console.log("Nessun luogo trovato per l'input: '" + place.name + "'");
                return;
            }
            console.log('Luogo selezionato:', place);
        });
    }
    </script>
@endsection
