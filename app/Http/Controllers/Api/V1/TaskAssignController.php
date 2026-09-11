<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TaskAssign\TaskAssignStoreRequest;
use App\Models\Group;
use App\Models\Task;
use App\Models\TasksAssign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Task $task)
    {
        $perPage = min(100, (int) $request->get('per_page', 20)); // Limit to a maximum of 100 per page
        $query = TasksAssign::where('task_id', $task->id)
            ->with(['assignedBy:id,name'])
            ->paginate($perPage);
        return $this->success($query, 'Task assigned retrieved successfully');
        
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
    public function store(TaskAssignStoreRequest $request, Task $task)
    {
        $validated = $request->validated();

        try{
            if($validated['assignable_type'] === 'user'){
                User::findOrFail($validated['assignable_id']);
            }else{
                Group::findOrFail($validated['assignable_id']);
            }

            // $alreadyAssigned = TasksAssign::where('task_id', $task->id)
            //     ->where('assignable_type', $validated['assignable_type'])
            //     ->where('assignable_id', $validated['assignable_id'])
            //     ->exists();

            // if ($alreadyAssigned) {
            //     return $this->error(['error' => 'This task is already assigned to this ' . $validated['assignable_type']], 422);
            // }
            $taskAssignment = TasksAssign::create([
                'task_id' => $task->id,
                'assignable_type' => $validated['assignable_type'],
                'assignable_id' => $validated['assignable_id'],
                'assigned_by' => $request->user()->id,
                'assigned_at' => now(),
            ]);
            return $this->success($taskAssignment, 'Task assigned successfully', 201);
        }catch (\Exception $e){
            Log::error('Task assign store Error'. $e->getMessage());
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
