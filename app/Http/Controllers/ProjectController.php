<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Client;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{

    public function index()
    {
        return new ProjectCollection(Project::paginate());
    }

    public function getProjectsByClient($id)
    {
        $client = Client::findOrFail($id);

        return new ProjectCollection($client->projects()->paginate(15));
    }


    public function store(StoreProjectRequest $request)
    {
        $attr = $request->validated();

        $project = new Project();
        $project->title = $attr['title'];
        $project->description = $attr['description'];
        $project->status = isset($attr['status']) ? $attr['status'] : 0;
        $project->client_id = $attr['client_id'];
        $project->user_id = $request->user()->id;
        $project->save();

        return new ProjectResource($project);
    }

    public function show($id)
    {

        return new ProjectResource(Project::findOrFail($id));
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $attr = $request->validated();

        $project = Project::findOrFail($id);

        $project->title = $attr['title'];
        $project->description = $attr['description'];
        $project->status = isset($attr['status']) ? $attr['status'] : 0;
        $project->client_id = $attr['client_id'];
        $project->user_id = $request->user()->id;
        $project->save();

        return new ProjectResource($project);

    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        if($project->delete()){
            return response()->json([
                'message' => 'The project was successfully deleted',
            ], 200);
        }

        return response()->json([
            'message' => 'A deletion error occurred',
        ], 200);
    }
}
