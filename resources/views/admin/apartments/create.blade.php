@extends('layouts.app')

@yield('page-title', 'Create a new apartment')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1 class="mb-3 text-center">
            Creating a new apartment
        </h1>
    </div>
    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>
                        {{$error}}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif --}}


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
            <form action="{{ route('apartments.store') }}" method="POST" id="creation_form">
                @method("POST")
                @csrf

                <div class="input-group-m container mb-5 w-50">
                    <label for="nome"><strong>Nome</strong></label>
                    <input type="text" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="nome" id="nome" name="nome" value="{{ old('Nome') }}">

                    <label for="stanze"><strong>Stanze</strong></label>
                    <input type="number" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="stanze" id="stanze" name="stanzee" value="{{ old('stanze') }}">

                    <label for="letti"><strong>Letti</strong></label>
                    <input type="number" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="letti" id="letti" name="letti" value="{{ old('Letti') }}">

                    <label for="bagni"><strong>Bagni</strong></label>
                    <input type="number" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="bagni" id="bagni" name="bagni" value="{{ old('Bagni') }}">

                    <label for="Metri quadrati"><strong>Metri quadrati</strong></label>
                    <input type="number" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Metri quadrati" id="Metri quadrati" name="Metri quadrati" value="{{ old('Metri_quadrati') }}">

                    <label for="indirizzo"><strong>Indirizzo</strong></label>
                    <input type="text" class="form-control mb-2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Indirizzo" id="Indirizzo" name="Indirizzo" value="{{ old('Indirizzo') }}">

                    <label for="Img"><strong>Img</strong></label>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Img" id="Img" name="Img" value="{{ old('Img') }}">

                    <label for="service_id"><strong>Servizi</strong></label>
                    <div class="btn-group flex-wrap" role="group" aria-label="Basic checkbox toggle button group">
                        @foreach ($services as $service)
                        <input name="services" type="checkbox" class="btn-check " id="service-check-{{$service->id}}" autocomplete="off" value="{{$service->id}}">
                        <label class="btn btn-outline-primary m-1 btn-sm rounded mb-2 " for="service-check-{{$service->id}}">
                            {{$service->Nome}}
                        </label>
                        @endforeach
                    </div>



                </div>
                <div class="col-12 d-flex justify-content-center mb-3">
                    <div class="input">
                        <input class="btn btn-success" type="submit" value="Create new apartmentr">
                        <input class="btn btn-secondary" type="reset" value="Reset">
                    </div>
                </div>
            </form>


        </div>

    </div>
</div>
@endsection
