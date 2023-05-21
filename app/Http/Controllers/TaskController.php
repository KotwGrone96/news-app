<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index',['tasks'=>$tasks]);
    }

    public function create(Request $request)
    {

        
    }
    public function show($id)
    {
        $task = Task::where('id',$id)->first();

        return view('tasks.show',['task'=>$task]);
    }

    public function store(Request $request)
    {
       try {
        $task = new Task();
        $task->task_name = $request->name;
        $task->description = $request->description;
        $task->save();
        return response()->json(['ok'=>true, 'msg'=>'Tarea agregada']);
       } catch (\Throwable $th) {
        return response()->json(['ok'=>false, 'msg'=>$th->getMessage()]);
       }
    }

    public function edit(Request $request, $id)
    {
        $task = Task::where('id',$id)->first();
        if(!$task){
            return view('tasks.edit',['error'=>true]);
        }
        return view('tasks.edit',['task'=>$task,'error'=>false]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::where('id',$id)->first();
        if(!$task){
            return response()->json(['ok'=>false, 'msg'=>'No se ha encontrado la tarea']);
        }
        $task->task_name = $request->name;
        $task->description = $request->description;
        $task->save();
        return response()->json(['ok'=>true, 'msg'=>'Tarea editada correctamente']);
    }

    public function destroy(Request $request, $id)
    {
        $task = Task::where('id',$id)->first();
        if(!$task){
            return response()->json(['ok'=>false, 'msg'=>'No se ha encontrado la tarea']);
        }
        $task->delete();
        return response()->json(['ok'=>true, 'msg'=>'Tarea se eliminó correctamente']);
    }
}
