@extends('layouts.app')

@section('botones')
    @include('ui.navegacion')
@endsection

@section('content')
    <h2 class="text-center mb-5">Administra tus recetas</h2>

    <div class="col-md-10 mx-auto">
        <table class="table">
            <thead class="bg-primary text-light">
                <tr>
                    <th scole="col">Titulo</th>
                    <th scole="col">Categoria</th>
                    <th scole="col" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recetas as $receta)
                    <tr>
                        <td>{{ $receta->titulo }}</td>
                        <td>{{ $receta->categoria->nombre }} </td>
                        <td class="text-right">

                            <eliminar-receta receta-id="{{ $receta->id }}"></eliminar-receta>
                            <a href="{{ route('recetas.edit', ['receta' => $receta->id]) }}"
                                class="btn btn-dark d-block mb-2">Editar</a>
                            <a href="{{ route('recetas.show', ['receta' => $receta->id]) }}"
                                class="btn btn-success  d-block mb-2">Ver</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="col-12 mt-4 d-flex justify-content-center">
            {{ $recetas->links() }}
        </div>

        <h2 class="text-center my-5">Recetas que te gustan</h2>
        <div class="col-md-10 mx-auto bg-white">
            @if (count($usuario->meGusta) > 0)
                <ul class="list-group">
                    @foreach ($usuario->meGusta as $receta)
                        <li class="list-group-item d-flex justify-content-between align-content-center">
                            <p>{{ $receta->titulo }}</p>
                            <a class="btn btn-outline-success text-uppercase"
                                href="{{ route('recetas.show', ['receta' => $receta->id]) }}">Ver</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center">A??n no tienes recetas guardadas <small>Dale me gusta a las recetas que quieras
                        guardar</small></p>
            @endif

        </div>
    </div>
@endsection
