@extends('layouts.app')

@yield('page-title', 'homepage')

@section('content')
    <div>
        Welcome in the homepage, please click on apartments to see them
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1>
                    Apartments' index
                </h1>
                <div class="row">
                    @foreach ($apartments as $apartment)
                        <article class="col-4 text-center">
                            <div class="card shadow" style="w-100">
                                <img class="card-img-top" src="{{$apartment->Img}}" alt="">
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
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
{{--
@section('custom-scripts')
    @vite('resources/js/delete-confirm.js')
@endsection --}}
