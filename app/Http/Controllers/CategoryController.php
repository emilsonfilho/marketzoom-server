<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAllowedException;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Gate;
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
        $result = Category::has('products')->where('showed', true)->get();

        return response()->json(CategoryResource::collection($result));
    }

    /**
     * PUT api/categories/{category}/display
     *
     * Makes a category appear on the home screen
     */
    public function display(Category $category) {
        $quantity_shown = Category::where('showed', true)->count();

        if ($quantity_shown >= 4) {
            return response()->json(['error' => 'Você não pode mostrar mais do que quatro categorias no menu.'], 400);
        }

        $category->update([
            'showed' => true
        ]);

        return response()->json(new CategoryResource($category->load('products')));
    }

    /**
     * PUT api/categories/{category}/hide
     *
     * Remove a category from the home screen display
     */
    public function hide(Category $category) {
        $category->update([
            'showed' => false,
        ]);

        return response()->json(new CategoryResource($category->load('products')));
    }


    /**
     * POST api/categories
     *
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        if (Gate::denies('create-category')) return NotAllowedException::notAllowed();

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
        return response()->json(new CategoryResource($category->load('products')));
    }

    /**
     * PUT api/categories/{category}
     *
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if (Gate::denies('update-category')) return NotAllowedException::notAllowed();

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
        if (Gate::denies('delete-category')) return NotAllowedException::notAllowed();

        CategoryProduct::where('category_id', $category->id)->delete();
        $category->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
