<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return response()->json(Task::with('users')->filter(request()->only('search'))->get());
        }catch(\Exception){
            throw new \Exception('Error al obtener las tareas');
        }
    }

    public function userTasks($id){
        try{
            $user = User::findOrFail($id);
        }catch(\Exception){
            throw new \Exception('Error al obtener el usuario');
        }
        $tasks = Task::with('users')->where('user_id', $user->id)->orWhereIn('id', $user->tasksAssigned->pluck('id'))->get();
        return response()->json($tasks);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        try{
            $validated = $request->validated();
        }catch(\Illuminate\Validation\ValidationException $e){
            throw new \Illuminate\Validation\ValidationException($e->validator, response()->json([
                'message' => 'No se han podido validar los datos',
                'errors' => $e->errors()
            ], 400));
        }
        $validated['user_id'] = auth()->user()->id;
        $validated['status_id'] = 1;
        $task = Task::create($validated);
        $task->users()->sync($validated['users']);
        return response()->json([
            'message' => 'Tarea creada correctamente',
            'task' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        try{
           return response()->json($task->load('users'));
        }catch(\Exception){
            throw new \Exception('Error al obtener la tarea');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        try{
            $validated = $request->validated();
        }catch(\Illuminate\Validation\ValidationException $e){
            throw new \Illuminate\Validation\ValidationException($e->validator, response()->json([
                'message' => 'No se han podido validar los datos',
                'errors' => $e->errors()
            ], 400));
        }
        $task->update($validated);

        $task->users()->sync($request['users']);
        return response()->json([
            'message' => 'Tarea actualizada correctamente',
            'task' => $task
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        try{
            $task->users()->detach();
            $task->delete();
        }catch(\Exception $e){
            throw new \Exception('Error al eliminar la tarea');
        }
        return response()->json([
            'message' => 'Tarea eliminada correctamente',
        ], 200);
    }
}
