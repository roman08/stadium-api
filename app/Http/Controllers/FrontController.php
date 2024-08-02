<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\DayUser;
use App\Models\Game;
use App\Models\Score;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index(Request $request, $id)
    {




        $sports = Sport::where('id', '=', $id)->with('seasons.working.games')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Deportes obtenidos correctamente',
            'data' => $sports
        ], 200);
    }

    public function createUserDay(Request $request)
    {
        $validatedData = $request->all();
        // ([
        //     'user_id' => 'required',
        //     'journey_id' => 'required',
        //     'season_id' => 'required',
        //     'results' => 'required'
        // ]);

        try {
            //code...
            $dayUser = DayUser::create([
                'user_id' => $validatedData['user_id'],
                'journey_id' => $validatedData['journey_id'],
                'season_id' => $validatedData['season_id']
            ]);

            $results = $validatedData['results'];
            foreach ($results as $value) {

                Score::create([
                    'day_user_id' => $dayUser->id,
                    'home_score' => $value['local'],
                    'away_score' => $value['visitor'],
                    'user_id'
                    => $validatedData['user_id'],
                ]);
            }
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



        return response()->json(
            [
                'status' => 'success',
                'message' => 'Registro creado correctamente',
                'data' =>
                $validatedData
            ],
            200
        );
    }


    public function getGames(Request $request, $id)
    {

        $games = Game::where('id_working', '=', $id)->with('localTeam', 'visitingTeam')->get();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Registro creado correctamente',
                'data' => $games
            ],
            200
        );
    }


    public function getDetalles(Request $request, $id, $seasonId)
    {
        $DayUser = DayUser::where('user_id', '=', $id)->get();
        $competitors = DayUser::where('journey_id', '=', $seasonId)->with('usuario')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Deportes obtenidos correctamente',
            'data' => $DayUser,
            'competitors' => $competitors
        ], 200);
    }
    function createOppwaCheckout()
    {

        try {
            function request()
            {
                $url = "https://eu-test.oppwa.com/v1/checkouts/C258CD34AA863FD12515A1710553EB66.uat01-vm-tx01/payment";
                $url .= "?entityId=8ac7a4c8900cc79d01900e58b97e0162";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGE4Mjk0MTg1MmNhZDA1MzAxNTJjYmIwYmM1ZjAzN2R8UnFRbTlOYWpSaw=='
                ));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if (curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }
            $responseData = request();


            return response()->json([
                'status' => 'success',
                'message' => 'Deportes obtenidos correctamente',
                'data' => $responseData
            ], 200);
        } catch (RequestException $e) {
            // Manejar el error de solicitud HTTP
            if ($e->response) {
                // Si hay una respuesta del servidor, obtener el código de estado y el contenido
                $statusCode = $e->response->status();
                $errorContent = $e->response->body();
                return response()->json([
                    'error' => 'HTTP Error',
                    'status_code' => $statusCode,
                    'message' => $errorContent
                ], $statusCode);
            } else {
                // Si no hay respuesta, capturar y manejar el error general
                return response()->json([
                    'error' => 'Request Error',
                    'message' => $e->getMessage()
                ], 500); // Código de estado 500 para error interno del servidor
            }
        }
    }


    public function getRankings($journeyId)
    {
        // Obtener competidores asociados a la jornada
        $competitors = DB::table('competitors')
            ->join('day_users', 'competitors.id', '=', 'day_users.user_id')
            ->where('day_users.journey_id', $journeyId)
            ->select('competitors.id as competitor_id', 'competitors.name', 'competitors.last_name', 'competitors.second_surname', 'competitors.birth_date', 'competitors.phone', 'competitors.profile_img', 'competitors.email', 'day_users.id as day_user_id', 'day_users.created_at as prediction_time', 'day_users.authorize')
            ->get();

        // Obtener resultados de los partidos para la jornada
        $games = DB::table('games')
            ->where('id_working', $journeyId)
            ->select('id', 'local_marker', 'visiting_marker')
            ->get();

        // Obtener marcadores de los competidores
        $scores = DB::table('scores')
            ->join('day_users', 'scores.day_user_id', '=', 'day_users.id')
            ->where('day_users.journey_id', $journeyId)
            ->select('scores.day_user_id', 'scores.home_score', 'scores.away_score', 'scores.created_at', 'scores.game_id')
            ->get();

        // Calcular puntos y rankings
        $rankings = $this->calculateRankings($competitors, $games, $scores);

        return response()->json($rankings);
    }

    private function calculatePoints($predicted, $game)
    {
        if ($predicted->home_score == $game->local_marker && $predicted->away_score == $game->visiting_marker) {
            return 5; // Exact match
        } elseif (($predicted->home_score > $predicted->away_score && $game->local_marker > $game->visiting_marker) ||
            ($predicted->home_score < $predicted->away_score && $game->local_marker < $game->visiting_marker) ||
            ($predicted->home_score == $predicted->away_score && $game->local_marker == $game->visiting_marker)
        ) {
            return 3; // Correct winner
        }
        return 0; // No match
    }

    private function calculateRankings($competitors, $games, $scores)
    {
        $rankings = [];

        foreach ($competitors as $competitor) {
            $totalPoints = 0;
            $predictions = [];
            $gameScores = [];
            $capturedScores = [];

            foreach ($games as $game) {
                $score = $scores->filter(function ($s) use ($competitor, $game) {
                    return $s->day_user_id == $competitor->day_user_id && $s->game_id == $game->id;
                })->first();

                if ($score) {
                    $points = $this->calculatePoints($score, $game);
                    $predictions[] = [
                        'game_id' => $game->id,
                        'home_score' => $score->home_score,
                        'away_score' => $score->away_score
                    ];
                    $capturedScores[] = [
                        'game_id' => $game->id,
                        'home_score' => $score->home_score,
                        'away_score' => $score->away_score
                    ];
                } else {
                    $points = 0;
                    $predictions[] = [
                        'game_id' => $game->id,
                        'home_score' => null,
                        'away_score' => null
                    ];
                    $capturedScores[] = [
                        'game_id' => $game->id,
                        'home_score' => null,
                        'away_score' => null
                    ];
                }
                $totalPoints += $points;
                $gameScores[] = [
                    'game_id' => $game->id,
                    'local_marker' => $game->local_marker,
                    'visiting_marker' => $game->visiting_marker
                ];
            }

            $rankings[] = [
                'competitor' => [
                    'id' => $competitor->competitor_id,
                    'name' => $competitor->name,
                    'last_name' => $competitor->last_name,
                    'second_surname' => $competitor->second_surname,
                    'birth_date' => $competitor->birth_date,
                    'phone' => $competitor->phone,
                    'profile_img' => $competitor->profile_img,
                    'email' => $competitor->email,
                    'authorize' => $competitor->authorize
                ],
                'points' => $totalPoints,
                'predicted_scores' => $predictions,
                'game_scores' => $gameScores,
                'captured_scores' => $capturedScores,
                'prediction_time' => $competitor->prediction_time
            ];
        }

        // Ordenar los competidores por puntos (desc) y por tiempo de registro (asc)
        usort($rankings, function ($a, $b) {
            if ($b['points'] == $a['points']) {
                return strtotime($a['prediction_time']) - strtotime($b['prediction_time']);
            }
            return $b['points'] - $a['points'];
        });

        return $rankings;
    }
}
