<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Task\TaskUpdateRequest;
use App\Http\Requests\Api\V1\TaskStoreRequest;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min(100, (int) $request->get('per_page', 20)); // Limit to a maximum of 100 per page
        $query = Task::query();
        $tasks = $query->latest()->paginate($perPage);

        return $this->success($tasks, 'Tasks retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        try{
            $data = $request->validated();
            $task = Task::create([
                'created_by' => $request->user()->id,
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status ?? 'created',
            ]);
            return $this->success($task, 'Task created successfully', 201);
        }catch(\Exception $e){
            Log::error('Something Error'. $e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);    
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        try{
            $data = $request->validated();
            $task->fill($data)->save();            
            return $this->success($task, 'Task updated successfully');
        }catch(\Exception $e){
            Log::error('Something Error'. $e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);    
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
