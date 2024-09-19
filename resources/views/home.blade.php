@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (session('message_trash'))
                <div class="alert alert-success">
                    {{ session('message_trash') }}
                </div>
            @endif
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            {{-- Sezione Foto Profilo e Bottoni --}}
                            <div class="d-flex flex-column col-4 align-items-center me-4">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/profile_photos/' . Auth::user()->profile_photo) }}" alt="Profile Photo" class="w-25 border-5 rounded mb-2" id="profile-photo">
                                    <button type="button" class="btn btn-warning btn-sm" id="change-photo-btn">Cambia foto</button>
                                    <div class="form" id="photo-form" style="display: none; margin-top: 10px;">
                                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input type="file" name="profile_photo" id="profile_photo" class="form-control my-2">
                                            <button type="submit" class="btn btn-primary btn-sm">Salva nuova foto</button>
                                            <button type="button" class="btn btn-secondary btn-sm" id="cancel-change-btn">Annulla</button>
                                        </form>
                                    </div>
                                @else
                                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="profile_photo" class="form-label">Foto Profilo</label>
                                            <input type="file" name="profile_photo" id="profile_photo" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Salva</button>
                                    </form>
                                @endif
                            </div>

                            {{-- Sezione Dati Utente --}}
                            <div class="ms-3">
                                <h3 class="mb-1">{{ Auth::user()->name }} {{ Auth::user()->surname }}</h3>
                                <h5 class="mb-2">{{ Auth::user()->birth_date }}</h5>
                                <a href="mailto:{{ Auth::user()->email }}" class="d-block mb-2">{{ Auth::user()->email }}</a>
                                <a href="{{ route('admin.messages.index') }}" class="btn btn-info btn-sm me-2">Visualizza Messaggi Ricevuti</a>
                                <a href="{{ route('apartments.create') }}" class="btn btn-success btn-sm">Aggiungi appartamento</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h1>Appartamenti</h1>

                        <div class="row">
                            @foreach ($apartments as $apartment)
                                <article class="col-md-4 col-sm-6 mb-4">
                                    <div class="card shadow-sm">
                                        <img class="card-img-top" src="{{ $apartment->Img }}" alt="{{ $apartment->Nome }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $apartment->Nome }}</h5>
                                            <p class="card-text">
                                                Stanze: {{ $apartment->Stanze }}<br>
                                                Letti: {{ $apartment->Letti }}<br>
                                                Bagni: {{ $apartment->Bagni }}<br>
                                                Prezzo: &euro;{{ $apartment->Prezzo }}<br>
                                                Metri quadrati: {{ $apartment->Metri_quadrati }} mq<br>
                                                Indirizzo: {{ $apartment->Indirizzo }}
                                            </p>
                                            <a href="{{ route('apartments.show', $apartment) }}" class="btn btn-primary btn-sm me-2">Mostra dettagli</a>
                                            <a href="{{ route('apartments.edit', $apartment) }}" class="btn btn-warning btn-sm me-2">Modifica</a>
                                            <form action="{{ route('apartments.destroy', $apartment) }}" method="POST" class="d-inline-block delete-form" data_apartment_id="{{ $apartment->id }}" data_apartment_name="{{ $apartment->Nome }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Elimina</button>
                                            </form>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lightbox --}}
    <div id="lightbox" class="lightbox">
        <span class="close" id="lightbox-close">&times;</span>
        <img id="lightbox-image" src="" alt="Enlarged Profile Photo">
    </div>

@endsection
