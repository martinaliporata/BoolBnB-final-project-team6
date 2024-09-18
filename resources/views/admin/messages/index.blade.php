@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Messaggi Ricevuti') }}</div>

                    <div class="card-body">
                        @if ($messages->isEmpty())
                            <p>Non ci sono messaggi ricevuti.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome Appartamento</th>
                                        <th>Email Mittente</th>
                                        <th>Testo Messaggio</th>
                                        <th>Data Ricezione</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $message)
                                        <tr>
                                            <td>{{ $message->apartment->Nome }}</td>
                                            <td>{{ $message->Mail }}</td>
                                            <td>{{ $message->Testo }}</td>
                                            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection