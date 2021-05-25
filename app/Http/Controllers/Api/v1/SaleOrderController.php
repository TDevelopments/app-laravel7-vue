<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleOrder;
use App\Models\SaleCustomer;
use App\Models\SaleStateOrder;
use App\Models\SaleProduct;
use App\Models\SaleOrderDetails;
use App\Models\SaleStockRecord;
use App\Models\SaleProductStatus;
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

    public function __construct(SaleOrder $saleOrder, SaleCustomer $saleCustomer, SaleStateOrder $saleStateOrder, SaleProduct $saleProduct, SaleStockRecord $saleStockRecord, SaleProductStatus $saleProductStatus)
    {
        $this->middleware('api.admin')->except(['store']);
        $this->saleOrder = $saleOrder;
        $this->saleCustomer = $saleCustomer;
        $this->saleStateOrder = $saleStateOrder;
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
        if ($request->query("orderId") || $request->query("customerId") || $request->query("stateOrder"))
        {
            $value1 = $request->query("orderId");
            $value2 = $request->query("customerId");
            $value3 = $request->query("stateOrderId");
            $query = $this->saleOrder->where('id', '>', 0);
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
        return SaleOrderResourceAdmin::collection($this->saleOrder->orderBy('created_at', 'desc')->paginate());
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
                $quantityStock = $saleProductReference->SaleStockRecords->sum('Quantity');
                $quantityRequest = (int)$product['Quantity'];
                if (quantityRequest <= $quantityStock && quantityRequest > 0) {
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleOrder  $saleOrder
     * @return \Illuminate\Http\Response
     */
    public function show(SaleOrder $saleOrder)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleOrder  $saleOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleOrder $saleOrder)
    {
        //
    }
}
