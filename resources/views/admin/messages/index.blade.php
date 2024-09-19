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
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome Appartamento</th>
                                        <th>Email Mittente</th>
                                        <th>Testo Messaggio</th>
                                        <th>Data Ricezione</th>
                                        <th>Azioni</th> <!-- Nuova colonna per le azioni -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $message)
                                        <tr class="{{ $message->is_read ? '' : 'table-warning' }}">
                                            <td>{{ $message->apartment->Nome }}</td>
                                            <td>{{ $message->Mail }}</td>
                                            <td>{{ Str::limit($message->Testo, 50) }}</td>
                                            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="d-flex my-2">
                                                    <a href="{{ route('messages.show', $message->id) }}" class="btn btn-primary me-1 btn-sm">Leggi</a>
                                                    <!-- Form per eliminare il messaggio -->
                                                    <form action="{{ route('messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo messaggio?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Elimina</button>
                                                    </form>
                                                </div>
                                            </td>
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
