<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskStatusCollection;
use App\Http\Resources\TaskStatusResource;
use App\Models\TaskStatus;
use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;

class TaskStatusController extends Controller
{

    public function index()
    {
        return new TaskStatusCollection(TaskStatus::orderBy('position', 'asc')->paginate());
    }

    public function store(StoreTaskStatusRequest $request)
    {
        $attr = $request->validated();

        $taskStatus = new TaskStatus();
        $taskStatus->title = $attr['title'];
        $taskStatus->position = isset($attr['position']) ? $attr['position'] : ((int)TaskStatus::max('position') + 1);
        $taskStatus->save();

        return new TaskStatusResource($taskStatus);
    }

    public function update(UpdateTaskStatusRequest $request, $id)
    {
        $attr = $request->validated();

        $taskStatus = TaskStatus::findOrFail($id);
        $taskStatus->title = $attr['title'];
        $taskStatus->position = isset($attr['position']) ? $attr['position'] : ((int)TaskStatus::max('position') + 1);
        $taskStatus->save();

        return new TaskStatusResource($taskStatus);
    }

    public function destroy($id)
    {
        $taskStatus = TaskStatus::findOrFail($id);

        if($taskStatus->delete()){

            return response()->json([
                'message' => 'The task status was successfully deleted',
            ], 200);
        }

        return response()->json([
            'message' => 'A deletion error occurred',
        ], 200);
    }
}
