<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleBusinessLocation;
use Illuminate\Http\Request;
use App\Http\Requests\BusinessLocationRequest;
use App\Http\Resources\BusinessLocationResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class SaleBusinessLocationController extends Controller
{
    protected $saleBusinessLocation;

    /**
     * Constructor
     *
     * @param \App\Models\SaleBusinessLocation $saleBusinessLocation 
     */
    public function __construct(SaleBusinessLocation $saleBusinessLocation)
    {
        $this->middleware('api.admin');
        $this->middleware('permission:Ventas - listar ubicaciones empresa', ['only' => ['index']]);
        $this->middleware('permission:Ventas - crear ubicacion empresa', ['only' => ['store']]);
        $this->middleware('permission:Ventas - mostrar ubicacion empresa', ['only' => ['show']]);
        $this->middleware('permission:Ventas - editar ubicacion empresa', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar ubicacion empresa', ['only' => ['destroy']]);
        $this->saleBusinessLocation = $saleBusinessLocation;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query("list")) {
            $value = $request->query("list");
            $result = $this->saleBusinessLocation->get();
            $count = $this->saleBusinessLocation->count();
            return response([
                'count' => $count,
                'data' => BusinessLocationResource::collection($result),
            ], Response::HTTP_OK);
        }
        $saleBusinessLocations = $this->saleBusinessLocation->paginate();
        return BusinessLocationResource::collection($saleBusinessLocations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessLocationRequest $request)
    {
        $saleBusinessLocation = $this->saleBusinessLocation->create($request->toArray());
        return response([
            'data' => new BusinessLocationResource($saleBusinessLocation)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SabeBusinessLocation  $sabeBusinessLocation
     * @return \Illuminate\Http\Response
     */
    public function show(SaleBusinessLocation $businessLocation)
    {
        return new BusinessLocationResource($businessLocation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SabeBusinessLocation  $sabeBusinessLocation
     * @return \Illuminate\Http\Response
     */
    public function update(BusinessLocationRequest $request, SaleBusinessLocation $businessLocation)
    {
        $businessLocation->update($request->all());
        return response([
            'data' => new BusinessLocationResource($businessLocation)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SabeBusinessLocation  $sabeBusinessLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleBusinessLocation $businessLocation)
    {
        $businessLocation->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
