<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleDelivery;
use App\Models\SaleStockRecord;
use App\Models\SaleProductStatus;
use Illuminate\Http\Request;
use App\Http\Requests\SaleDeliveryRequest;
use App\Http\Resources\SaleDeliveryResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class SaleDeliveryController extends Controller
{
    protected $saleDelivery;

    public function __construct(SaleDelivery $saleDelivery, SaleStockRecord $saleStockRecord, SaleProductStatus $saleProductStatus)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Ventas - listar entregas', ['only' => ['index']]);
        $this->middleware('permission:Ventas - crear entrega', ['only' => ['store']]);
        $this->middleware('permission:Ventas - mostrar entrega', ['only' => ['show']]);
        $this->middleware('permission:Ventas - editar entrega', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar entrega', ['only' => ['destroy']]);
        $this->saleDelivery = $saleDelivery;
        $this->saleStockRecord = $saleStockRecord;
        $this->saleProductStatus = $saleProductStatus;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query("CustomerId")) {
            $value = $request->query("CustomerId");
            $result = $this->saleDelivery->where('sale_customer_id', $value)->paginate()->withQueryString();
            $count = $this->saleDelivery->where('sale_customer_id', $value)->count();
            return SaleDeliveryResource::collection($result);
            /* return response([ */
            /*     'data' => $result, */
            /*     'count' => $count */
            /* ], Response::HTTP_OK); */
        }
        $saleDeliveries = $this->saleDelivery->paginate();
        return SaleDeliveryResource::collection($saleDeliveries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleDeliveryRequest $request)
    {
        $request->merge(['user_id' => $request->user()->id]);
        $productStatus = $this->saleProductStatus->firstWhere('StatusName', 'Reservado');
        $sumQuantity = $this->saleStockRecord->where('sale_product_status_id', $productStatus->id)
                ->where('sale_product_id', $request->sale_product_id)
                ->where('sale_customer_id', $request->sale_customer_id)->sum('Quantity');
        $saleStockRecords = $this->saleStockRecord->where('sale_product_status_id', $productStatus->id)
                ->where('sale_product_id', $request->sale_product_id)
                ->where('sale_customer_id', $request->sale_customer_id)->get();
        $quantity = (int)$request->input('Quantity');
        if (!empty($sumQuantity) && $quantity <= $sumQuantity && $quantity > 0)
        {
            foreach( $saleStockRecords as $stockRecord )
            {
                $quantityRecord = (int)$stockRecord['Quantity'];
                if ($quantity <= $quantityRecord)
                {
                    $stockRecord->decrement('Quantity', $quantity);
                    break;
                }
                else
                {
                    $quantity = $quantity - $quantityRecord;
                    $stockRecord->decrement('Quantity', $quantityRecord);
                }
            }
            $saleDelivery = $this->saleDelivery->create($request->toArray());
            History::create([
                'action' => 'Ventas - Creando entrega',
                'model_type' => 'App\Models\SaleDelivery',
                'model_id' => $saleDelivery->id,
                'user_id' => $request->user()->id,
                'creation_date' => Carbon::now()
            ]);
            return response([
                'data' => new SaleDeliveryResource($saleDelivery)
            ], Response::HTTP_CREATED);
        }
        return response(null , Response::HTTP_FORBIDDEN);
    }

    /* public function create() */
    /* { */
    /*     $productStatus = $this->saleProductStatus->firstWhere('StatusName', 'Disponible'); */
    /*     $saleStockRecords = $this->saleStockRecord->where('sale_product_status_id', $productStatus->id); */
    /*     $sumStockRecords = $this->saleStockRecord->where('sale_product_status_id', $productStatus->id)->sum('Quantity'); */
    /*     $quantity = (int)$request->input('Quantity'); */
    /*     if ($sumStockRecords > 0) { */
    /*         foreach ($saleStockRecords as $stockRecord) { */
    /*             $quantityRecord = (int)$stockRecord['Quantity']; */
    /*             if ($quantity <= $quantityRecord) */
    /*             { */
    /*                 $stockRecord->decrement('Quantity', $quantity); */
    /*                 break; */
    /*             } */
    /*             else */
    /*             { */
    /*                 $quantity = $quantity - $quantityRecord; */
    /*                 $stockRecord->decrement('Quantity', $quantityRecord); */
    /*             } */
    /*         } */
    /*     } */
    /* } */

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleDelivery  $saleDelivery
     * @return \Illuminate\Http\Response
     */
    public function show(SaleDelivery $saleDelivery)
    {
        return new SaleDeliveryResource($saleDelivery);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleDelivery  $saleDelivery
     * @return \Illuminate\Http\Response
     */
    public function update(SaleDeliveryRequest $request, SaleDelivery $saleDelivery)
    {
        History::create([
            'action' => 'Ventas - Actualizando entrega',
            'model_type' => 'App\Models\SaleDelivery',
            'model_id' => $saleDelivery->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $request->merge(['user_id' => $request->user()->id]);
        $saleDelivery->update($request->all());
        return response([
            'data' => new SaleDeliveryResource($saleDelivery)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleDelivery  $saleDelivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleDelivery $saleDelivery, Request $request)
    {
        History::create([
            'action' => 'Ventas - Eliminando entrega',
            'model_type' => 'App\Models\SaleDelivery',
            'model_id' => $saleDelivery->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleDelivery->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
