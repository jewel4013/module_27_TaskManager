<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = min(100, (int) $request->get('per_page', 20)); // Limit to a maximum of 100 per page
        $query = Group::query();
        $groups = $query->latest()->paginate($perPage);

        return $this->success($groups, 'Groups retrieved successfully');
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try{
            $group = Group::create($data);
            return $this->success($group, 'Group created successfully', 201);
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
    public function update(Request $request, Group $group)
    {
        $date = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try{
            $group->fill($date)->save();            
            return $this->success($group, 'Group updated successfully');
        }catch(\Exception $e){
            Log::error('Something Error'. $e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);                
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        try{
            $group->delete();
            return $this->success(null, 'Group deleted successfully');
        }catch(\Exception $e){
            Log::error('Something Error'. $e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);                
        }
    }
}
