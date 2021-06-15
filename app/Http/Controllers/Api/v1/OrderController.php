<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductRange;
use App\Models\Range;
use App\Models\User;
use App\Models\SaleCustomer;
use App\Models\SaleProduct;
use App\Models\SaleStockRecord;
use App\Models\SaleProductStatus;
use App\Models\SalePicture;
use App\Models\StateOrder;
use App\Models\Catalogue;
use App\Models\OrderShippingStatus;
use App\Models\SaleBusinessLocation;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResourceAdmin;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Str;
use File;

class OrderController extends Controller
{

    protected $order;
    protected $payment;
    protected $product;
    protected $productRange;
    protected $orderDetail;
    protected $range;
    protected $stateOrder;
    protected $saleCustomer;
    protected $saleProduct;
    protected $saleStockRecord;
    protected $saleProductStatus;
    protected $saleBusinessLocation;

    public function __construct(
        Order $order, Catalogue $catalogue, Product $product, OrderDetail $orderDetail, 
        ProductRange $productRange, Range $range, StateOrder $stateOrder, SaleCustomer $saleCustomer, 
        SaleProduct $saleProduct, SaleStockRecord $saleStockRecord, SaleProductStatus $saleProductStatus, 
        OrderShippingStatus $shippingStatus, SaleBusinessLocation $saleBusinessLocation)
    {
        $this->middleware('api.admin')->except(['store']);
        $this->middleware('permission:Importaciones - listar ordenes', ['only' => ['index']]);
        $this->middleware('permission:Importaciones - crear orden', ['only' => ['store']]);
        $this->middleware('permission:Importaciones - mostrar orden', ['only' => ['show']]);
        $this->middleware('permission:Importaciones - editar orden', ['only' => ['update']]);
        $this->middleware('permission:Importaciones - eliminar orden', ['only' => ['destroy']]);
        $this->order = $order;
        $this->catalogue = $catalogue;
        $this->product = $product;
        $this->productRange = $productRange;
        $this->orderDetail = $orderDetail;
        $this->range = $range;
        $this->stateOrder = $stateOrder;
        $this->saleCustomer = $saleCustomer;
        $this->saleProduct = $saleProduct;
        $this->saleStockRecord = $saleStockRecord;
        $this->saleProductStatus = $saleProductStatus;
        $this->shippingStatus = $shippingStatus;
        $this->saleBusinessLocation = $saleBusinessLocation;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query("orderId") || $request->query("username") || $request->query("stateOrder") || $request->query("catalogueId"))
        {
            $value1 = $request->query("orderId");
            $value2 = $request->query("username");
            $value3 = $request->query("stateOrder");
            $value4 = $request->query("catalogueId");
            $query = $this->order->where('id', '>', 0);
            if($request->query("orderId"))
            {
                $query->where('id', 'like', "$value1");
            }
            if($request->query("stateOrder"))
            {
                $query->where('state_order_id', "$value3");
            }
            if($request->query("catalogueId"))
            {
                $query->where('catalogue_id', "$value4");
            }
            if($request->query("username"))
            {
                $userReference = User::firstWhere("name", "like", "%$value2%");
                if (!empty($productReference))
                    $query->where("user_id", $userReference->id);
            }
            return OrderResourceAdmin::collection($query->orderBy('created_at', 'desc')->paginate()->withQueryString());
        }
        return OrderResourceAdmin::collection($this->order->orderBy('created_at', 'desc')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => ['integer', 'exists:App\Models\SaleCustomer,id'],
            'sale_product_status' => ['boolean'],
            'catalogue_id' => ['required', 'exists:App\Models\Catalogue,id'],
            'sale_business_location_id' => ['exists:App\Models\SaleBusinessLocation,id'],
            'products' => ['array'],
            'products.*.product_id' => ['required', 'integer', 'exists:App\Models\Product,id'],
            'products.*.quantity' => ['required', 'integer'],
            'product_ranges' => ['array'],
            'product_ranges.*.product_id' => ['required', 'integer', 'exists:App\Models\ProductRange,id'],
            'product_ranges.*.quantity' => ['required', 'integer'],
            'product_ranges.*.meta' => ['required', 'array'],
            'product_ranges.*.meta.*.quantity' => ['required', 'integer'],
            'product_ranges.*.meta.*.color' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $userIdentity = false;
        foreach ($request->user()->roles as $role) {
            if ($role['name'] != 'user')
                $userIdentity = true; 
        }
        $stateOrder = $this->stateOrder->firstOrCreate(['name' => 'Pendiente']);
        $saleCustomer = $this->saleCustomer->firstOrCreate(['user_id' => $request->user()->id],
            [
               'FullName' => $request->user()->name,
               'Phone' => $request->user()->phone,
               'Email' => $request->user()->email,
               'Dni' => $request->user()->dni
            ]);
        $orderShippingStatus = $this->shippingStatus->firstOrCreate(['name' => 'Pendiente']);
        $saleProductStatus = $this->saleProductStatus->firstOrCreate(['StatusName' => 'Reservado']);
        $saleProductStatusAvailable = $this->saleProductStatus->firstOrCreate(['StatusName' => 'Disponible']);
        $saleBusinessLocation = $this->saleBusinessLocation->get()->first();
        if ($userIdentity) {
            if (empty($request->customer_id))
                $requestCustomer = $saleCustomer->id;
            else
                $requestCustomer = $request->customer_id;
            if (empty($request->sale_product_status)) # if it's => 0, false, null
                $requestProductStatus = $saleProductStatus->id;
            else
                $requestProductStatus = $saleProductStatusAvailable->id;
            if (empty($request->sale_business_location_id))
                $requestBusinessLocation = $saleBusinessLocation->id;
            else
                $requestBusinessLocation = $request->sale_business_location_id;
        } else {
            $requestCustomer = $saleCustomer->id;
            $requestProductStatus = $saleProductStatus->id;
            $requestBusinessLocation = $saleBusinessLocation->id;
        }
        $order = $this->order->create([
            'user_id' => $request->user()->id,
            /* 'sale_customer_id' => $saleCustomer->id, */
            'sale_customer_id' => $requestCustomer,
            'catalogue_id' => $request->catalogue_id,
            'state_order_id' => $stateOrder->id,
            'order_shipping_status_id' => $orderShippingStatus->id,
            'sale_product_status_id' => $requestProductStatus,
            // 'state_order_id' => $request->state_order_id,
            // 'status' => 'pending',
        ]);
        $catalogueReference = $this->catalogue->find($request->catalogue_id);
        $data = $request->products;
        $data2 = $request->product_ranges;
        $products = array();
        $product_ranges = array();
        if($request->products)
        {
            foreach($data as $row)
            {
                if((int)$row['quantity'] == 0)
                    continue;
                else
                {
                    $productReference = $this->product->find($row['product_id']);
                    if (empty($productReference))
                        continue;
                    else
                    {
                        $saleProduct = $this->saleProduct->firstWhere('Model', $productReference->model);
                        if (empty($saleProduct))
                        {
                            $saleProduct = $this->saleProduct->create(
                                ['Model' => $productReference->model, 'ProductName' => $productReference->model, 'Sku' => $this->randomId()]
                            );
                            if (!empty($productReference->images))
                            {
                                foreach ($productReference->images as $image)
                                {
                                    $file = File::get(public_path($image['path']));
                                    $name = Str::uuid() . ".jpg";
                                    // $file->move(public_path().'/uploads/salesModule/', $name);
                                    File::copy(public_path($image['path']), public_path('uploads/salesModule/'.$name));
                                    $picture = new SalePicture();
                                    $picture->PictureName = $name;
                                    $picture->PicturePath = '/uploads/salesModule/'.$name;
                                    $picture->save();
                                    $saleProduct->SalePictures()->attach($picture);
                                }
                            }
                        }
                        $user = User::find($order->user_id);
                        $orderDetail = $this->orderDetail->updateOrCreate(
                            [
                                'product_id' => $row['product_id'],
                                'order_id' => $order->id,
                                'quantity' => $row['quantity'],
                                'price' => $productReference->price_unit,
                                'model' => $productReference->model,
                                'sku' => $productReference->sku,
                                'total' => $productReference->price_unit * $row['quantity'],
                                'meta' => array("none"),
                                // 'sale_stock_record_id' => $saleStockRecord->id
                            ]);
                        $saleStockRecord = $this->saleStockRecord->create([
                            'order_detail_id' => $orderDetail->id,
                            'sale_product_id' => $saleProduct->id,
                            'sale_product_status_id' => $requestProductStatus,
                            'sale_business_location_id' => $requestBusinessLocation,
                            'sale_customer_id' => $order->sale_customer_id,
                            'Quantity' => $row['quantity']]);
                    }
                }
            }
        }
        if($request->product_ranges)
        {
            foreach($data2 as $row)
            {
                $productRangeReference = $this->productRange->find($row['product_id']);
                $rangeReference = $this->range->where('product_range_id', $productRangeReference->id)
                                              ->where('max', '>=', $row['quantity'])->first();
                if(empty($rangeReference))
                {
                    continue;
                }
                $saleProduct = $this->saleProduct->firstWhere('Model', $productRangeReference->model);
                if (empty($saleProduct))
                {
                    $saleProduct = $this->saleProduct->create(
                        ['Model' => $productRangeReference->model, 'ProductName' => $productRangeReference->model, 'Sku' => $this->randomId()]
                    );
                    if (!empty($productRangeReference->images))
                    {
                        foreach ($productRangeReference->images as $image)
                        {
                            $file = File::get(public_path($image['path']));
                            $name = Str::uuid() . ".jpg";
                            // $file->move(public_path().'/uploads/salesModule/', $name);
                            File::copy(public_path($image['path']), public_path('uploads/salesModule/'.$name));
                            $picture = new SalePicture();
                            $picture->PictureName = $name;
                            $picture->PicturePath = '/uploads/salesModule/'.$name;
                            $picture->save();
                            $saleProduct->SalePictures()->attach($picture);
                        }
                    }
                }
                $orderDetail = $this->orderDetail->create([
                    'product_range_id' => $productRangeReference->id,
                    'order_id' => $order->id,
                    'quantity' => $row['quantity'],
                    'price' => $rangeReference->price,
                    'model' => $productRangeReference->model,
                    'sku' => $productRangeReference->sku,
                    'total' => $rangeReference->price * $row['quantity'],
                    'meta' => $row['meta'],
                    // 'sale_stock_record_id' => $saleStockRecord->id
                ]);
                $saleStockRecord = $this->saleStockRecord->create([
                    'order_detail_id' => $orderDetail->id,
                    'sale_product_id' => $saleProduct->id,
                    'sale_product_status_id' => $requestProductStatus,
                    'sale_business_location_id' => $requestBusinessLocation,
                    'sale_customer_id' => $order->sale_customer_id,
                    'Quantity' => $row['quantity']]);
                /* $sumQuantityMeta = 0; */
                /* foreach ($row['meta'] as $var) { */
                /*     $sumQuantityMeta = $sumQuantityMeta + $var['quantity']; */
                /* } */
                /* if ($sumQuantityMeta == $row['quantity']) { */
                /*     foreach ($row['meta'] as $variable) { */
                /*         $saleStockRecord = $this->saleStockRecord->create([ */
                /*             'order_detail_id' => $orderDetail->id, */
                /*             'sale_product_id' => $saleProduct->id, */
                /*             'sale_product_status_id' => $requestProductStatus, */
                /*             'sale_business_location_id' => $requestBusinessLocation, */
                /*             'sale_customer_id' => $order->sale_customer_id, */
                /*             'Quantity' => $variable['quantity'], */
                /*             'Color' => $variable['color'], */
                /*         ]); */
                /*     } */
                /* } else { */
                /*     $saleStockRecord = $this->saleStockRecord->create([ */
                /*         'order_detail_id' => $orderDetail->id, */
                /*         'sale_product_id' => $saleProduct->id, */
                /*         'sale_product_status_id' => $requestProductStatus, */
                /*         'sale_business_location_id' => $requestBusinessLocation, */
                /*         'sale_customer_id' => $order->sale_customer_id, */
                /*         'Quantity' => $row['quantity'] */
                /*     ]); */
                /* } */
                /* $productRangeReference->increment('count', $row['quantity']); */
            }
        }
        return new OrderResourceAdmin($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResourceAdmin($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'state_order_id' => ['required', 'integer', 'exists:App\Models\StateOrder,id'],
            'sale_product_status' => ['boolean'],
            'order_shipping_status_id' => ['required', 'integer', 'exists:App\Models\OrderShippingStatus,id'],
            'sale_business_location_id' => ['exists:App\Models\SaleBusinessLocation,id'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $saleProductStatus = $this->saleProductStatus->firstOrCreate(['StatusName' => 'Reservado']);
        $saleProductStatusAvailable = $this->saleProductStatus->firstOrCreate(['StatusName' => 'Disponible']);
        if (empty($order->sale_product_status_id)) {
            $order->update(['sale_product_status_id' => $saleProductStatus->id]);
        }
        if ($request->has('sale_product_status')) {
            if (empty($request->sale_product_status)) {
                $requestProductStatus = $saleProductStatus->id;
            } else {
                $requestProductStatus = $saleProductStatusAvailable->id;
            }
        } else {
            $requestProductStatus = $order->sale_product_status_id;
        }
        $order->update([
            'state_order_id' => $request->state_order_id,
            'order_shipping_status_id' => $request->order_shipping_status_id,
            'sale_product_status_id' => $requestProductStatus,
        ]);
        if (!empty($order->orderDetails()->exists())) {
            foreach ($order->orderDetails as $orderDetail) {
                $orderDetail->saleStockRecord->update(['sale_product_status_id' => $requestProductStatus]);
            }
        }
        return new OrderResourceAdmin($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
      /* $ordersDetails = $this->orderDetail->where('order_id', $order->id)->get(); */
      /* foreach($ordersDetails as $orderDetail) */
      /* { */
      /*     if (is_null($orderDetail->product_id)) */
      /*         $this->productRange->find($orderDetail->product_range_id)->decrement('count', (int)$orderDetail->quantity); */
      /*     else */
      /*         $this->product->find($orderDetail->product_id)->decrement('count', (int)$orderDetail->quantity); */
      /* } */
      $order->delete();
      return response()->json(null, 204);
    }

    public function randomId() {
        $sku = strtoupper(Str::random(10));
        $validator = Validator::make(['Sku'=>$sku],['Sku'=>'unique:sale_products,Sku']);
        if($validator->fails()){
            return $this->randomId();
        }
        return $sku;
    }
}
