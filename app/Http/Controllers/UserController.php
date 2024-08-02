<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(Request $request)
    {

        $numero_empleado = $request->get('numero_empleado');

        $users = User::where('numero_empleado', '=',$numero_empleado)->orWhere('nombre_completo', 'like', '%' . $numero_empleado . '%' )->with('campanias')->orderBy('nombre_completo', 'ASC')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Usuarios obtenidos correctamente',
            'data' => $users
        ], 200);
    }
}
