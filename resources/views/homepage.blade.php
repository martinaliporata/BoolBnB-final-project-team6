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
                            <input class="form-control me-2 searchbar border-radius" id="autocomplete" name="indirizzo" type="search" placeholder="Inserisci un indirizzo" aria-label="Search">
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Sezione Filtri sotto la barra di ricerca -->
        <div class="container mt-3">
            <!-- Dropdown Menu per i servizi -->
            <!-- Dropdown Menu per i servizi -->
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle w-100 bg-dark" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Seleziona Servizi
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
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
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="numStanze" class="form-label">Numero di Stanze</label>
                    <input type="number" class="form-control" name="Stanze" id="Stanze" placeholder="Inserisci il numero di stanze">
                </div>
                <div class="col-md-3">
                    <label for="numLetti" class="form-label">Posti letto</label>
                    <input type="number" class="form-control" name="Letti" id="Letti" placeholder="Inserisci il numero di letti">
                </div>
                <div class="col-md-3">
                    <label for="numBagni" class="form-label">Bagni</label>
                    <input type="number" class="form-control" name="Bagni" id="Bagni" placeholder="Inserisci il numero di bagni ">
                </div>
                <div class="col-md-3">
                    <label for="priceRange" class="form-label">Prezzo (Max)</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="Prezzo" id="Prezzo" placeholder="Max €">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Cerca</button>
        </div>
    </form>
</main>
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
