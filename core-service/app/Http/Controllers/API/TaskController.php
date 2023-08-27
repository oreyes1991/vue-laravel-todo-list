<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Task;
use Validator;
use App\Http\Resources\TaskResource;
use Illuminate\Http\JsonResponse;

class TaskController extends BaseController
{
    /**
     * Display all tasks by user
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        $user_id = $request->user()->id;
        $tasks = Task::get()->where('user_id', $user_id);
        return $this->sendResponse(TaskResource::collection($tasks), '');
    }
    /**
     * Create a new task
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $task = Task::create($input);

        return $this->sendResponse(new TaskResource($task), 'Task created successfully.');
    }


    /**
     * Update task
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        $input = $request->all();
        $user_id = $request->user()->id;
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        if ($task->user_id != $user_id) {
            return $this->sendError('Error users can only edit own tasks', [], 401);
        }

        if (array_key_exists('user_id', $input)) {
            return $this->sendError('Error not additional properties allow', [], 400);
        }

        $task->name = $input['name'];
        $task->description = $input['description'];
        if (array_key_exists('completed_at', $input)) {
            $task->completed_at = $input['completed_at'];
        }
        $task->save();

        return $this->sendResponse(new TaskResource($task), 'Task updated successfully.');
    }

    /**
     * Deleted a task
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Task $task): JsonResponse
    {
        $user_id = $request->user()->id;
        if ($task->user_id != $user_id) {
            return $this->sendError('Error users can only delete own tasks', [], 401);
        }
        $task->delete();

        return $this->sendResponse([], 'Task deleted successfully.');
    }
}
