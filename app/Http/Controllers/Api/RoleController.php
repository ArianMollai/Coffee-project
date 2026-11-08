<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\Role\Contract\RoleServiceInterface;
use App\Services\Role\RoleService;
use Illuminate\Support\Collection;
use App\Http\Resources\RoleResource;
use App\Http\Requests\Role\RoleCreateRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Support\Facades\Gate;



class RoleController extends Controller
{
    public function __construct(private RoleServiceInterface $roleService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewRoles', Role::class);

        return RoleResource::collection($this->roleService->all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(RoleCreateRequest $request)
    {
        $this->authorize('create', Role::class);

        if(isset($request['users'])){
            $this->authorize('assign-roles', Role::class);
        }

        $createdRole=$this->roleService->create($request->validated());

        return new RoleResource($createdRole);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $this->authorize('view', Role::class);

        return new RoleResource($this->roleService->get($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, int $id)
    {
        $this->authorize('update', Role::class);

        if(isset($request['users'])){
            $this->authorize('assign-roles', Role::class);
        }

        $requestValidated=$request->validated();

        $updatedRole=$this->roleService->update($id, $requestValidated);

        return new RoleResource($updatedRole);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->authorize('delete', Role::class);

        $this->roleService->delete($id);

        return response()->json([
            'message' => 'Role deleted successfully'
        ]);
    }
}
