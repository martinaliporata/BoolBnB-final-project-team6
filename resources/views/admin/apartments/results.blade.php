@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Risultati della Ricerca</h1>

    @if($apartments->isEmpty())
        <p>Nessun appartamento trovato con i criteri forniti.</p>
    @else
        <div class="row">
            @foreach($apartments as $apartment)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{$apartment->id}}
                            </h5>
                            <p class="card-text">
                                <br> Stanze: {{$apartment->Stanze}}
                                <br> Letti: {{$apartment->Letti}}
                                <br> Bagni: {{$apartment->Bagni}}
                                <br> Metri quadrati: {{$apartment->Metri_quadrati}}
                                <br> Indirizzo: {{$apartment->Indirizzo}}
                                <br> Latitudine: {{$apartment->Latitudine}}
                                <br> Longitudine: {{$apartment->Longitudine}}
                            </p>
                            <a href="{{route('apartments.show', $apartment)}}" class="btn btn-primary">Details</a>
                            {{-- <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-success">Edit</a>
                            <form action="{{'admin.apartments.destroy'}}" method="POST" class="d-inline-block apartment-destroyer">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning">Delete</button>
                            </form> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
