<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
   
    public function index():JsonResponse
    {
        return $this->response(Category::all());
    }

   
    public function store(StoreCategoryRequest $request)
    {
        //
    }


    public function show(Category $category)
    {
        return $this->response(new CategoryResource($category));
    }

   
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }


    public function destroy(Category $category)
    {
        //
    }
}
