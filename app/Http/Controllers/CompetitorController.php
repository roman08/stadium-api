<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoachRequest;
use App\Models\Competitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompetitorController extends Controller
{
    public function index()
    {
        $competitors = Competitor::all();


        return response()->json(
            [
                'status' => 'success',
                'message' => 'Participantes obtenidos correctamente',
                'data' => $competitors
            ],
            200
        );
    }


    public function create(CoachRequest $request)
    {

        try {




            $competitor = Competitor::create([
                'name' => $request['name'],
                'last_name' => $request['last_name'],
                'second_surname' => $request['second_surname'],
                'birth_date' => $request['birth_date'],
                'phone' => $request['phone'],
                'profile_img' => '',
                'email' => $request['email'],
                'password' => Hash::make(
                    $request['password']
                ),
                'bank_id' => '',
                'bank_account' => '',
                'account_type_id' => '',
                'observations' => '',
            ]);
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Participante creado correctamente',
                    'data' => $competitor
                ],
                200
            );
        } catch (\Exception $e) {

            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'data' => []
                ],
                500
            );
        }
    }
}
