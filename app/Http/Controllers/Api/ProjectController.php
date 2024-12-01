<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskProgress;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;

class ProjectController extends Controller
{

    public function index(Request $request)
    {

        $query = $request->get('query');

        $projects = Project::with(['task_progress']);

        if(!is_null($query) && $query != ''){

            $projects->where('name', 'like', '%'.$query.'%')->orderBy('id', 'desc');

            return response([
                'data' => $projects->paginate(10)
            ], 200);
        }

        return response([
            'data' => $projects->paginate(10)
        ], 200);
    }
    
    public function store(Request $request)
    {

        return DB::transaction( function () use($request){
            $fields = $request->all();

            $errors = Validator::make($fields,[
                'name' => 'required',
                'startDate' => 'required',
                'endDate' => 'required'
            ]);
    
            if($errors->fails())
            {
                return response($errors->errors()->all(), 422);
            }
    
            $project = Project::query()->create([
                'name' => $request->name,
                'status' => Project::NOT_STARTED,
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
                'slug' => Project::createSlug($request->name)
            ]);
    
            TaskProgress::query()->create([
                'projectId' => $project->id,
                'pinned_on_dashboard' => TaskProgress::NOT_PINNED_ON_DASHBOARD,
                'progress' => TaskProgress::INITIAL_PROJECT_PRECENT
            ]);
    
            return response([
                'message' => 'project created'
            ],200);
        });
       
    }

    public function update(Request $request)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'id' => 'required',
            'name' => 'required',
            'startDate' => 'required',
            'endDate' => 'required' 
        ]);

        if($errors->fails())
        {
            return response($errors->errors()->all(), 422);
        }

        Project::where('id', $request->id)->update([
            'name' => $request->name,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'status' => Project::NOT_STARTED,
            'slug' => Project::createSlug($request->name)
        ]);

        return response([
            'message' => 'project updated'
        ], 200);
    }

    public function pinnedProject(Request $request)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'projectId' => 'required|numeric'
        ]);

        if($errors->fails())
        {
            return response($errors->errors()->all());
        }

        TaskProgress::where('projectId', $request->projectId)->update([
            'pinned_on_dashboard' => TaskProgress::PINNED_ON_DASHBOARD
        ]);

        return response([
            'message' => 'project pinned on dashboard!'
        ], 200);
    }
}
