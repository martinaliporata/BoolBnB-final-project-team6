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
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="{{route('apartments.store')}}" method="POST" id="creation-form">
                @csrf
                <label for="name">Name</label>
                <input class="form-control form-control-sm" type="text" placeholder="Animal name" aria-label="Animal name" id="name" name="name" value="{{old('name')}}">
                <label for="image">Image_url</label>
                <input class="form-control form-control-sm" type="text" placeholder="Animal image" aria-label="image" id="image" name="image" value="{{old('image_url')}}">
                <label for="species">Species</label>
                <input class="form-control form-control-sm" type="text" placeholder="species" aria-label="species" id="species" name="species" value="{{old('species')}}">
                <label for="weight">Weight</label>
                <input class="form-control form-control-sm" type="number" placeholder="weight" aria-label="weight" id="weight" name="weight" value="{{old('weight')}}">
                <label for="alimentation">Alimentation</label>
                <input class="form-control form-control-sm" type="text" placeholder="alimentation" aria-label="alimentation" id="alimentation" name="alimentation" value="{{old('alimentation')}}">
                <label for="extintion">Extintion</label>
                <input class="form-control form-control-sm" type="text" placeholder="extintion" aria-label="extintion" id="extintion" name="extintion" value="{{old('extintion')}}">
                <label for="colour">Colour</label>
                <input class="form-control form-control-sm" type="text" placeholder="colour" aria-label="colour" id="colour" name="colour" value="{{old('colour')}}">
                <label for="habitat">Habitat</label>
                <input class="form-control form-control-sm" type="text" placeholder="habitat" aria-label="habitat" id="habitat" name="habitat" value="{{old('habitat')}}">
                <label for="life duration">Life duration</label>
                <input class="form-control form-control-sm" type="text" placeholder="life duration" aria-label="life duration" id="life duration" name="life duration" value="{{old('life_duration')}}">
                <div class="d-flex justify-content-between">
                    <input type="submit" value="Create a new animal" class="btn btn-primary">
                    <input type="reset" value="Reset fields" class="btn btn-warning">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-scripts')
    @vite('resources/js/creation-confirm.js')
@endsection
