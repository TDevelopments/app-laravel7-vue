<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleOrderDetail;
use App\Models\SaleOrder;
use App\Models\SaleProduct;
use App\Models\SaleStockRecord;
use App\Models\SaleProductStatus;
use Illuminate\Http\Request;
use App\Http\Requests\SaleOrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleOrderResourceAdmin;

class SaleOrderDetailController extends Controller
{

    protected $saleOrderDetail;
    protected $saleOrder;
    protected $saleProduct;
    protected $saleStockRecord;
    protected $saleProductStatus;

    public function __construct(SaleOrderDetail $saleOrderDetail, SaleOrder $saleOrder, SaleProduct $saleProduct, SaleStockRecord $saleStockRecord, SaleProductStatus $saleProductStatus)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Ventas - crear y actualizar detalles de orden', ['only' => ['store']]);
        $this->middleware('permission:Ventas - eliminar detalles de orden', ['only' => ['destroy']]);
        $this->saleOrderDetail = $saleOrderDetail;
        $this->saleOrder = $saleOrder;
        $this->saleProduct = $saleProduct;
        $this->saleStockRecord = $saleStockRecord;
        $this->saleProductStatus = $saleProductStatus;
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
                if ($quantityRequest <= $quantityStock && $quantityRequest > 0) {
                    $saleOrderDetail = $this->saleOrderDetail->updateOrCreate(
                        [
                            'sale_order_id' => $saleOrder->id,
                            'sale_product_id' => $saleProductReference->id,
                        ],
                        [
                            'Price' => $saleProductReference->SellingPrice,
                            'ProductSku' => $saleProductReference->Sku,
                            'Quantity' => $quantityRequest,
                            'Total' => $saleProductReference->SellingPrice * $quantityRequest,
                    ]);
                } else {
                    continue;
                }
            }
        }
        if ($request->Payment && $saleOrder->SaleOrderDetails->isNotEmpty()) {
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
    }
}
