<?php

namespace App\Services;

use App\Models\Assignment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function add(array $payload)
    {    
        $user = Auth::user(); 
        $payload['user_id'] = $user->id;
        $payload['status'] = 'In Progress';

        if (isset($payload['file'])) {
            $file = $payload['file'];
            $payload['file_path'] = $file->store('uploads', 'public');
        }

        $task = Task::create($payload);

        return [
            'data' => $task,
            'status' => 201,
            'message' => 'New tasks added successfully!'
        ];
        
    }

    public function get()
    {    
        $user = Auth::user();
        $tasks = Task::orderBy('created_at', 'desc')->get();
        
        return [
            'tasks' => $tasks,
            'message' => 'Tasks retrieved successfully',
            'status' => 200,
        ];
    }

    public function assign($taskId)
    {
        $user = Auth::user();
        $task = Task::findOrFail($taskId);
        $assignedPeople = request()->input('assigned_people');

        $assign = Assignment::updateOrCreate(
            [
                'user_id' => $user->id,
                'task_id' => $task->id,
            ],
            [
                'task_title' => $task->title,
                'assigned_people' => json_encode($assignedPeople), 
            ]
        );

        return [
            'data' => $assign,
            'message' => 'Tasks retrieved successfully',
            'status' => 200,
        ];
    }


}