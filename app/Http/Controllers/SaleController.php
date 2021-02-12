<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Sale;
use App\Models\Game_card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
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
        Log::debug("Usuario " . Auth::User()->name . " ingresando al metodo Store del SaleController");
        $validator = Validator::make($request->all(), [
            'quantity' => 'required',
            'price' => 'required',
            'game_card_id' => 'required'
        ]);
        if ($validator->fails()) {
            Log::debug("Metodo Store del SaleController - Datos incompletos");
            return response()->json(['message' => 'Incomplete data'], 422);
        }
        $game_card = Game_card::find($request->game_card_id);
        if (!$game_card) {
            Log::debug("Metodo Store del SaleController - Error al generar la propuesta de venta");
            return response()->json([
                'message' => 'No se pudo realizar el proceso correctamente'
            ], 500);
        }
        $sale = Sale::create([
            'quantity' => $request->quantity,
            'price' => $request->price,
            'game_card_id' => $game_card->id,
        ]);
        if (!$sale) {
            Log::debug("Metodo Store del SaleController - Error al generar la propuesta de venta");
            return response()->json([
                'message' => 'No se pudo realizar el proceso correctamente'
            ], 500);
        }
        Log::debug("Metodo Store del SaleController - La carta con id = [" . $game_card . " se ha puesto a la venta con el siguiente valor [" . $sale->price . "]");
        return response()->json([
            'message' => 'Se ha puesto en venta correctamente'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
