<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function store(Request $request)
    {
        $task = $this->taskService->add($request->all());
        return response($task, $task['status']);
    }

    public function read()
    {
        $task = $this->taskService->get();
        return response($task, $task['status']);
    }

    public function assignTask(Request $request)
    {
        $taskId = $request->input('task_id');
        $task = $this->taskService->assign($taskId);
        return response($task, $task['status']);
    }

}
