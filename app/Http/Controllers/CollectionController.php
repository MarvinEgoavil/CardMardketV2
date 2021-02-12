<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::debug("Usuario " . Auth::User()->name . " ingresando al metodo Store del CollectionController");
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'symbol' => 'required',
            'edition_date' => 'required'
        ]);
        if ($validator->fails()) {
            Log::debug("Metodo Store del CollectionController - Datos incompletos");
            return response()->json(['message' => 'Incomplete data'], 422);
        }
        $collection = collection::create([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'edition_date' => $request->edition_date,
        ]);
        if (!$collection) {
            Log::debug("Metodo Store del CollectionController - Error al momento de realizar el registro");
            return response()->json([
                'message' => 'No se pudo realizar el proceso correctamente'
            ], 500);
        }
        Log::debug("Metodo Store del CollectionController - Se creo la coleccion con nombre [" . $collection->name . "] exitosamente");
        return response()->json([
            'message' => 'Se ha creado la coleccion correctamente'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        //
    }
}
