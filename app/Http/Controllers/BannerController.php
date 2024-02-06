<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAllowedException;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Storage;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Banners', description: 'Gestão dos banners do sistema')]
class BannerController extends Controller
{
    /**
     * GET api/banners
     *
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(BannerResource::collection(Banner::all()));
    }

    /**
     * POST api/banners
     *
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        if (FacadesGate::denies('create-banner')) return NotAllowedException::notAllowed();

        $data = $request->validated();

        $data['image'] = Storage::disk('public')->put('banners', $data['image']);

        $result = Banner::create($data);

        return response()->json(new BannerResource($result));
    }

    /**
     * DELETE api/banners{banner}
     *
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        if (FacadesGate::denies('delete-banner')) return NotAllowedException::notAllowed();

        Storage::disk('public')->delete($banner->image);
        $banner->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
