<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Http\Resources\ProductImageResource;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Imagem dos produtos', description: 'Gestão das imagens dos produtos')]
class ProductImageController extends Controller
{
    /**
     * POST api/product-images
     *
     * Store a newly created resource in storage.
     */
    public function store(StoreProductImageRequest $request)
    {
        $data = $request->validated();

        $data['image'] = Storage::disk('public')->put('products', $data['image']);

        $result = ProductImage::create($data);

        return response()->json(new ProductImageResource($result));
    }

    /**
     * GET api/product-images/{productImage}
     *
     * Display the specified resource.
     */
    public function show(ProductImage $productImage)
    {
        return response()->json(new ProductImageResource($productImage));
    }

    /**
     * PUT api/product-images/{productImage}
     *
     * Update the specified resource in storage.
     */
    public function update(UpdateProductImageRequest $request, ProductImage $productImage)
    {
        $data = $request->validated();

        Storage::disk('public')->delete($productImage->image);
        Storage::disk('public')->put('products', $data['image']);

        $result = $productImage->update($data);

        return response()->json(new ProductImageResource($result));
    }

    /**
     * DELETE api/product-images/{productImage}
     *
     * Remove the specified resource from storage.
     */
    public function destroy(ProductImage $productImage)
    {
        if (Product::withCount('images')->find($productImage->product->id)->images_count == 1) {
            return response()->json(['messages' => ['error' => 'Você não pode excluir essa foto pois deve haver pelo menos uma foto no produto.']]);
        }

        Storage::disk('public')->delete($productImage->image);

        $productImage->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
