<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Task;


class TaskController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function get_page(){
        return view('admin.task.task');
    }

  function save_task(Request $request){


        $task = new Task;

        $task->task_number = 'Task:'.uniqid();
        $task->user_id = $request->user_id;
        $task->type_of_task = $request->type_of_task;
        $task->task_date = $request->task_date;
        $task->agent_name = $request->agent_name;
        $task->task_hour = $request->task_hour;
        $task->task_place = $request->task_place;
        $task->task_note = $request->task_note;


        $task->save();


        return redirect()->back()->with('success', 'New Task Added');
    }

    function update_task($task_number){

      $task = Task::where('task_number', $task_number)->get();
      return view('admin.task.update', compact('task'));

    }

    function delete_task($id){
        $task = Task::find($id);
        $task->delete();

        return redirect()->back();
    }

        function update_form_task(Request $request, $id){


        $task = Task::find($id);

        $task->task_number = $request->task_number;
        $task->user_id = $request->user_id;
        $task->type_of_task = $request->type_of_task;
        $task->task_date = $request->task_date;
        $task->task_hour = $request->task_hour;
        $task->task_place = $request->task_place;
        $task->task_note = $request->task_note;
        $task->task_status = $request->task_status;

        $task->save();


        return redirect()->back()->with('success', 'Gespeichert');
    }
}
