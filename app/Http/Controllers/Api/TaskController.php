<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Events\NewTaskAdded;
use App\Events\TaskUpdated;
use App\Models\Status;
use App\Http\Resources\StatusResource;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
      $statuses = Status::with(["tasks"])->get();

      return (new StatusResource($statuses))->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $task = Task::create([
          "title" => $input["title"],
          "description" => $input["description"],
          "due_date" => $input["date"],
          "status_id" => $input["statusId"]
        ]);

        event(new NewTaskAdded($task));

        return (new TaskResource($task))->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $taskId)
    {
      $input = $request->all();

      $task = Task::find($taskId);
      $task->fill([
        "title" => $input["data"]["title"],
        "description" => $input["data"]["description"],
        "due_date" => $input["data"]["date"],
      ]);
      $task->save();

      event(new TaskUpdated($task));

      return (new TaskResource($task))->response();
    }

    public function sort(Request $request, $taskId) {
      $input = $request->all();
      
      $task = Task::find($taskId);
      $task->status_id = $input["newStatusId"];
      $task->save();

      event(new TaskUpdated($task));

      return (new TaskResource($task))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
