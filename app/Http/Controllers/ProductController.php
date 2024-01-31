<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        $result = Product::select(
            'products.*',
            DB::raw('COUNT(comments.id) as total_ratings'),
            DB::raw('COALESCE(AVG(comments.rating), 0) as average_rating')
        )
            ->with(['user', 'shop', 'comments', 'comments.user'])
            ->leftJoin('comments', 'comments.product_id', '=', 'products.id')
            ->where('stock_quantity', '<>', 0)
            ->groupBy('products.id')
            ->get();

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
        $this->setRatings($product);
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
        $this->setRatings($product);

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
        $this->setRatings($product);

        return response()->json(new ProductResource($product->load(['user', 'shop', 'comments', 'comments.user'])));
    }

    /**
     * DELETE api/products/{product}
     *
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->comments()->forceDelete();
        $product->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    private function setRatings($item)
    {
        $item['total_ratings'] = $item->comments->count('rating');
        $item['average_rating'] = $item['total_ratings'] > 0 ? $item->comments->sum('rating') / $item['total_ratings'] : 0;
    }

    public function search(string $search = '')
    {
        if (!$search) return response()->json(null, Response::HTTP_NO_CONTENT);

        $result = Product::with(['user', 'shop', 'comments', 'comments.user'])->where('name', 'like', "%{$search}%")->get();

        return response()->json(ProductResource::collection($result));
    }
}
