<?php

namespace App\Http\Controllers;

use App\Models\DayUser;
use Illuminate\Http\Request;

class DayuserController extends Controller
{
    public function index(Request $request, $journey_id, $season_id)
    {
        // Suponiendo que $jornadaId contiene el ID de la jornada que quieres filtrar
        $usuarioJornadas = DayUser::where('journey_id', $journey_id)
            ->where('season_id', $season_id)
            ->with('jornada', 'usuario') // Carga las relaciones de Jornada y Usuario
            ->get();


        return response()->json(
            [
                'status' => 'success',
                'message' => 'Participantes obtenidos correctamente',
                'data' => $usuarioJornadas,
                'journey_id' => $journey_id,
                'season_id' => $season_id
            ],
            200
        );
    }

    public function update(Request $request)
    {
        $id = $request['id'];
        $day = DayUser::find($id);

        $day->authorize = $request['option'];
        $day->save();


        return response()->json(
            [
                'status' => 'success',
                'message' => 'Usuario acualizado correctamente',
                'data' => $day
            ],
            200
        );
    }
}
