<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Category\Contract\CategoryServiceInterface;
use Illuminate\Support\Collection;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;


class CategoryController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService){}

    public function Index()
    {
        $this->authorize('viewAny', Category::class);

        return CategoryResource::collection($this->categoryService->Index());
    }

    public function ViewOne(int $id)
    {
        $this->authorize('view', Category::class);

        $category=$this->categoryService->ViewOne($id);

        return new CategoryResource($this->categoryService->ViewOne($id));
    }

    public function Create(CreateCategoryRequest $request){

        $this->authorize('create', Category::class);

        $validated=$request->validated();

        return CategoryResource::collection($this->categoryService->Create($validated));

        //return new CategoryResource($this->categoryService->Create($validated));
    }

    public function Update(int $id, UpdateCategoryRequest $request){
        $validated=$request->validated();

        $this->authorize('update', Category::class);

        return CategoryResource::collection($this->categoryService->Update($id, $validated));
    }

    public function Delete(int $id){
        $this->authorize('delete', Category::class);

        return CategoryResource::collection($this->categoryService->Delete($id));
    }
}
