<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Session;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('id','desc')->get();
        return view('tasks.index')->with('storedTasks',$tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'taskName' => 'required|min:5|max:255',
        ]);
        $task = new Task;

        $task->name = $request->taskName;
        $task->completed = false;
        $task->save();

        Session::flash('success','New task has been successfully added');
        
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('tasks.edit')->with('taskUnderEdit',$task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {   
        if($request->has('updatedTaskName')) {
            $this->validate($request, [
                'updatedTaskName' => 'required|min:5|max:255',
            ]);
    
            $task = Task::find($id);
               
            $task->name = $request->updatedTaskName;
    
            $task->save();
            echo("heyU");
            Session::flash('success','Task #'. $id . 'has been successfully updated');
        
        }  else {
            if($request->has('checkBox')) {
                $task = Task::find($id);
               
                $task->completed = false;
    
                $task->save();
                Session::flash('success','Task #'. $id . 'is pending');
                
            } else {
                $task = Task::find($id);
               
                $task->completed = true;
    
                $task->save();
                Session::flash('success','Task #'. $id . 'has been completed');
            }
        }
       
        
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        echo("heyD");
        Session::flash('success', 'Task #' . $id . 'has been successfully deleted');
        return redirect()->route('tasks.index');
    }
}
