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

class SaleDeliveryController extends Controller
{
    protected $saleDelivery;

    public function __construct(SaleDelivery $saleDelivery, SaleStockRecord $saleStockRecord, SaleProductStatus $saleProductStatus)
    {
        $this->middleware('api.admin');
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
            $result = $this->saleDelivery->where('sale_customer_id', $value)->get();
            $count = $this->saleDelivery->where('sale_customer_id', $value)->count();
            return response([
                'data' => $result,
                'count' => $count
            ], Response::HTTP_OK);
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
            return response([
                'data' => new SaleDeliveryResource($saleDelivery)
            ], Response::HTTP_CREATED);
        }
        return response(null , Response::HTTP_FORBIDDEN);
    }

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
    public function destroy(SaleDelivery $saleDelivery)
    {
        $saleDelivery->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
