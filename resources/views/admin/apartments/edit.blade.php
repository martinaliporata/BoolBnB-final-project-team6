@extends('layouts.app')

@yield('page-title', '')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="mb-3 text-center">
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
            <form action="{{ route('apartments.update', $apartment) }}" method="POST" id="edit_form">
                @method('PUT')
                @csrf
                <div class="input-group-m container mb-5 w-50">

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
                    <input type="text" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Indirizzo" id="Indirizzo" name="Indirizzo" value="{{ old('Indirizzo', $apartment->Indirizzo) }}">


                    <label for="citta"><strong>Città</strong></label>
                    <input type="text" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Città" id="citta" name="citta" value="{{ old('Indirizzo', $apartment->citta) }}">


                    <label for="Prezzo"><strong>Prezzo</strong></label>
                    <input min="10" type="number" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Prezzo" id="Prezzo" name="Prezzo" value="{{ old('Prezzo', $apartment->Prezzo) }}">


                    <label for="Img"><strong>Img</strong></label>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Img" id="Img" name="Img" value="{{ old('Img', $apartment->Img) }}">


                    <label for="service_id"><strong>Servizi</strong></label>
                    <div class="btn-group flex-wrap" role="group" aria-label="Basic checkbox toggle button group">
                        @foreach ($services as $service)
                            <input name="services[]" type="checkbox" class="btn-check"
                                id="service-check-{{ $service->id }}" autocomplete="off" value="{{ $service->id }}"
                                @if (in_array($service->id, old('services', $apartment->services->pluck('id')->toArray()))) checked @endif>
                            <label class="btn btn-outline-primary m-1 btn-sm rounded mb-2"
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
@endsection
