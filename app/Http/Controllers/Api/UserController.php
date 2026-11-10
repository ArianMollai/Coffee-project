<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Users\UserServices;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\User\CreateNewUserRequest;
use App\Models\Role;

class UserController extends Controller
{
    public function __construct(private UserServices $service){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        return UserResource::collection($this->service->list());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user=$this->service->get($id);

        Gate::authorize('view', $user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, UpdateUserRequest $request)
    {
        $requestValidated=$request->validated();

        $user=$this->service->get($id);

        Gate::authorize('update', $user);

        if(array_key_exists('role_ids', $requestValidated)){
            $this->authorize('AssignRoles', $user, Role::class);
        }

        $updatedUser=$this->service->update($id, $requestValidated);

        return new UserResource($updatedUser);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user=$this->service->get($id);

        Gate::authorize('delete', $user);

        $this->service->delete($id);

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    public function CreateNewUser(CreateNewUserRequest $request){
        Gate::authorize('create', User::class);

        $requestValidated=$request->validated();

        if(array_key_exists('role_ids', $requestValidated)){
            Gate::authorize('AssignRoles', Role::class);
        }

        return new UserResource($this->service->CreateNewUser($request->validated()));
    }
}
