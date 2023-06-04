<?php

namespace App\Http\Controllers;

use App\Models\TasksPanel;
use App\Http\Requests\StoreTasksPanelRequest;
use App\Http\Requests\UpdateTasksPanelRequest;
use Illuminate\Http\Request;

class TasksPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return response()->json(TasksPanel::with('tasks','tasks.user','tasks.users','users')->get());
        }catch(\Exception){
            throw new \Exception('Error al obtener las tareas');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTasksPanelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTasksPanelRequest $request)
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
        $tasksPanel = TasksPanel::create($validated);
        if(isset($validated['users'])){
            $tasksPanel->users()->sync($validated['users']);
        }
        $tasksPanel->load('users');
        return response()->json([
            'message' => 'Panel creado correctamente',
            'tasksPanel' => $tasksPanel
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TasksPanel  $tasksPanel
     * @return \Illuminate\Http\Response
     */
    public function show(TasksPanel $tasksPanel)
    {
        try{
            return response()->json($tasksPanel->load('tasks','tasks.user','tasks.users'));
        }catch(\Exception){
            throw new \Exception('Error al obtener el panel');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTasksPanelRequest  $request
     * @param  \App\Models\TasksPanel  $tasksPanel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTasksPanelRequest $request, TasksPanel $tasksPanel)
    {
        try{
            $validated = $request->validated();
        }catch(\Illuminate\Validation\ValidationException $e){
            throw new \Illuminate\Validation\ValidationException($e->validator, response()->json([
                'message' => 'No se han podido validar los datos',
                'errors' => $e->errors()
            ], 400));
        }
        $tasksPanel->update($validated);
        return response()->json([
            'message' => 'Panel actualizado correctamente',
            'tasksPanel' => $tasksPanel
        ], 200);
    }

    public function updateAssignments(Request $request, $id)
    {
        try{
            $tasksPanel = TasksPanel::findOrFail($id);
        }catch(\Exception){
            throw new \Exception('Error al obtener el panel');
        }
        $tasksPanel->users()->sync($request->users);
        return response()->json([
            'message' => 'Panel actualizado correctamente',
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TasksPanel  $tasksPanel
     * @return \Illuminate\Http\Response
     */
    public function destroy(TasksPanel $tasksPanel)
    {
        try{
            $tasksPanel->delete();
        }catch(\Exception){
            throw new \Exception('Error al eliminar el panel');
        }
        return response()->json([
            'message' => 'Panel eliminado correctamente'
        ], 200);
    }
}
