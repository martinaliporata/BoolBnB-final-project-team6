@extends('layouts.app')

@yield('page-title', '')

@section('content')
    <div class="background-create-edit">
        <div class="row justify-content-center">
            <h1 class="mb-3 text-center mt-2">
                Modifica {{ $apartment->Nome }}
            </h1>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-12">
            <form action="{{ route('apartments.update', $apartment) }}" method="POST" id="edit_form" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="input-group-m container mb-5 w-50 message-body">

                    <label for="nome"><strong>Nome</strong></label>
                    <input type="text" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="nome" id="nome" name="Nome" value="{{ old('Nome', $apartment->Nome) }}">


                    <label for="stanze"><strong>Stanze</strong></label>
                    <input min="1" type="number" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="stanze" id="stanze" name="Stanze" value="{{ old('Stanze', $apartment->Stanze) }}">


                    <label for="letti"><strong>Letti</strong></label>
                    <input min="1" type="number" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="letti" id="letti" name="Letti" value="{{ old('Letti', $apartment->Letti) }}">


                    <label for="bagni"><strong>Bagni</strong></label>
                    <input min="1" type="number" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="bagni" id="bagni" name="Bagni" value="{{ old('Bagni', $apartment->Bagni) }}">


                    <label for="Metri_quadrati"><strong>Metri quadrati</strong></label>
                    <input min="10" type="number" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Metri quadrati" id="Metri_quadrati" name="Metri_quadrati" value="{{ old('Metri_quadrati', $apartment->Metri_quadrati) }}">


                    <label for="Indirizzo"><strong>Indirizzo</strong></label>
                    {{-- <input type="text" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Indirizzo" id="Indirizzo" name="Indirizzo" value="{{ old('Indirizzo', $apartment->Indirizzo) }}"> --}}
                    <input class="form-control me-2 searchbar border-radius" id="autocomplete" name="Indirizzo" type="search" placeholder="Inserisci un indirizzo" aria-label="Search" name="Indirizzo" value="{{ old('Indirizzo', $apartment->Indirizzo) }}">


                    <label class="mt-2" for="Prezzo"><strong>Prezzo</strong></label>
                    <input min="10" type="number" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Prezzo" id="Prezzo" name="Prezzo" value="{{ $apartment->Prezzo, old('Prezzo') }}">

                    <label for="Img"><strong>Immagine</strong></label>
                    <br>
                    <input type="file" name="Img" id="Img">

                    <br><br>

                    <label for="service_id"><strong>Servizi</strong></label>
                    <div class="btn-group flex-wrap" role="group" aria-label="Basic checkbox toggle button group">
                        @foreach ($services as $service)
                            <input name="services[]" type="checkbox" class="btn-check"
                                id="service-check-{{ $service->id }}" autocomplete="off" value="{{ $service->id }}"
                                @if (in_array($service->id, old('services', $apartment->services->pluck('id')->toArray()))) checked @endif>
                                <label class="btn btn-outline-danger color-services m-1 btn-sm rounded mb-2"
                                for="service-check-{{ $service->id }}">
                                    {{ $service->Nome }}
                                </label>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center mb-3">
                    <div class="input">
                        <input class="btn btn-success" type="submit" value="Modifica">
                        <input class="btn btn-secondary" type="reset" value="Reset">
                    </div>
                </div>
            </form>
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
