<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Produtos', description: 'Gestão dos produtos')]
class ProductController extends Controller
{
    /**
     * GET api/products
     *
     * Display a listing of the available products.
     */
    public function index()
    {
        $result = Product::with(['user', 'shop', 'comments', 'comments.user'])->where('stock_quantity', '<>', 0)->get();

        return response()->json(ProductResource::collection($result));
    }

    /**
     * POST api/products
     *
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $data['image'] = Storage::disk('public')->put('products', $data['image']);
        $data['shop_id'] = User::findOrFail($data['user_id'])->shop_id;

        $result = Product::create($data);

        return response()->json(new ProductResource($result->load(['user', 'shop', 'comments', 'comments.user'])));
    }

    /**
     * GET api/products/{product}
     *
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return response()->json(new ProductResource($product->load(['user', 'shop', 'comments', 'comments.user'])));
    }

    /**
     * PUT api/products/{product}
     *
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return response()->json(new ProductResource($product->load(['user', 'shop', 'comments', 'comments.user'])));
    }

    /**
     * PUT api/products/{product}/change-image
     *
     * Update the image of the product
     */
    public function updateProductImage(UpdateProductImageRequest $request, Product $product)
    {
        $data = $request->validated();

        Storage::disk('public')->delete($product->image);

        $data['image'] = Storage::disk('public')->put('products', $data['image']);

        $product->update($data);

        return response()->json(new ProductResource($product->load(['user', 'shop', 'comments', 'comments.user'])));
    }

    /**
     * DELETE api/products/{product}
     *
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
