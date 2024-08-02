<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TypePay;
use App\Models\CatTypeOrigin;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;


class GeneralController extends Controller
{

    public function getAllAgents()
    {
        $agents = User::with('campaigns_sysca')->where('numero_empleado', '>', 0)->where('id_puesto', '=', 1)->orWhere('id_puesto', '=', 2)->orderBy('nombre_completo', 'ASC')->paginate(10);
        return response()->json([
            'status' => 'success',
            'message' => 'Agentes obtenidos correctamente',
            'data' => $agents
        ], 200);
    }
    public function getAgents(Request $request)
    {

        $id = $request->get('id');

        $agents = User::select('id', 'nombre_completo', 'numero_empleado')->where('numero_empleado', '>', 0)->where('id_puesto', '=', $id)->orderBy('nombre_completo', 'ASC')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Agentes obtenidos correctamente',
            'data' => $agents
        ], 200);
    }


    public function getTypePays()
    {
        $typePays = TypePay::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Get agentes',
            'data' => $typePays
        ], 200);
    }

    public function getLeaders()
    {

        $leaders = User::select('id', 'nombre_completo')->where('id_puesto', '=', 37)->where('id_estatus', '=', 1)->orderBy('nombre_completo', 'ASC')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Lideres obtenidos correctamente',
            'data' => $leaders
        ], 200);
    }

    public function getTypeOrigins()
    {
        $origins = CatTypeOrigin::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Oirigenes obtenidos correctamente',
            'data' => $origins
        ], 200);
    }


    public function agentDetail(Request $request)
    {
        $id = $request->get('id');
        $agent = User::with('campaigns_sysca')->find($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Agentes obtenidos correctamente',
            'data' => $agent
        ], 200);
    }


    public function test()
    {


        $times = DB::select('CALL get_hours_supervisor(?, ?)', [3, 2]);
        $horas =  array();
        foreach ($times as $key) {
            array_push($horas, $key->tiempo_conexion_agente);
        }
        // Crea el acumulador con el valor inicial de 0 horas
        $totalHoras = CarbonInterval::hours(0);

        // Recorre el arreglo de tiempos y agrega cada tiempo al acumulador
        foreach ($horas as $hora) {
            $intervalo = CarbonInterval::createFromFormat('H:i:s', $hora);
            $totalHoras->add($intervalo);
        }

        $users =
        DB::table('campaigns_group_agents_sysca')
        ->select('campaigns_group_agents_sysca.id_grupo', DB::raw("COUNT('groups_users_sysca.id_grupo') as tot_agents1"))
        ->join('groups_users_sysca', 'groups_users_sysca.id_grupo', '=', 'campaigns_group_agents_sysca.id_grupo')
        ->where('campaigns_group_agents_sysca.id_campania', '=', 2)
        ->groupBy('groups_users_sysca.id_grupo')
        ->get();



        // $mounth = $request->get('mounth');
        // $id = $request->get('id');
        $hora_final = explode(":", $totalHoras->format('%H:%I:%S'));
        $minuts = substr($hora_final[1], 0, 2);
        $secons = substr($hora_final[2], 0, 2);
        return response()->json([
            'status' => 'success',
            'message' => 'Agentes obtenidos correctamente',
            'horas' =>  $hora_final[0] . ':' . $minuts . ':' . $secons,
            'users' => $users

        ], 200);
    }
}
