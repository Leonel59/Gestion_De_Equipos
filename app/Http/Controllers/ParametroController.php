<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametro; 
use Illuminate\Support\Facades\Auth;

class ParametroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $parametros = Parametro::all();
        return view('seguridad.parametros.index',compact('parametros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seguridad.parametros.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'parametro' => 'required|unique:parametros', 
             'valor' => 'required'
            ]);

            $data = [
                'parametro' => $request->parametro,
                'valor' => $request->valor,
                'creado_por' => Auth::user()->id,
    
            ];

            $parametro = Parametro::create($data);
            app(BitacoraController::class)->register('create', 'parametros', 'Se creó un nuevo parámetro: ' . $parametro->parametro);
            return redirect()->route('parametros.index')->with('info','Parametro creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $parametro = Parametro::find($id);
        return view('seguridad.parametros.edit')->with('parametro',$parametro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'parametro' => "required|unique:parametros,parametro,{$id}", 
             'valor' => 'required'
            ]);

            $parametro = parametro::find($id);

            $data = [
                'parametro' => $request->parametro,
                'valor' => $request->valor,
                'modificado_por' => Auth::user()->id,
    
            ];
            $parametro->update($data);
            app(BitacoraController::class)->register('update', 'parametros', 'Se actualizo un nuevo parámetro: ' . $parametro->parametro);
            return redirect()->route('parametros.index')->with('info','Parametro actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
