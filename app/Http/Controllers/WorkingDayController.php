<?php

namespace App\Http\Controllers;

use App\Models\WorkingDay;
use Illuminate\Http\Request;

class WorkingDayController extends Controller
{
    public function index(Request $request, $id)
    {
        try {
            $working = WorkingDay::where('id_season', '=', $id)->where('status', '=', 1)->with('games')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Jornadas obtenidas correctamente',
                'data' => $working
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al obtener las Jornadas',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'star' => 'required', // No es necesario especificar 'string'
            'end' => 'required',
            'end_register' => 'required',
            'status' => 'required',
            'id_season' => 'required'
        ]);

        //se valida la información que viene en $request

        //se crea el usuario en la base de datos
        $sport = WorkingDay::create([
            'name' => $validatedData['name'],
            'star' => $validatedData['star'],
            'end' => $validatedData['end'],
            'end_register' => $validatedData['end_register'],
            'status' => $validatedData['status'],
            'id_season' => $validatedData['id_season']
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
                'end_register' => 'required',
                'status' => 'required',
            ]);

            //se valida la información que viene en $request
            $id =  $validatedData['id'];

            $working = WorkingDay::find($id);
            //se crea el usuario en la base de datos
            $working->name = $validatedData['name'];
            $working->star = $validatedData['star'];
            $working->end = $validatedData['end'];
            $working->end_register = $validatedData['end_register'];
            $working->status = $validatedData['status'];

            $working->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Jornada actualizada correctamente',
                    'data' => $working
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
        $working = WorkingDay::find($id);

        if ($working) {
            $working->status = 0;
            $working->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Jornada eliminada correctamente',
                    'data' => $working
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Jornada no enconarado',
                    'data' => $working
                ],
                404
            );
        }
    }

    public function detail(Request $request, $id)
    {
        $season = WorkingDay::find($id);

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
