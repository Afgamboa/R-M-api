<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function login(Request $request)
  {
    $params = $request->request->all();
    $user = DB::table('users')->where('email', $params['email'])->first();

    if (!$user) {
      return abort(401, 'Correo o contraseña invalidas por favor verifiquelas');
    }
    return $user;
  }
  public function register(Request $request)
  {
    $data = $request->request->all();

    $email = $data['email'];
    $name = $data['name'];
    $password = $data['password'];


    $user = DB::table('users')->where('email', $email)->first();

    if (!is_null($user)) {
      return response()->json([
        'error' => true,
        'message' => 'El correo electrónico ya ha sido registrado'
      ]);
    }

    $password = Hash::make($password);

    DB::table('users')->insert([
      'name' => $name,
      'email' => $email,
      'password' => $password,
    ]);

    $user = DB::table('users')->where('email', $email)->first();

    return response()->json([
      'error' => false,
      'message' => '¡Registro exitoso!',
      'user' => $user
    ]);

  }
  public function profile($id)
  {
    $userData = DB::table('users')->where('id', $id)->first();
    if (!$userData) {
      return abort(400, 'No se encontró un usuario con el ID proporcionado');
    }

    return $userData;
  }

  public function updateProfile(Request $request, string $id)
  {
    $data = $request->request->all();
    $updateData = [];
    if (!empty($data['name'])) {
      $updateData['name'] = $data['name'];
    }
    if (!empty($data['email'])) {
      $updateData['email'] = $data['email'];
    }
    if (!empty($data['address'])) {
      $updateData['address'] = $data['address'];
    }
    if (!empty($data['city'])) {
      $updateData['city'] = $data['city'];
    }
    if (empty($updateData)) {
      return response()->json(['message' => 'No hay Data para actualizar'], 400);
    }

    $update = DB::table('users')
      ->where('id', $id)
      ->update($updateData);

    return response()->json(['message' => 'Usuario actualizado correctamente', 'data' => $update], 200);
  }
}