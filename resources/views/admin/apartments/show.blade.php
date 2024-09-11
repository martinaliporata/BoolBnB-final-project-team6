@extends('layouts.app')

{{-- @yield('page-title', 'Apartment\'s details') --}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <article class="col-12 p-3 text-center">
                {{-- @if (session('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                </div>
            @endif --}}
                <div class="card" style="w-100">
                    <img class="card-img-top w-100" src="{{ $apartment->Img }}" alt="">
                    <div class="card-body">
                        <h5 class="card-title">
                            <p class="card-text">
                            </p>
                        </h5>
                    </div>
                    <ul class="list-unstyled">
                        <li>
                            Stanze: {{ $apartment->Stanze }}
                        </li>
                        <li>
                            Letti: {{ $apartment->Letti }}
                        </li>
                        <li>
                            Bagni: {{ $apartment->Bagni }}
                        </li>
                        <li>
                            Metri quadrati: {{ $apartment->Metri_quadrati }}
                        </li>
                        <li>
                            Indirizzo: {{ $apartment->Indirizzo }}
                        </li>
                        <li>
                            Latitudine: {{ $apartment->Latitudine }}
                        </li>
                        <li>
                            Longitudine: {{ $apartment->Longitudine }}
                        </li>
                    </ul>
                    <div class="card-footer">
                        <a href="{{ route('apartments.index') }}" class="btn btn-primary">Torna alla lista appartamenti</a>
                        <a href="{{ route('apartments.edit', $apartment) }}" class="btn btn-success">Edit apartment</a>
                    </div>
                    <form action="{{ route('apartments.destroy', $apartment) }}" method="POST"
                        class="d-inline-block delete-form my-2 col-12 d-flex justify-content-center"
                        data_apartment_id="{{ $apartment->id }}" data_apartment_name="{{ $apartment->Nome }}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger  col-5">Delete</button>
                    </form>
                </div>
        </div>
        </article>
    </div>
    </div>
@endsection
{{--
@section('custom-scripts')
    @vite('resources/js/delete-confirm.js')
@endsection --}}
