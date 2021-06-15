<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleStateOrder;
use Illuminate\Http\Request;
use App\Http\Requests\SaleStateOrderRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class SaleStateOrderController extends Controller
{

    protected $saleStateOrder;

    public function __construct(SaleStateOrder $saleStateOrder)
    {
        $this->middleware('api.admin');
        $this->middleware('permission:Ventas - listar estados de orden', ['only' => ['index']]);
        $this->middleware('permission:Ventas - crear estado de orden', ['only' => ['store']]);
        $this->middleware('permission:Ventas - mostrar estado de orden', ['only' => ['show']]);
        $this->middleware('permission:Ventas - editar estado de orden', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar estado de orden', ['only' => ['destroy']]);
        $this->saleStateOrder = $saleStateOrder;
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
            $result = $this->saleStateOrder->select('id', 'Name', 'ShortName')->get();
            $count = $this->saleStateOrder->count();
            return response([
                'count' => $count,
                'data' => $result
            ], Response::HTTP_OK);
        }
        $saleStateOrders = $this->saleStateOrder->select('id', 'Name', 'ShortName')->paginate();
        return response($saleStateOrders, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleStateOrderRequest $request)
    {
        $saleStateOrder = $this->saleStateOrder->updateOrCreate($request->toArray());
        return response([
            'data' => $saleStateOrder
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleStateOrder  $saleStateOrder
     * @return \Illuminate\Http\Response
     */
    public function show(SaleStateOrder $saleStateOrder)
    {
        return response([
            'data' => $saleStateOrder
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleStateOrder  $saleStateOrder
     * @return \Illuminate\Http\Response
     */
    public function update(SaleStateOrderRequest $request, SaleStateOrder $saleStateOrder)
    {
        $saleStateOrder->update($request->all());
        return response([
            'data' => $saleStateOrder
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleStateOrder  $saleStateOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleStateOrder $saleStateOrder)
    {
        $saleStateOrder->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
