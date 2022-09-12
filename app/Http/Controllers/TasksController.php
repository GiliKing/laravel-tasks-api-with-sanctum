<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TasksResource;
use App\Http\Requests\StoreTaskRequest;
use App\Traits\HttpResponses;

class TasksController extends Controller
{
    use HttpResponses;
     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TasksResource::collection(
            Task::where('user_id', auth()->user()->id)->get()
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated($request->all());

        $task = Task::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority
        ]);

        return new TasksResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return $this->IsNotAuthorized($task) ? $this->IsNotAuthorized($task) : new TasksResource($task);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        if($this->IsNotAuthorized($task)) {

           return $this->IsNotAuthorized($task);

        } else {

            $task->update($request->all());

            return new TasksResource($task);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if($this->IsNotAuthorized($task)) {
             return $this->IsNotAuthorized($task);
        } else {

            $task->delete();

            return response(null, 204);

        }
        
    }

    private function IsNotAuthorized($task) {

        if(auth()->user()->id !== $task->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }

    }
}
