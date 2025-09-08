<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreProjectRequest;
use App\Http\Requests\Api\V1\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // fetch the only user has logged in
        return ProjectResource::collection($request->user()->projects()->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        // Create a new project for the user that has logged in
        $project = $request->user()->projects()->create($request->validated());

        return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     */
    public function show(project $project)
    {
        // Check if the project belongs to the user that has logged in
        if (request()->user()->id !== $project->user_id){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, project $project)
    {
        // Checht the authorization
        if (request()->user()->id !== $project->user_id){
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        // Update the project
        $project->update($request->validated());

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(project $project)
    {
        // Chect the authorization
        if (request()->user()->id !== $project->user_id){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete the project
        $project->delete();

        return response()->noContent();
    }
}
