<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
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
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopRequest $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
