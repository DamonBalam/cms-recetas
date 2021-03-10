<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{


    public function __construct()
    {
        // $this->middleware('auth',['except' => 'show']);
        $this->middleware('auth')->except(['show','search']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $recetas = auth()->user()->recetas->load('categoria');
        $usuario = auth()->user();

        $meGusta = auth()->user()->meGusta;

        $recetas = Receta::where('user_id', $usuario->id)->paginate(3);

        return view('recetas.index')
            ->with('recetas', $recetas)
            ->with('usuario', $usuario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // Sin modelo
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');
        // $categorias = CategoriaReceta::all(['nombre','id']);
        $categorias = CategoriaReceta::all()->pluck('nombre', 'id');


        return view('recetas.create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request['imagen']->store('upload-recetas','public'));

        $data = request()->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'ingredientes' => 'required',
            'preparacion' => 'required',
            'imagen' => 'required|image',
        ]);

        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');


        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);

        $img->save();

        // ! SIN MODELO
        // DB::table('recetas')->insert([
        //     'titulo' => $data['titulo'],
        //     'ingredientes' => $data['ingredientes'],
        //     'preparacion' => $data['preparacion'],
        //     'user_id' => Auth::user()->id,
        //     'imagen' => $ruta_imagen,
        //     'categoria_id' => $data['categoria']
        // ]);

        // ? CON MODELO
        auth()->user()->recetas()->create([
            'titulo' => $data['titulo'],
            'ingredientes' => $data['ingredientes'],
            'preparacion' => $data['preparacion'],
            'imagen' => $ruta_imagen,
            'categoria_id' => $data['categoria']
        ]);



        return redirect()->action('RecetaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        // obtener si el usuario actual y esta autenticado
        $like = (auth()->user()) ?  auth()->user()->meGusta->contains($receta->id) : false;

        // pasa los likes
        $likes = $receta->likes()->count();
        return view('recetas.show', compact('receta', 'like', 'likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        $this->authorize('view', $receta);

        $categorias = CategoriaReceta::all()->pluck('nombre', 'id');

        return view('recetas.edit', compact(['receta', 'categorias']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {

        // ! Revisar el policy
        $this->authorize('update', $receta);


        // ? Validación
        $data = $request->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'ingredientes' => 'required',
            'preparacion' => 'required',
        ]);


        // ? update de los datos
        $receta->categoria_id = $data['categoria'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->preparacion  = $data['preparacion'];
        $receta->titulo = $data['titulo'];

        // ! Verificar si existe una nueva imagen
        if ($request->imagen) {
            $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
            $img->save();

            $receta->imagen = $ruta_imagen;
        }

        // ? guardando
        $receta->save();

        // ? redireccionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        // ! Revisar el policy
        $this->authorize('delete', $receta);

        // ! Eliminar la receta
        $receta->delete();

        // ? redireccionar
        return redirect()->action('RecetaController@index');
    }

    public function search(Request $request)
    {
        # code...
        $busqueda = $request['buscar'];

        $recetas = Receta::where('titulo', 'like', '%' . $busqueda . '%')->paginate(10);
        $recetas->appends(['buscar' => $busqueda]);

        return view('busquedas.show', compact('recetas','busqueda'));
    }
}
