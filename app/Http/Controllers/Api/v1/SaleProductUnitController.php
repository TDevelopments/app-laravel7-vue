<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleProductUnit;
use Illuminate\Http\Request;
use App\Http\Requests\SaleProductUnitRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class SaleProductUnitController extends Controller
{
    protected $saleProductUnit;

    /**
     * Constructor
     *
     * @param \App\Models\SaleCategory $saleCategory
     */
    public function __construct(SaleProductUnit $saleProductUnit)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Ventas - listar unidades de producto', ['only' => ['index']]);
        $this->middleware('permission:Ventas - crear unidad de producto', ['only' => ['store']]);
        $this->middleware('permission:Ventas - mostrar unidad de producto', ['only' => ['show']]);
        $this->middleware('permission:Ventas - editar unidad de producto', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar unidad de producto', ['only' => ['destroy']]);
        $this->saleProductUnit = $saleProductUnit;
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
            $result = $this->saleProductUnit->get();
            $count = $this->saleProductUnit->count();
            return response([
                'count' => $count,
                'data' => $result
            ], Response::HTTP_OK);
        }
        $saleProductUnit = $this->saleProductUnit->paginate();
        return response($saleProductUnit, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleProductUnitRequest $request)
    {
        $saleProductUnit = $this->saleProductUnit->updateOrCreate($request->toArray());
        History::create([
            'action' => 'Ventas - Creando unidad de producto',
            'model_type' => 'App\Models\SaleProductUnit',
            'model_id' => $saleProductUnit->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response([
            'data' => $saleProductUnit
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleProductUnit  $saleProductUnit
     * @return \Illuminate\Http\Response
     */
    public function show(SaleProductUnit $saleUnit)
    {
        return response([
            'data' => $saleUnit
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleProductUnit  $saleProductUnit
     * @return \Illuminate\Http\Response
     */
    public function update(SaleProductUnitRequest $request, SaleProductUnit $saleUnit)
    {
        History::create([
            'action' => 'Ventas - Actualizando unidad de producto',
            'model_type' => 'App\Models\SaleProductUnit',
            'model_id' => $saleUnit->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleUnit->update($request->all());
        return response([
            'data' => $saleUnit
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleProductUnit  $saleProductUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleProductUnit $saleUnit, Request $request)
    {
        History::create([
            'action' => 'Ventas - Eliminando unidad de producto',
            'model_type' => 'App\Models\SaleProductUnit',
            'model_id' => $saleUnit->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleUnit->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
