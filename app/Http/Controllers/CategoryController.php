<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Categorias', description: 'Gestão de Categorias')]
class CategoryController extends Controller
{
    /**
     * GET api/categories
     *
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(CategoryResource::collection(Category::all()));
    }

    /**
     * GET api/categories/available
     *
     * Display a listing of the available resource.
     */
    public function available() {
        $result = Category::has('products')->get();

        return response()->json(CategoryResource::collection($result));
    }

    /**
     * POST api/categories
     *
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $result = Category::create($request->validated());

        return response()->json(new CategoryResource($result));
    }


    /**
     * GET api/categories/{category}
     *
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json(CategoryResource::collection($category->load('products')));
    }

    /**
     * PUT api/categories/{category}
     *
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json(new CategoryResource($category));
    }

    /**
     * DELETE api/categories/{category}
     *
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
