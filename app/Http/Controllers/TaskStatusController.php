<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
           return response()->json(TaskStatus::all());
        }catch(\Exception){
            throw new \Exception('Error al obtener los estados de las tareas');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskStatusRequest $request)
    {
        try{
            $validated = $request->validated();
        }catch(\Illuminate\Validation\ValidationException $e){
            throw new \Illuminate\Validation\ValidationException($e->validator, response()->json([
                'message' => 'No se han podido validar los datos',
                'errors' => $e->errors()
            ], 400));
        }
        $taskStatus = TaskStatus::create($validated);
        return response()->json([
            'message' => 'Estado de tarea creado correctamente',
            'taskStatus' => $taskStatus
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function show(TaskStatus $taskStatus)
    {
        try{
           return response()->json($taskStatus);
        }catch(\Exception){
            throw new \Exception('Error al obtener el estado de la tarea');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskStatusRequest  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus)
    {
        try{
            $validated = $request->validated();
        }catch(\Illuminate\Validation\ValidationException $e){
            throw new \Illuminate\Validation\ValidationException($e->validator, response()->json([
                'message' => 'No se han podido validar los datos',
                'errors' => $e->errors()
            ], 400));
        }
        $taskStatus->update($validated);
        return response()->json([
            'message' => 'Estado de tarea actualizado correctamente',
            'taskStatus' => $taskStatus
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if($taskStatus->tasks()->count() > 0){
            throw new \Exception('No se puede eliminar un estado de tarea que tenga tareas asociadas');
        }
        try{
            $taskStatus->delete();
            return response()->json([
                'message' => 'Estado de tarea eliminado correctamente'
            ], 200);
        }catch(\Exception){
            throw new \Exception('Error al eliminar el estado de la tarea');
        }
    }
}
