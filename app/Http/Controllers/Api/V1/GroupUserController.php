<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Api\V1\GroupUser\GruopUserStoreRequest;
use App\Models\User;

class GroupUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Group $group)
    {
        $perPage = min(100, (int) $request->get('per_page', 20)); // Limit to a maximum of 100 per page
        $query = $group->users()->paginate($perPage);

        return $this->success($query, 'Group users retrieved successfully');
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
    public function store(GruopUserStoreRequest $request, Group $group)
    {
         $validated = $request->validated();

        try{
            $ids = collect($validated['user_ids'] ?? []);

            if(!empty($validated['user_id'])){
                $ids->push($validated['user_id']);
            }
            $group->users()->syncWithoutDetaching($ids);

            $groupUserData = $group->users()->select('users.id', 'users.name', 'users.email')->get();
            return $this->success($groupUserData, 'GroupUser created successfully', 201);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group, User $user)
    {
        try{
            $group->users()->detach($user);
            return $this->success(null, 'GroupUser removed successfully', 200);
        }catch(\Exception $e){
            Log::error('Something Error'. $e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);                
        }
    }
}
