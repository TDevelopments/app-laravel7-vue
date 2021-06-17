<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleOrderDetail;
use App\Models\SaleOrder;
use App\Models\SaleProduct;
use App\Models\SaleStockRecord;
use App\Models\SalePayment;
use App\Models\SalePaymentMethod;
use App\Models\SalePaymentStatus;
use App\Models\SaleProductStatus;
use Illuminate\Http\Request;
use App\Http\Requests\SaleOrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleOrderResourceAdmin;
use App\Models\History;
use Carbon\Carbon;

class SaleOrderDetailController extends Controller
{

    protected $saleOrderDetail;
    protected $saleOrder;
    protected $saleProduct;
    protected $salePayment;
    protected $saleStockRecord;
    protected $saleProductStatus;
    protected $salePaymentMethod;
    protected $salePaymentStatus;

    public function __construct(SaleOrderDetail $saleOrderDetail, SaleOrder $saleOrder, SaleProduct $saleProduct, SaleStockRecord $saleStockRecord, SaleProductStatus $saleProductStatus, SalePaymentMethod $salePaymentMethod, SalePaymentStatus $salePaymentStatus, SalePayment $salePayment)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Ventas - crear y actualizar detalles de orden', ['only' => ['store']]);
        $this->middleware('permission:Ventas - eliminar detalles de orden', ['only' => ['destroy']]);
        $this->saleOrderDetail = $saleOrderDetail;
        $this->saleOrder = $saleOrder;
        $this->saleProduct = $saleProduct;
        $this->salePayment= $salePayment;
        $this->saleStockRecord = $saleStockRecord;
        $this->saleProductStatus = $saleProductStatus;
        $this->salePaymentMethod = $salePaymentMethod;
        $this->salePaymentStatus = $salePaymentStatus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleOrderRequest $request, SaleOrder $saleOrder)
    {
        if ($saleOrder->SalePayment) {
            $verify = true;
        } else {
            $verify = false;
        }
        $productStatus = $this->saleProductStatus->firstWhere('StatusName', 'Disponible');
        if ($request->Products) {
            foreach ($request->Products as $product) {
                $saleProductReference = $this->saleProduct->find($product['ProductId']);
                if (empty($saleProductReference->UnitPrice) || empty($saleProductReference->SellingPrice) || empty($saleProductReference->ProductAvailable)) {
                    return response(['message' => 'El producto debe contener un precio y estar habilitado.'], Response::HTTP_NOT_FOUND);
                }
            }
            foreach ($request->Products as $product) {
                $saleProductReference = $this->saleProduct->find($product['ProductId']);
                $quantityStock = $this->saleStockRecord->where('sale_product_status_id', $productStatus->id)
                        ->where('sale_product_id', $saleProductReference->id)->sum('Quantity');
                $quantityRequest = (int)$product['Quantity'];
                $saleOrderDetailReference = $this->saleOrderDetail->firstWhere([
                    ['sale_order_id', $saleOrder->id],
                    ['sale_product_id', $saleProductReference->id]
                ]);
                if ($quantityRequest > 0) {
                    if (empty($saleOrderDetailReference)) {
                        $saleOrderDetail = $this->saleOrderDetail->create([
                            'sale_order_id' => $saleOrder->id,
                            'sale_product_id' => $saleProductReference->id,
                            'Price' => $saleProductReference->SellingPrice,
                            'ProductSku' => $saleProductReference->Sku,
                            'Quantity' => $quantityRequest,
                            'Total' => $saleProductReference->SellingPrice * $quantityRequest,
                        ]);
                    } else {
                        $saleOrderDetail = $saleOrderDetailReference->update([
                            'Price' => $saleProductReference->SellingPrice,
                            'ProductSku' => $saleProductReference->Sku,
                            'Quantity' => $quantityRequest,
                            'Total' => $saleProductReference->SellingPrice * $quantityRequest,
                        ]);
                        /* if ($verify) { */
                        /*     $saleStockRecords = $this->saleStockRecord->where('sale_product_status_id', $productStatus->id) */
                        /*             ->where('sale_product_id', $saleProductReference->id)->get(); */
                        /*     $quantity = (int)$refOrderDetail['Quantity']; */
                        /*     foreach( $saleStockRecords as $stockRecord ) */
                        /*     { */
                        /*         $quantityRecord = (int)$stockRecord['Quantity']; */
                        /*         if ($quantity <= $quantityRecord) */
                        /*         { */
                        /*             $stockRecord->decrement('Quantity', $quantity); */
                        /*             break; */
                        /*         } */
                        /*         else */
                        /*         { */
                        /*             $quantity = $quantity - $quantityRecord; */
                        /*             $stockRecord->decrement('Quantity', $quantityRecord); */
                        /*         } */
                        /*     } */
                        /* } */
                    }
                } else {
                    continue;
                }
            }
        }
        if ($request->Payment && $saleOrder->SaleOrderDetails->isNotEmpty()) {
            if ($verify) {
                $salePaymentMethod = $this->salePaymentMethod->find($request->Payment['PaymentMethodId']);
                $salePaymentStatus = $this->salePaymentStatus->find($request->Payment['PaymentStatusId']);
                $salePayment = $saleOrder->SalePayment->update([
                    'sale_payment_method_id' => $salePaymentMethod->id,
                    'sale_payment_status_id' => $salePaymentStatus->id,
                    'TotalAmount' => $saleOrder->SaleOrderDetails->sum('Total'),
                    'TotalPaid' => $request->Payment['TotalPaid'],
                    'SellNote' => $request->Payment['SellNote'],
                    'user_id' => $request->user()->id
                ]);
            } else {
                $salePaymentMethod = $this->salePaymentMethod->find($request->Payment['PaymentMethodId']);
                $salePaymentStatus = $this->salePaymentStatus->find($request->Payment['PaymentStatusId']);
                $salePayment = $this->salePayment->create([
                    'sale_order_id' => $saleOrder->id,
                    'sale_payment_method_id' => $salePaymentMethod->id,
                    'sale_payment_status_id' => $salePaymentStatus->id,
                    'TotalAmount' => $saleOrder->SaleOrderDetails->sum('Total'),
                    'TotalPaid' => $request->Payment['TotalPaid'],
                    'SellNote' => $request->Payment['SellNote'],
                    'user_id' => $request->user()->id
                ]);
            }
            
        }
        return new SaleOrderResourceAdmin($saleOrder);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleOrderDetail  $saleOrderDetail
     * @return \Illuminate\Http\Response
     */
    public function show(SaleOrderDetail $saleOrderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleOrderDetail  $saleOrderDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleOrderDetail $saleOrderDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleOrderDetail  $saleOrderDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleOrderDetail $saleOrderDetail)
    {
        //
        $validator = Validator::make($request->all(), [
            'order_details' => ['required', 'array'],
            'order_details.*' => ['required', 'integer','exists:App\Models\OrderDetail,id'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        /* $orderDetails = $request->order_details; */
        /* foreach($orderDetails as $orderDetail) */
        /* { */
        /*     $orderDetailReference = $this->orderDetail->find($orderDetail); */
        /*     if (is_null($orderDetailReference->product_id)) */
        /*         $this->productRange->find($orderDetailReference->product_range_id)->decrement('count', (int)$orderDetailReference->quantity); */
        /*     else */
        /*         $this->product->find($orderDetailReference->product_id)->decrement('count', (int)$orderDetailReference->quantity); */
        /* } */
        $this->orderDetail->destroy($request->order_details);
        return response()->json(['success' => 'Order Detail Delete successfully.']);
    }
}
