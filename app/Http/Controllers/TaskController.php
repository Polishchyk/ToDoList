<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        return new TaskCollection(Task::where("parent_id", "=", 0)->paginate());
    }

    public function getTasksByProject($id)
    {
        $project = Project::with(['tasks'=> function($q){
            $q->where('parent_id', '=', 0);
        }])->where('id', '=', $id)->paginate(15);

        return new TaskCollection($project);
    }

    public function getMyTasks()
    {
        $user = auth()->user();

        $userTasks = User::with(['tasks'=> function($q){
            $q->where('parent_id', '=', 0);
        }])->where('id', '=', $user->id)->paginate(15);

        return new TaskCollection($userTasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $attr = $request->validated();

        $task = new Task();
        $task->title = $attr['title'];
        $task->description = $attr['description'];
        $task->priority = isset($attr['priority']) ? $attr['priority'] : 1;
        $task->parent_id = isset($attr['parent_id']) ? $attr['parent_id'] : 0;
        $task->user_id = $request->user()->id;
        $task->project_id = $attr['project_id'];
        $task->task_status_id = $attr['task_status_id'];
        $task->save();

        return new TaskResource($task);
    }

    public function show($id)
    {
        $tasks = Task::where('id', "=", $id)
            ->with(['childrenTasks'])
            ->paginate(15);

        return new TaskCollection($tasks);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
