@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-5 animate__animated animate__fadeInLeft">
                @if ($perfil->imagen)
                    <img src="/storage/{{ $perfil->imagen }}" class="w-100 rounded-circle shadow-lg"
                        alt="Perfil de {{ $perfil->user->name }}">
                @endif
            </div>
            <div class="col-md-7 mt-5 mt-md-0 animate__animated animate__fadeInRight">
                <h2 class="text-center mb-2 text-primary">{{ $perfil->user->name }}</h2>
                <a href="{{ $perfil->user->url }}">Visitar Sitio Web</a>

                <div class="biografia mt-2">
                    {!! $perfil->biografia !!}
                </div>
            </div>
        </div>
    </div>

    <h2 class="text-center my-5">Recetas creadas por: {{ $perfil->user->name }}</h2>

    <div class="container">
        <div class="row mx-auto bg-white p-4">
            @if (count($recetas) > 0)
                @foreach ($recetas as $receta)
                    <div class="col-md-4 wow animate__animated animate__fadeInUp mb-3 mb-md-4"  data-wow-delay="1s">
                        <div class="card">
                            <img src="/storage/{{ $receta->imagen }}" class="card-img-top"
                                alt="Imagen de {{ $receta->titulo }}">
                            <div class="card-body">
                                <h3 class="text-center">{{ $receta->titulo }}</h3>
                                <a href="{{ route('recetas.show', $receta->id) }}"
                                    class="btn btn-primary btn-block text-uppercase">Ver receta</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12 mt-5 d-flex justify-content-center wow animate__animated animate__fadeInUp" data-wow-delay="1s">
                    {{ $recetas->links() }}
                </div>
            @else
                <p class="text-center w-100">No hay recetas aún....</p>
            @endif
        </div>
    </div>
@endsection



@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

    <script>
        new WOW().init();

    </script>

@endsection
