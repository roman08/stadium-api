<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Competitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Mail\DemoMail;
use Auth;
use Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        //se valida la información que viene en $request
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|max:80',
            'password' => 'required|string|min:8',
            'role' => 'required|string|max:50'
        ]);

        //se crea el usuario en la base de datos
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role']
        ]);

        //se crea token de acceso personal para el usuario
        $token = $user->createToken('auth_token')->plainTextToken;

        //se devuelve una respuesta JSON con el token generado y el tipo de token
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(Request $request)
    {
        //valida las credenciales del usuario
        if (!Auth::attempt($request->only('user', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tus datos de acceso son inválidos'
            ], 200);
        }

        //Busca al usuario en la base de datos
        $user = User::where('user', $request['user'])->firstOrFail();
        //Genera un nuevo token para el usuario
        $token = $user->createToken('auth_token')->plainTextToken;

        //devuelve una respuesta JSON con el token generado y el tipo de token
        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user
        ]);
    }

    // TODO : LOGIN USER
    public function loginUser(Request $request)
    {
        //valida las credenciales del usuario
        if (!Auth::guard('competitors')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tus datos de acceso son inválidos'
            ], 200);
        }
        //Busca al usuario en la base de datos
        $user = Competitor::where('email', $request['email'])->firstOrFail();
        //Genera un nuevo token para el usuario
        $token = $user->createToken('auth_token')->plainTextToken;

        //devuelve una respuesta JSON con el token generado y el tipo de token
        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user
        ]);
    }

    public function dataUser(Request $request)
    {
        //devuelve la información del usuario
        return $request->user()->role;
    }

    public function logout()
    {
        Auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'msg' => 'Sesión cerrada correctamente'
        ]);
    }

    public function sendEmail(Request $request)
    {
        $email = $request->email;



        $user = User::where('email', '=', $email)->get();


        if (count($user) > 0) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randstring = '';
            for ($i = 0; $i < 15; $i++) {
                $randstring .= $characters[rand(0, strlen($characters))];
            }


            $mailData = [
                'title' =>  'Dirsa México - Solicitud de nueva contrasña',
                'body' =>   'El cambio de contraseña se realizo correctamente.',
                'pass' =>   $randstring
            ];

            Mail::to($email)->send(new DemoMail($mailData));
            $newPass = Hash::make($randstring);

            $user = User::where('email', '=', $email)
                ->update(['password' => $newPass]);

            return response()->json([
                'status'    => 'success',
                'msg'       => 'Se ha enviado a su correo la nueva contraseña.',

            ]);
        }

        return response()->json([
            'status'    => 'error',
            'msg'       => 'El correo ingresado no existe.',

        ]);
    }
}
