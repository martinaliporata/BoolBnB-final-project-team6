@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="mb-4">Scegli la Sponsorship</h1>

                <!-- Controllo per messaggi di successo o errori -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Controllo per eventuali errori di validazione -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form per l'inserimento della sponsorship -->
                <form action="{{ route('apartment.sponsorships.store') }}" method="POST">
                    @csrf

                    <!-- Seleziona Appartamento -->
                    <div class="mb-3">
                        <label for="apartment_id" class="form-label">Seleziona Appartamento</label>
                        <select name="apartment_id" id="apartment_id" class="form-select" required>
                            <option value="" disabled selected>-- Seleziona un appartamento --</option>
                            @foreach($apartments as $apartment)
                                <option value="{{ $apartment->id }}">{{ $apartment->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Seleziona Sponsorship -->
                    <div class="mb-3">
                        <label for="sponsorship_id" class="form-label">Seleziona Sponsorship</label>
                        <select name="sponsorship_id" id="sponsorship_id" class="form-select" required>
                            <option value="" disabled selected>-- Seleziona una sponsorship --</option>
                            @foreach($sponsorships as $sponsorship)
                                <option value="{{ $sponsorship->id }}">{{ $sponsorship->name }} - Durata:
                                    @if ($sponsorship->id == 1)
                                        24 ore
                                    @elseif ($sponsorship->id == 2)
                                        72 ore
                                    @elseif ($sponsorship->id == 3)
                                        144 ore
                                    @else
                                        24 ore
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bottone per inviare il form -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Vai al pagamento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
