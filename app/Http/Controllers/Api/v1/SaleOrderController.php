<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleOrder;
use App\Models\SaleCustomer;
use App\Models\SaleStateOrder;
use App\Models\SaleProduct;
use App\Models\SaleOrderDetails;
use App\Models\SaleStockRecord;
use App\Models\SaleProductStatus;
use App\Models\SalePayment;
use App\Models\SalePaymentMethod;
use App\Models\SalePaymentStatus;
use App\Models\SaleOrderDetail;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\SaleOrderResourceAdmin;
use App\Http\Resources\SaleOrderResourceUser;
use App\Http\Requests\SaleOrderRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class SaleOrderController extends Controller
{

    protected $saleOrder;
    protected $saleCustomer;
    protected $saleStateOrder;
    protected $saleProduct;
    protected $saleStockRecord;
    protected $saleProductStatus;
    protected $salePaymentMethod;
    protected $salePaymentStatus;
    protected $salePayment;
    protected $saleOrderDetail;

    public function __construct(SaleOrder $saleOrder, SaleCustomer $saleCustomer, SaleStateOrder $saleStateOrder, SaleProduct $saleProduct, SaleStockRecord $saleStockRecord, SaleProductStatus $saleProductStatus, SalePaymentMethod $salePaymentMethod, SalePaymentStatus $salePaymentStatus, SalePayment $salePayment, SaleOrderDetail $saleOrderDetail)
    {
        $this->middleware('api.admin')->except(['store']);
        $this->saleOrder = $saleOrder;
        $this->saleCustomer = $saleCustomer;
        $this->saleStateOrder = $saleStateOrder;
        $this->saleProduct = $saleProduct;
        $this->saleStockRecord = $saleStockRecord;
        $this->saleProductStatus = $saleProductStatus;
        $this->salePaymentMethod = $salePaymentMethod;
        $this->salePaymentStatus = $salePaymentStatus;
        $this->salePayment = $salePayment;
        $this->saleOrderDetail = $saleOrderDetail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query("orderId") || $request->query("customerId") || $request->query("stateOrder"))
        {
            $value1 = $request->query("orderId");
            $value2 = $request->query("customerId");
            $value3 = $request->query("stateOrderId");
            $query = $this->saleOrder->where('Delete', false);
            if($request->query("orderId"))
            {
                $query->where('id', 'like', "$value1");
            }
            if($request->query("stateOrderId"))
            {
                $query->where('sale_state_order_id', "$value3");
            }
            if($request->query("customerId"))
            {
                $query->where("sale_customer_id", "$value2");
            }
            return SaleOrderResourceAdmin::collection($query->orderBy('created_at', 'desc')->paginate()->withQueryString());
        }
        return SaleOrderResourceAdmin::collection($this->saleOrder->where('Delete', false)->orderBy('created_at', 'desc')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleOrderRequest $request)
    {
        $userIdentity = false;
        foreach ($request->user()->roles as $role) {
            if ($role['name'] != 'user')
                $userIdentity = true; 
        }
        $saleCustomer = $this->saleCustomer->firstOrCreate(['user_id' => $request->user()->id],
            [
               'FullName' => $request->user()->name,
               'Phone' => $request->user()->phone,
               'Email' => $request->user()->email,
               'Dni' => $request->user()->dni
            ]);
        $saleStateOrder = $this->saleStateOrder->firstOrCreate(['name' => 'Pendiente']);
        $productStatus = $this->saleProductStatus->firstWhere('StatusName', 'Disponible');
        if ($request->Products) {
            foreach ($request->Products as $product) {
                $saleProductReference = $this->saleProduct->find($product['ProductId']);
                if (empty($saleProductReference->UnitPrice) || empty($saleProductReference->SellingPrice) || empty($saleProductReference->ProductAvailable)) {
                    return response(['message' => 'El producto debe contener un precio y estar habilitado.'], Response::HTTP_NOT_FOUND);
                }
            }
            $saleOrder = $this->saleOrder->create([
                'sale_customer_id' => $saleCustomer->id,
                'sale_state_order_id' => $saleStateOrder->id,
                'user_id' => $request->user()->id,
                'OrderDate' => Carbon::now(),
            ]);
            foreach ($request->Products as $product) {
                $saleProductReference = $this->saleProduct->find($product['ProductId']);
                $quantityStock = $this->saleStockRecord->where('sale_product_status_id', $productStatus->id)
                        ->where('sale_product_id', $saleProductReference->id)->sum('Quantity');
                $quantityRequest = (int)$product['Quantity'];
                if ($quantityRequest <= $quantityStock && $quantityRequest > 0) {
                    $saleOrderDetail = $this->saleOrderDetail->create([
                        'Price' => $saleProductReference->SellingPrice,
                        'ProductSku' => $saleProductReference->Sku,
                        'Quantity' => $quantityRequest,
                        'Total' => $saleProductReference->SellingPrice * $quantityRequest,
                        'sale_order_id' => $saleOrder->id,
                        'sale_product_id' => $saleProductReference->id,
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
     * @param  \App\SaleOrder  $saleOrder
     * @return \Illuminate\Http\Response
     */
    public function show(SaleOrder $saleOrder)
    {
        return new SaleOrderResourceAdmin($saleOrder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleOrder  $saleOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleOrder $saleOrder)
    {
        $saleOrder->update($request->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleOrder  $saleOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleOrder $saleOrder)
    {
        $saleOrder->update(['Delete' => true]);
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
