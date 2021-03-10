@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"
        integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA=="
        crossorigin="anonymous" />
@endsection

@section('botones')
    <a href="{{ route('recetas.index') }}" class="btn btn-outline-primary mr-2 font-weight-bold">
        <svg class="icono" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
        </svg>
        Regresar
    </a>
@endsection

@section('content')
    <h2 class="text-center">Editar mi perfil</h2>
    <div class="row justify-content-center mt-5">
        <div class="col-md-10 bg-white p-3">
            <form method="POST" action="{{ route('perfiles.update', ['perfil' => $perfil->id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" placeholder="Tú nombre"
                        class="form-control @error('name') is-invalid @enderror" value="{{ $perfil->user->name }}">

                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="url">Sitio Web</label>
                    <input type="text" name="url" id="url" placeholder="Tú sitio web"
                        class="form-control @error('url') is-invalid @enderror" value="{{ $perfil->user->url }}">

                    @error('url')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="biografia">Biografia</label>
                    <input type="hidden" id="biografia" name="biografia" value="{{ $perfil->biografia }}">
                    <trix-editor class="form-control @error('biografia') is-invalid @enderror" input="biografia">
                    </trix-editor>
                    @error('biografia')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="imagen">Elige la Imagen</label>

                    <input type="file" id="imagen" class="form-control p-1 @error('imagen') is-invalid @enderror"
                        name="imagen">

                    @if ($perfil->imagen)
                        <div class="mt-4">
                            <p>Imagen Actual</p>
                            <img src="/storage/{{ $perfil->imagen }}" alt="Imagen de la receta" style="width: 300px">
                        </div>
                    @endif


                    @error('imagen')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Guardar Cambios">
                </div>

            </form>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"
        integrity="sha512-2RLMQRNr+D47nbLnsbEqtEmgKy67OSCpWJjJM394czt99xj3jJJJBQ43K7lJpfYAYtvekeyzqfZTx2mqoDh7vg=="
        crossorigin="anonymous" defer></script>
@endsection
