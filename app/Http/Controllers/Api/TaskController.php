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
                    'memberId' => $members[$i]
                ]);
            } 

            return response([
                'message' => 'task created'
            ],200);
        });
    }

    public function TaskToNotStartedToPending(Request $request)
    { 
        Task::changeTaskStatus($request->taskId,  Task::PENDING);

        return response([
            'message' => 'move task to pending'
        ], 200);

    }

    public function TaskToNotStartedToCompleted(Request $request)
    {
        Task::changeTaskStatus($request->taskId, Task::COMPLETED);

        return response([
            'message' => 'move task to completed'
        ], 200);
    }

    public function TaskToPendingToCompleted(Request $request)
    {
        Task::changeTaskStatus($request->taskId, Task::COMPLETED);

        return response([
            'message' => 'move task to completed'
        ], 200);
    }

    public function TaskToPendingToNotStarted(Request $request)
    {
        Task::changeTaskStatus($request->taskId, Task::NOT_STARTED);

        return response([
            'message' => 'move task to not started'
        ], 200);
    }

    public function TaskToCompletedToPending(Request $request)
    {
        Task::changeTaskStatus($request->taskId, Task::PENDING);

        return response([
            'message' => 'move task to pending'
        ], 200);
    }

    public function TaskToCompletedToNotStarted(Request $request)
    {
        Task::changeTaskStatus($request->taskId, Task::NOT_STARTED);

        return response([
            'message' => 'move task to not completed'
        ], 200);
    }
  
}
