<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskMember;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function createTask(Request $request)
    {
        return DB::transaction(function() use($request){
            $fields = $request->all();

            $errors = Validator::make($fields, [
                'projectId' => 'required|numeric',
                'name' => 'required',
                'memberIds' => 'required|array',
                'memberIds.*' => 'numeric'
            ]);

            if($errors->fails())
            {
                return response($errors->errors()->all());
            }

            $task = Task::query()->create([
                'projectId' => $request->projectId,
                'name' => $request->name,
                'status' => Task::NOT_STARTED 
            ]);

            $members = $fields['memberIds'];

            for($i=0; $i < count($members); $i++)
            {
                TaskMember::query()->create([
                    'projectId' => $request->projectId,
                    'taskId' => $task->id,
                    'memberIds' => $members[$i]
                ]);
            } 

            return response([
                'message' => 'task created'
            ],200);
        });
    }
  
}
