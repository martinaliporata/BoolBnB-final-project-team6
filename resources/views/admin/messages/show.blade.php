@extends('layouts.app')

@section('content')
    <div class="general_background">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5 color-background-card">
                    <div class="card-header color-header-card">Messaggio di {{ $message->Mail }}</div>

                    <div class="card-body message-body">
                        <h5><strong>Nome Appartamento:</strong> {{ $message->apartment->Nome }}</h5>
                        <p><strong>Email Mittente:</strong> {{ $message->Mail }}</p>
                        <p><strong>Testo Messaggio:</strong></p>
                        <p>{{ $message->Testo }}</p>
                        <p><strong>Data Ricezione:</strong> {{ $message->created_at->format('d/m/Y H:i') }}</p>

                        <a href="{{ route('admin.messages.index') }}" class="btn  button-color">Torna ai Messaggi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
