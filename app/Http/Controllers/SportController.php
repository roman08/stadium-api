<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use Illuminate\Support\Facades\Storage;

class SportController extends Controller
{
    public function index()
    {

        $sports = Sport::where('status', '=', 1)->with('seasons.working', 'clubs')->get();


        // foreach ($sports as $sport) {

        //     $logoPath = url(Storage::url($sport->image));
        //     // Actualizar el campo 'image' con la URL generada
        //     $sport->image = $logoPath;

        //     $logoPath = url(Storage::url($sport->banner));
        //     // Actualizar el campo 'banner' con la URL generada
        //     $sport->banner = $logoPath;

        //     if ($sport->clubs) {
        //         // Iterar sobre cada registro de 'clubs'
        //         foreach ($sport->clubs as $clubs) {
        //             // Generar la URL para el campo 'logo' dentro de cada registro de 'clubs'
        //             $logoPath = url(Storage::url($clubs->logo));
        //             // Actualizar el campo 'logo' con la URL generada
        //             $clubs->logo = $logoPath;
        //         }
        //     }
        //     if ($sport->seasons) {
        //         // Iterar sobre cada registro de 'seasons'
        //         foreach ($sport->seasons as $seasons) {
        //             // Generar la URL para el campo 'logo' dentro de cada registro de 'seasons'
        //             $logoPath = url(Storage::url($seasons->banner));
        //             // Actualizar el campo 'banner' con la URL generada
        //             $seasons->banner = $logoPath;
        //         }
        //     }
        // }
        return response()->json([
            'status' => 'success',
            'message' => 'Deportes obtenidos correctamente',
            'data' => $sports
        ], 200);
    }

    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'image' => 'required',
            'banner' => 'required',
            'exact_marker_points' => 'required',
            'points_winner_loser' => 'required',
            'tie_points' => 'required',
            'points_lost' => 'required',
            'participant_fee' => 'required',
            'platform_commission' => 'required',
            'status' => 'required',
            'icon' => 'required'
        ]);

        $sport = Sport::create([
            'name' => $validatedData['name'],
            'image' => $validatedData['image'],
            'banner' => $validatedData['banner'],
            'exact_marker_points' => $validatedData['exact_marker_points'],
            'points_winner_loser' => $validatedData['points_winner_loser'],
            'tie_points' => $validatedData['tie_points'],
            'points_lost' => $validatedData['points_lost'],
            'participant_fee' => $validatedData['participant_fee'],
            'platform_commission' => $validatedData['platform_commission'],
            'status' => $validatedData['status'],
            'icon' => $validatedData['icon'],
        ]);


        return response()->json(
            [
                'status' => 'success',
                'message' => 'Deportes creado correctamente',
                'data' => $sport
            ],
            200
        );
    }

    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'image' => 'required', // No es necesario especificar 'string'
            'banner' => 'required',
            'exact_marker_points' => 'required',
            'points_winner_loser' => 'required',
            'tie_points' => 'required',
            'points_lost' => 'required',
            'participant_fee' => 'required',
            'platform_commission' => 'required',
            'status' => 'required',
        ]);

        //se valida la información que viene en $request
        $id =  $validatedData['id'];

        $sport = Sport::find($id);
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
        $sport = Sport::find($id);

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
        $sport = Sport::find($id)->with('seasons')->get();

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
