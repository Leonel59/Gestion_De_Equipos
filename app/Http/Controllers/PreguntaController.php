<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pregunta; 
use Illuminate\Support\Facades\Auth;

class PreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $preguntas = Pregunta::all();
        return view('seguridad.preguntas.index')->with('preguntas',$preguntas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seguridad.preguntas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pregunta' => 'required|unique:preguntas|min:10|max:255'

        
        ]);

        $data = [
            'pregunta' => $request->pregunta,
            'creado_por' => Auth::user()->id,

        ];

        $pregunta =Pregunta::create($data);
        app(BitacoraController::class)->register('create', 'pregunta', 'Se creó una nueva pregunta: ' . $pregunta->pregunta);
        return redirect()->route('preguntas.index')->with('info','Pregunta creado con éxito.');

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
        $pregunta =Pregunta::find($id);
        return view('seguridad.preguntas.edit')->with('pregunta',$pregunta);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'pregunta' => "required|unique:preguntas,pregunta,{$id}|min:10|max:255"

        
        ]);

        $data = [
            'pregunta' => $request->pregunta,
            'modificado_por' => Auth::user()->id,

        ];

        $pregunta =Pregunta::find($id);
        $pregunta->update($data);
        app(BitacoraController::class)->register('update', 'pregunta', 'Se actualizo una pregunta: ' . $pregunta->pregunta);
        return redirect()->route('preguntas.index')->with('info','Pregunta actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pregunta =Pregunta::find($id);
        $pregunta->delete();

        app(BitacoraController::class)->register('delete', 'preguntas', 'Se elimino una pregunta: ' . $pregunta->pregunta);
        return redirect()->route('preguntas.index')->with('info','pregunta eliminada con éxito.');
    }
}
