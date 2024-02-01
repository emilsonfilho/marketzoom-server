<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopImageRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use Knuckles\Scribe\Attributes\Group;

#[Group(name: 'Lojas', description: 'Gestão de lojinhas')]
class ShopController extends Controller
{
    /**
     * GET api/shops
     *
     * Display a listing of the shops.
     */
    public function index()
    {
        return response()->json(ShopResource::collection(Shop::where('active', true)->get()));
    }

    /**
     * POST api/shops
     *
     * Store a newly created resource in storage.
     */
    public function store(StoreShopRequest $request)
    {
        $data = $request->validated();

        if (isset($data['profile'])) {
            $data['profile'] = Storage::disk('public')->put('shops', $data['profile']);
        }

        $data['admin_id'] = auth()->user()->id;

        $result = Shop::create($data);

        return response()->json(new ShopResource($result->load('admin')));
    }

    /**
     * GET api/shops/{shop}
     *
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        return response()->json(new ShopResource($shop));
    }

    /**
     * PUT api/shops/{shop}
     *
     * Update the specified resource in storage.
     */
    public function update(UpdateShopRequest $request, Shop $shop)
    {
        $shop->update($request->validated());

        return response()->json(new ShopResource($shop));
    }

    /**
     * PUT api/shops/{shop}/change-image
     *
     * Change the image of the shop
     */
    public function changeShopImage(UpdateShopImageRequest $request, Shop $shop)
    {
        $data = $request->validated();

        if (isset($shop->profile)) Storage::disk('public')->delete($shop->profile);

        $data['profile'] = Storage::disk('public')->put('shops', $data['profile']);

        $shop->update($data);

        return response()->json(new ShopResource($shop->load('admin')));
    }

    /**
     * PUT api/shops/{shop}/enable
     *
     * Enable a shop
     */
    public function enable(Shop $shop)
    {
        $shop->update([
            'active' => true,
        ]);

        return response()->json(new ShopResource($shop->load('admin')));
    }

    /**
     * PUT api/shops/{shop}/disable
     *
     * Disable a shop
     */
    public function disable(Shop $shop) {
        $shop->update([
            'active' => false,
        ]);

        return response()->json(new ShopResource($shop->load('admin')));
    }

    /**
     * DELETE api/shops/{shop}
     *
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {

    }
}
