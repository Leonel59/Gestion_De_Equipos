<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objeto;
use Illuminate\Support\Facades\Auth;

class ObjetosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objetos= Objeto::all();
        return view('seguridad.objetos.index',compact('objetos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seguridad.objetos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
            'objeto' => "required|unique:objetos|min:5|max:255", 
            'descripcion' => "required|min:5|max:255"

        ]);

        $data=[
            'objeto' => $request->objeto,
            'descripcion' => $request->descripcion,
            'creado_por' => Auth::user()->id,

        ];

        $objeto= Objeto::create($data);
        app(BitacoraController::class)->register('create', 'objeto', 'Se creó un nuevo objeto: ' . $objeto->objeto);
        return redirect()->route('objetos.index')->with('info','objeto creado con exito');
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
        $objeto= Objeto::find($id);
        return view('seguridad.objetos.edit',compact('objeto'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'objeto' => "required|unique:parametros,parametro,{$id}||min:5|max:255", 
             'descripcion' => 'required|min:5|max:255'
            ]);

            $objeto = Objeto::find($id);

            $data = [
                'objeto' => $request->objeto,
                'descripcion' => $request->descripcion,
                'modificado_por' => Auth::user()->id,
    
            ];
            $objeto->update($data);
            app(BitacoraController::class)->register('update', 'objetos', 'Se actualizo un nuevo objeto: ' . $objeto->objeto);
            return redirect()->route('objetos.index')->with('info','Objeto actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $objeto =Objeto::find($id);
        $objeto->delete();

        app(BitacoraController::class)->register('delete', 'objetos', 'Se elimino un objeto: ' . $objeto->objeto);
        return redirect()->route('objetos.index')->with('info','Objeto eliminado con éxito.');

    }
}
