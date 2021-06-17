<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleProductStatus;
use Illuminate\Http\Request;
use App\Http\Requests\SaleProductStatusRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class SaleProductStatusController extends Controller
{
    protected $saleProductStatus;

    /**
     * Constructor
     *
     * @param \App\Models\SaleProductStatus $saleProductStatus 
     */
    public function __construct(SaleProductStatus $saleProductStatus)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Ventas - listar estados de producto', ['only' => ['index']]);
        $this->middleware('permission:Ventas - crear estado de producto', ['only' => ['store']]);
        $this->middleware('permission:Ventas - mostrar estado de producto', ['only' => ['show']]);
        $this->middleware('permission:Ventas - editar estado de producto', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar estado de producto', ['only' => ['destroy']]);
        $this->saleProductStatus = $saleProductStatus;
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
            $result = $this->saleProductStatus->get();
            $count = $this->saleProductStatus->count();
            return response([
                'count' => $count,
                'data' => $result
            ], Response::HTTP_OK);
        }
        $saleProductStatuses = $this->saleProductStatus->paginate();
        return response($saleProductStatuses, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleProductStatusRequest $request)
    {
        $saleProductStatus = $this->saleProductStatus->updateOrCreate($request->toArray());
        History::create([
            'action' => 'Ventas - Creando estado de producto',
            'model_type' => 'App\Models\SaleProductStatus',
            'model_id' => $saleProductStatus->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response([
            'data' => $saleProductStatus
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleProductStatus  $saleProductStatus
     * @return \Illuminate\Http\Response
     */
    public function show(SaleProductStatus $saleProductStatus)
    {
        return response([
            'data' => $saleProductStatus
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleProductStatus  $saleProductStatus
     * @return \Illuminate\Http\Response
     */
    public function update(SaleProductStatusRequest $request, SaleProductStatus $saleProductStatus)
    {
        History::create([
            'action' => 'Ventas - Actualizando estado de producto',
            'model_type' => 'App\Models\SaleProductStatus',
            'model_id' => $saleProductStatus->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleProductStatus->update($request->all());
        return response([
            'data' => $saleProductStatus
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleProductStatus  $saleProductStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleProductStatus $saleProductStatus, Request $request)
    {
        History::create([
            'action' => 'Ventas - Eliminando estado de producto',
            'model_type' => 'App\Models\SaleProductStatus',
            'model_id' => $saleProductStatus->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleProductStatus->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
