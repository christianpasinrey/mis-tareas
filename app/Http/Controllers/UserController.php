<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return response()->json(User::with('tasksAssigned')->get());
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error al obtener los usuarios',
                'error'=> $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $user = User::create($request->all());
        }catch(\Exception $e){
            throw new \Exception('No se ha podido crear el usuario');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        try{
           return response()->json($user->load('tasksAssigned'));
        }catch(\Exception){
            throw new \Exception('Error al obtener la tarea');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try{
            $user->update($request->all());
        }catch(\Exception $e){
            throw new \Exception('No se ha podido actualizar el usuario');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
        }catch(\Exception $e){
            throw new \Exception('Error al eliminar el usuario');
        }
        return response()->json([
            'message' => 'Usuario eliminado correctamente',
        ], 200);
    }
}
