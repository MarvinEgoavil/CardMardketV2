<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Sale;
use App\Models\Game_card;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;



class GameCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::debug("Usuario " . Auth::User()->name . " ingresando al metodo index del GameCardsController");
        $game_cards = Game_card::all();
        if (!$game_cards) {
            Log::debug("Metodo index del GameCardController - No se encontraron datos");
            return response()->json([
                'message' => 'No se encontraron datos asociados'
            ], 204);
        }
        Log::debug("Metodo index del GameCardController - Se han encontrado " . count($game_cards) . " cartas");
        return response()->json($game_cards, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::debug("Usuario " . Auth::User()->name . " ingresando al metodo Store del GameCardController");
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'collection_id' => 'required',
        ]);
        if ($validator->fails()) {
            Log::debug("Metodo Store del GameCardController - Data incompleta");
            return response()->json(['message' => 'Incomplete data'], 422);
        }
        $game_card = Game_card::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::User()->id,
        ]);
        if (!$game_card) {
            Log::debug("Metodo Store del GameCardsController - Error al guardar la carta");
            return response()->json([
                'message' => 'No se pudo realizar el proceso correctamente'
            ], 500);
        }
        Log::debug("Metodo Store del GameCardController - Se han registrado con exito la siguiente carta [" . $game_card->name . "]");
        return response()->json([
            'message' => 'Se ha creado la carta correctamente'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game_card  $game_card
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        Log::debug("Usuario " . Auth::User()->name . " ingresando al metodo Show del GameCardController");
        $response = [];
        $game_cards = DB::select("SELECT * FROM game_cards WHERE name LIKE '%$name%'");
        if (!$game_cards) {
            Log::debug("Metodo show del GameCardController - No se encontraron registros");
            return response()->json([
                'message' => 'No se encontraron registros'
            ], 404);
        }

        foreach ($game_cards as $game_card) {
            $sale = Sale::where('game_card_id', $game_card->id)->first();

            $aux =  [
                'game_card_id' => $game_card->id,
                'name_card' => $game_card->name,
                'quantity' => $sale->quantity,
                'price' => $sale->price,
            ];
            $response[] = $aux;
        }

        if (!$response) {
            Log::debug("Metodo Show del GameCardController - No se encontraron registros");
            return response()->json([
                'message' => 'No se encontraron registros'
            ], 404);
        }
        Log::debug("Metodo externalQuest del GameCardController - Se encontraron [" . count($response) . "] registros");
        return response()->json([
            $response
        ], 200);
    }

    public function externalQuest($name)
    {
        Log::debug("Metodo externalQuest del GameCardController");
        $response = [];
        $order = [];
        $cont = 0;
        $return = [];
        $game_cards = DB::select("SELECT * FROM game_cards WHERE name LIKE '%$name%'");
        if (!$game_cards) {
            Log::debug("Metodo externalQuest del GameCardController - No se encontraron registros");
            return response()->json([
                'message' => 'No se encontraron registros'
            ], 404);
        }
        $aux = array();
        foreach ($game_cards as $game_card) {
            $sale = Sale::where('game_card_id', $game_card->id)->first();
            $user = User::where('id', $game_card->user_id)->first();

            if (!$sale) {
            } else {
                $aux = [
                    'name_card' => $game_card->name,
                    'quantity' => $sale->quantity,
                    'price' => $sale->price,
                    'name_user' => $user->name,
                ];
                $order[$cont] = $aux['price'];
                $response[] = $aux;
                $cont++;
            }
        }
        $order = Arr::sort($order);
        foreach ($order as $ord) {
            foreach ($response as $resp) {
                if ($ord == $resp['price']) {
                    $return[] = $resp;
                }
            }
        }
        if (!$return) {
            Log::debug("Metodo externalQuest del GameCardController - No se encontraron registros");
            return response()->json([
                'message' => 'No se encontraron registros'
            ], 404);
        }
        Log::debug("Metodo externalQuest del GameCardController - Se encontraron [" . count($return) . "] registros");
        return response()->json([
            $return
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game_card  $game_card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game_card $game_card)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game_card  $game_card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game_card $game_card)
    {
        //
    }
}
