@extends('layouts.app')

@section('content')
    <div class="general_background">
        <div class="row justify-content-center">
            @if (session('message_trash'))
                <div class="alert alert-success">
                    {{ session('message_trash') }}
                </div>
            @endif
            <div class="col-md-8">
                <div class="card  my-5 color-background-card">
                    <div class="card-header color-header-card">
                        <div class="d-flex align-items-center">
                            {{-- Sezione Foto Profilo e Bottoni --}}
                            <div class="d-flex flex-column col-4 align-items-center me-4">
                                @if(Auth::user()->profile_photo)
                                    <div id="profile-photo-container">
                                        <img src="{{ asset('storage/profile_photos/' . Auth::user()->profile_photo) }}" alt="Profile Photo" id="profile-photo">
                                        <i class="fa-regular fa-pen-to-square" id="change-photo-btn"></i>
                                    </div>
                                    <button type="button" class="btn btn-warning btn-sm mt-2" id="change-photo-btn">Cambia foto</button>
                                    <div class="form" id="photo-form" style="display: none;">
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
                                <a href="{{ route('admin.messages.index') }}" class="btn  btn-sm me-2 button-color">
                                    Visualizza Messaggi Ricevuti
                                    @if($unreadMessagesCount > 0)
                                        <span class="badge bg-danger">{{ $unreadMessagesCount }}</span>
                                    @endif
                                </a>
                                {{-- <a href="{{ route('admin.messages.index') }}" class="btn btn-info btn-sm me-2 position-relative">
                                    Visualizza Messaggi Ricevuti
                                    @if($unreadMessagesCount > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.75rem;">
                                            {{ $unreadMessagesCount }}
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    @endif
                                </a> --}}
                                <a href="{{ route('apartments.create') }}" class="btn button-color  btn-sm">Aggiungi appartamento</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h1 class="color-title-card">Appartamenti</h1>

                        <div class="row">
                            @foreach ($apartments as $apartment)
                                <article class="col-md-4 col-sm-6 mb-4 h-50" >
                                    <div class="card shadow-sm background-color-minicard h-100">
                                        <img class="card-img-top my-img-size" src="{{ filter_var($apartment->Img, FILTER_VALIDATE_URL) ? $apartment->Img : asset('storage/images_apartment/' . $apartment->Img) }}" alt="{{ $apartment->Nome }}">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $apartment->Nome }}</h4>
                                            <p class="card-text">
                                                <ul class="list-unstyled">
                                                    <li><strong>Stanze:</strong> {{ $apartment->Stanze }}</li>
                                                    <li><strong>Letti:</strong> {{ $apartment->Letti }}</li>
                                                    <li><strong>Bagni:</strong> {{ $apartment->Bagni }}</li>
                                                    <li><strong>Prezzo:</strong> &euro;{{ $apartment->Prezzo }}</li>
                                                    <li><strong>Metri quadrati:</strong> {{ $apartment->Metri_quadrati }} mq</li>
                                                    <li><strong>Indirizzo:</strong> {{ $apartment->Indirizzo }}</li>
                                                </ul>
                                            </p>
                                            <a href="{{ route('apartments.show', $apartment) }}" class="btn btn-primary btn-sm me-2"><i class="fa-regular fa-eye"></i></a>
                                            <a href="{{ route('apartments.edit', $apartment) }}" class="btn btn-warning btn-sm me-2"><i class="fa-regular fa-pen-to-square"></i></a>
                                            <form action="{{ route('apartments.destroy', $apartment) }}" method="POST" class="d-inline-block delete-form" data_apartment_id="{{ $apartment->id }}" data_apartment_name="{{ $apartment->Nome }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-x"></i></button>
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


    <div id="lightbox" class="lightbox">
        <span class="close" id="lightbox-close">&times;</span>
        <img id="lightbox-image" src="" alt="Enlarged Profile Photo">
    </div>

@endsection
