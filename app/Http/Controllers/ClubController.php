<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClubController extends Controller
{
    public function index(Request $request, $id)
    {

        $clubs = Club::where('sport_id', '=', $id)->where('status', '=', 1)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Equipos obtenidos correctamente',
            'data' => $clubs
        ], 200);
    }

    public function create(Request $request)
    {



        $validatedData = $request->validate([
            'name' => 'required',
            'logo' => 'required', // No es necesario especificar 'string'
            'acronym' => 'required',
            'status' => 'required',
            'sport_id' => 'required'

        ]);

        // $imagenPath = $request->file('logo')->store('logos', 'public');

        //se crea el usuario en la base de datos
        $club = Club::create([
            'name' => $validatedData['name'],
            'logo' => $validatedData['logo'],
            'acronym' => $validatedData['acronym'],
            'status' => $validatedData['status'],
            'sport_id' => $validatedData['sport_id']
        ]);


        return response()->json(
            [
                'status' => 'success',
                'message' => 'Equipo creado correctamente',
                'data' => $club
            ],
            200
        );
    }

    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'logo' => 'required', // No es necesario especificar 'string'
            'acronym' => 'required',
            'status' => 'required',
        ]);

        //se valida la información que viene en $request
        $id =  $validatedData['id'];

        $sport = Club::find($id);
        //se crea el usuario en la base de datos
        $sport->name = $validatedData['name'];
        $sport->image = $validatedData['image'];
        $sport->banner = $validatedData['banner'];
        $sport->exact_marker_points = $validatedData['exact_marker_points'];
        $sport->points_winner_loser = $validatedData['points_winner_loser'];
        $sport->tie_points = $validatedData['tie_points'];
        $sport->points_lost = $validatedData['points_lost'];
        $sport->participant_fee = $validatedData['participant_fee'];
        $sport->platform_commission = $validatedData['platform_commission'];
        $sport->status = $validatedData['status'];

        $sport->save();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Deportes actualizado correctamente',
                'data' => $sport
            ],
            200
        );
    }

    public function delete(Request $request, $id)
    {
        $sport = Club::find($id);

        if ($sport) {
            $sport->status = 0;
            $sport->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Deportes eliminado correctamente',
                    'data' => $sport
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Deportes no encontrado',
                    'data' => $sport
                ],
                404
            );
        }
    }

    public function detail(Request $request, $id)
    {
        $sport = Club::find($id);

        if ($sport) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Deportes recuperado correctamente',
                    'data' => $sport
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Deportes no encontrado',
                    'data' => $sport
                ],
                404
            );
        }
    }
}
