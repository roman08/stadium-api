<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function index(Request $request, $id)
    {
        try {
            $seasons = Season::where('id_sport', '=', $id)->where('status', '=', 1)->with('working')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Temporadas obtenidas correctamente',
                'data' => $seasons
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al obtener las temporadas',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'start' => 'required', // No es necesario especificar 'string'
            'end' => 'required',
            'banner' => 'required',
            'status' => 'required',
            'id_sport' => 'required'
        ]);

        $sport = Season::create([
            'name' => $validatedData['name'],
            'star' => $validatedData['start'],
            'end' => $validatedData['end'],
            'banner' => $validatedData['banner'],
            'status' => $validatedData['status'],
            'id_sport' => $validatedData['id_sport']
        ]);


        return response()->json(
            [
                'status' => 'success',
                'message' => 'Temporada creada correctamente',
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
                'name' => 'required',
                'star' => 'required', // No es necesario especificar 'string'
                'end' => 'required',
                'banner' => 'required',
                'status' => 'required',
            ]);

            //se valida la información que viene en $request
            $id =  $validatedData['id'];

            $season = Season::find($id);
            //se crea el usuario en la base de datos
            $season->name = $validatedData['name'];
            $season->star = $validatedData['star'];
            $season->end = $validatedData['end'];
            $season->banner = $validatedData['banner'];
            $season->status = $validatedData['status'];

            $season->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Temporada actualizada correctamente',
                    'data' => $season
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al obtener las temporadas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        $season = Season::find($id);

        if ($season) {
            $season->status = 0;
            $season->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Temporada eliminada correctamente',
                    'data' => $season
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Temporada no enconarado',
                    'data' => $season
                ],
                404
            );
        }
    }

    public function detail(Request $request, $id)
    {
        $season = Season::find($id);

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
}
