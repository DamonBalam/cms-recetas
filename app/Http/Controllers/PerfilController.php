<?php

namespace App\Http\Controllers;

use App\Perfil;
use App\Receta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        $recetas = Receta::where('user_id', $perfil->user_id)->paginate(10);

        return view('perfiles.show', compact(['perfil','recetas']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        $this->authorize('view', $perfil);

        return view('perfiles.edit', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {

        $this->authorize('update', $perfil);


        // Validar
        $data = $request->validate([
            'name' => 'required',
            'url' => 'required',
            'biografia' => 'required',
        ]);

        if ($request->imagen) {
            $ruta_imagen = $request['imagen']->store('upload-perfiles', 'public');
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(600, 600);
            $img->save();

            $array_imagen = ['imagen' => $ruta_imagen];
        }


        // * Asignar nombre y url
        auth()->user()->url = $data['url'];
        auth()->user()->name = $data['name'];

        auth()->user()->save();

        // Eliminar url y name
        unset($data['name']);
        unset($data['url']);

        // guardar biografia e imagen
        auth()->user()->perfil()->update(
            array_merge(
                $data,
                $array_imagen ?? []
            )
        );




        // guardar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil)
    {
        //
    }
}
