<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Events\TaskCreated;
use App\Events\TaskUpdated;
use App\Events\TaskSorted;
use App\Events\TaskDeleted;
use App\Models\Status;
use App\Http\Resources\StatusResource;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\SortTaskRequest;

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
    public function store(StoreTaskRequest $request)
    {
        $input = $request->all();

        $task = Task::create([
          "title" => $input["title"],
          "description" => $input["description"],
          "due_date" => $input["date"],
          "status_id" => $input["statusId"]
        ]);

        event(new TaskCreated($task));

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
    public function update(UpdateTaskRequest $request, $taskId)
    {
      $input = $request->all();

      $task = Task::find($taskId);
      $task->fill([
        "title" => $input["title"],
        "description" => $input["description"],
        "due_date" => $input["date"],
      ]);
      $task->save();

      event(new TaskUpdated($task));

      return (new TaskResource($task))->response();
    }

    public function sort(SortTaskRequest $request, $taskId) {
      $input = $request->all();
      
      $task = Task::find($taskId);
      $task->status_id = $input["newStatusId"];
      $task->save();

      event(new TaskSorted($task));

      return ["message" => "Task Sorted Successfully"];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($taskId)
    {
      $task = Task::destroy($taskId);

      event(new TaskDeleted());

      return response(["message" => "Task Deleted Successfully"]);
    }
}
