<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
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
        return new TaskCollection(Task::where("parent_id", "=", null)->paginate());
    }

    public function getTasksByProject($id)
    {
        $project = Project::with(['tasks'=> function($q){
            $q->where('parent_id', '=', null);
        }])->where('id', '=', $id)->paginate(15);

        return new TaskCollection($project);
    }

    public function getMyTasks()
    {
        $user = auth()->user();

        $userTasks = User::with(['tasks'=> function($q){
            $q->where('parent_id', '=', null);
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
        $task->parent_id = isset($attr['parent_id']) ? $attr['parent_id'] : null;
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

    public function update(UpdateTaskRequest $request, $id)
    {
        $attr = $request->validated();

        $task = Task::findOrFail($id);

        $task->title = $attr['title'];
        $task->description = $attr['description'];
        $task->priority = isset($attr['priority']) ? $attr['priority'] : 1;
        $task->parent_id = isset($attr['parent_id']) ? $attr['parent_id'] : null;
        $task->user_id = $request->user()->id;
        $task->project_id = $attr['project_id'];
        $task->task_status_id = $attr['task_status_id'];
        $task->save();

        return new TaskResource($task);
    }


    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if($task->delete()){

            return response()->json([
                'message' => 'The task was successfully deleted',
            ], 200);
        }

        return response()->json([
            'message' => 'A deletion error occurred',
        ], 200);
    }
}
