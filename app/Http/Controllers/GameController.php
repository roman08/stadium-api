<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request, $id)
    {
        try {
            $seasons = Game::with('localTeam', 'visitingTeam')->where('id_working', '=', $id)->where('status', '=', 1)->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Juegos obtenidas correctamente',
                'data' => $seasons
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al obtener las juegos',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function create(Request $request)
    {


        $validatedData = $request->validate([
            'star_date' => 'required',
            'hour' => 'required',
            'id_local_team' => 'required',
            'local_mummy' => 'required',
            'id_visiting_team' => 'required',
            'visiting_mumy' => 'required',
            'observation' => 'required',
            'id_working' => 'required',
            'status' => 'required'
        ]);

        //se valida la información que viene en $request

        //se crea el usuario en la base de datos
        $sport = Game::create([
            'star_date' => $validatedData['star_date'],
            'hour' => $validatedData['hour'],
            'id_local_team' => $validatedData['id_local_team'],
            'local_mummy' => $validatedData['local_mummy'],
            'id_visiting_team' => $validatedData['id_visiting_team'],
            'visiting_mumy' => $validatedData['visiting_mumy'],
            'observation' => $validatedData['observation'],
            'id_working' => $validatedData['id_working'],
            'status' => $validatedData['status']
        ]);


        return response()->json(
            [
                'status' => 'success',
                'message' => 'Juego creado correctamente',
                'data' => $sport
            ],
            200
        );
    }

    public function update(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'id' => 'required',
                'star_date' => 'required',
                'hour' => 'required',
                'id_local_team' => 'required',
                'local_mummy' => 'required',
                'id_visiting_team' => 'required',
                'visiting_mumy' => 'required',
                'observation' => 'required',
                'status' => 'required'
            ]);
            //se valida la información que viene en $request
            $id =  $validatedData['id'];

            $game = Game::find($id);




            $game->star_date = $validatedData['star_date'];
            $game->hour = $validatedData['hour'];
            $game->id_local_team = $validatedData['id_local_team'];
            $game->local_mummy = $validatedData['local_mummy'];
            $game->id_visiting_team = $validatedData['id_visiting_team'];
            $game->visiting_mumy = $validatedData['visiting_mumy'];
            $game->observation = $validatedData['observation'];
            $game->status = $validatedData['status'];


            $game->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Juego actualizado correctamente',
                    'data' => $game
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al editar el juego',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        $game = Game::find($id);

        if ($game) {
            $game->status = 0;
            $game->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Juego eliminado correctamente',
                    'data' => $game
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Juego no encontrado',
                    'data' => $game
                ],
                404
            );
        }
    }

    public function detail(Request $request, $id)
    {
        $season = Game::find($id);

        if ($season) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Temporada recuperada correctamente',
                    'data' => $season
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Temporada no encontrada',
                    'data' => $season
                ],
                404
            );
        }
    }

    public function updateMarker(Request $request)
    {


        $data = $request->all();
        $id = $data['id'];

        $game = Game::find($id);


        $game->local_marker = $data['local_marker'];
        $game->visiting_marker = $data['visiting_marker'];

        $game->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Temporada recuperada correctamente',
                'data' => $game
            ],
            200
        );
    }
}
