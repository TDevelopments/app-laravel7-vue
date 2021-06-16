<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleProductType;
use Illuminate\Http\Request;
use App\Http\Requests\SaleProductTypeRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class SaleProductTypeController extends Controller
{
    protected $saleProductType;

    /**
     * Constructor
     *
     * @param \App\Models\SaleCategory $saleCategory
     */
    public function __construct(SaleProductType $saleProductType)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Ventas - listar tipos de producto', ['only' => ['index']]);
        $this->middleware('permission:Ventas - crear tipo de producto', ['only' => ['store']]);
        $this->middleware('permission:Ventas - mostrar tipo de producto', ['only' => ['show']]);
        $this->middleware('permission:Ventas - editar tipo de producto', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar tipo de producto', ['only' => ['destroy']]);
        $this->saleProductType = $saleProductType;
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
            $result = $this->saleProductType->get();
            $count = $this->saleProductType->count();
            return response([
                'count' => $count,
                'data' => $result
            ], Response::HTTP_OK);
        }
        $saleProductTypes = $this->saleProductType->paginate();
        return response($saleProductTypes, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $saleProductType = $this->saleProductType->updateOrCreate($request->toArray());
        History::create([
            'action' => 'Ventas - Creando tipo de producto',
            'model_type' => 'App\Models\SaleProductType',
            'model_id' => $saleProductType->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response([
            'data' => $saleProductType
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleProductType  $saleProductType
     * @return \Illuminate\Http\Response
     */
    public function show(SaleProductType $saleProductType)
    {
        return response([
            'data' => $saleProductType
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleProductType  $saleProductType
     * @return \Illuminate\Http\Response
     */
    public function update(SaleProductTypeRequest $request, SaleProductType $saleProductType)
    {
        History::create([
            'action' => 'Ventas - Actualizando tipo de producto',
            'model_type' => 'App\Models\SaleProductType',
            'model_id' => $saleProductType->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleProductType->update($request->all());
        return response([
            'data' => $saleProductType
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleProductType  $saleProductType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleProductType $saleProductType, Request $request)
    {
        History::create([
            'action' => 'Ventas - Eliminando tipo de producto',
            'model_type' => 'App\Models\SaleProductType',
            'model_id' => $saleProductType->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleProductType->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
