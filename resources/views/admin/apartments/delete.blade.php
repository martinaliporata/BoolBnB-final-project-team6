@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="row justify-content-center">
            @if (session('message_delete'))
                <div class="alert alert-success">
                    {{ session('message_delete') }}
                </div>
            @elseif (session('message_restore'))
                <div class="alert alert-success">
                    {{ session('message_restore') }}
                </div>
            @endif
            @foreach ($apartments as $apartment)
                <article class="col-3 my-4">
                    <div class="card text-bg-dark mb-3" style="max-width: 18rem;">
                        <div class="card-header">
                            <h2 class="card-title">
                                {{ $apartment->id }}: {{ $apartment->Nome }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <img class="w-50 mb-2 mx-5" src="{{ $apartment->Img }}" alt="">
                            <h5 class="card-text text-center">
                                {{ $apartment->Indirizzo }}
                            </h5>

                        </div>
                        <div class="card-footer card-link d-flex justify-content-center ">
                            <form action="{{ route('admin.apartments.restore', $apartment) }}" method="POST"
                                class="d-inline-block mx-2" data_apartment_id="{{ $apartment->id }}"
                                data_apartment_nome="{{ $apartment->Nome }}">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-success">Restore</button>
                            </form>
                            <form action="{{ route('admin.apartments.permanent_delete', $apartment) }}" method="POST"
                                class="d-inline-block delete-form" data_apartment_id="{{ $apartment->id }}"
                                data_apartment_nome="{{ $apartment->Nome }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger">Empty the trash</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection

@section('custom_script')
    @vite('resources/js/apartment/delete-confirmation.js')
@endsection
