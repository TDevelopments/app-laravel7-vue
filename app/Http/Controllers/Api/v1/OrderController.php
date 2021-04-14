<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductRange;
use App\Models\Range;
use App\Models\User;
use App\Models\StateOrder;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResourceAdmin;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{

    protected $order;
    protected $payment;
    protected $product;
    protected $productRange;
    protected $orderDetail;
    protected $range;
    protected $stateOrder;

    public function __construct(
        Order $order, Catalogue $catalogue, Product $product, OrderDetail $orderDetail, 
        ProductRange $productRange, Range $range, StateOrder $stateOrder)
    {
        $this->middleware('api.admin')->except(['store']);
        $this->order = $order;
        $this->catalogue = $catalogue;
        $this->product = $product;
        $this->productRange = $productRange;
        $this->orderDetail = $orderDetail;
        $this->range = $range;
        $this->stateOrder = $stateOrder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query("orderId")) {
            $value = $request->query("orderId");
            $order = $this->order->where('id', 'like', "%$value%")->paginate()->withQueryString();
            return OrderResourceAdmin::collection($order);
        }
        if ($request->query("username"))
        {
            $value2 = $request->query("username");
            $user = User::where('name', 'like', "%$value2%")->get();
            if (count($user) == 0)
                return response()->json(['message' => "There is no user with that name"]);
            $order = $this->order->join('users', function($join) use($value2){
                $join->on('orders.user_id', '=', 'users.id')
                ->where('users.name', 'like', "%$value2%");
            })->paginate()->withQueryString();
            return OrderResourceAdmin::collection($order);
            
        }
        if ($request->query("stateOrder"))
        {
            $value3 = $request->query("stateOrder");
            $consult = $this->stateOrder->find($value3)->get();
            $stateOrder = $this->stateOrder->find($value3)->first();
            // return response()->json(["stado" => $stateOrder, "true" => !empty($stateOrder)]);
            if (count($consult) == 0)
                return response()->json(['message' => "There is no state order with that name"]);
            $order = $this->order->where('state_order_id', $stateOrder->id)->paginate();
            return OrderResourceAdmin::collection($order);
        }
        if ($request->query("catalogueId")) {
            $value =  $request->query("catalogueId");
            $consult = $this->order->where('catalogue_id', "$value")->get();
            return OrderResourceAdmin::collection($consult);
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
        // $order = $this->order->create($request->all());
        $validator = Validator::make($request->all(), [
            'catalogue_id' => ['required', 'exists:App\Models\Catalogue,id'],
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
        $stateOrder = $this->stateOrder->firstOrCreate(['name' => 'Pendiente']);
        $order = $this->order->create([
            'user_id' => $request->user()->id,
            'catalogue_id' => $request->catalogue_id,
            'state_order_id' => $stateOrder->id,
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
                    $products[] = $this->orderDetail->updateOrCreate(
                        [
                            'product_id' => $row['product_id'],
                            'order_id' => $order->id,
                            'quantity' => $row['quantity'],
                            'price' => $productReference->price_unit,
                            'model' => $productReference->model,
                            'sku' => $productReference->sku,
                            'total' => $productReference->price_unit * $row['quantity'],
                            'meta' => array("none")
                        ]);
                    /* $productReference->increment('count', $row['quantity']); */
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
                if(!isset($rangeReference))
                {
                    continue;
                }
                $product_ranges[] = $this->orderDetail->create(
                    [
                        'product_range_id' => $productRangeReference->id,
                        'order_id' => $order->id,
                        'quantity' => $row['quantity'],
                        'price' => $rangeReference->price,
                        'model' => $productRangeReference->model,
                        'sku' => $productRangeReference->sku,
                        'total' => $rangeReference->price * $row['quantity'],
                        'meta' => $row['meta'],
                    ]);
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
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $order->update(['state_order_id' => $request->state_order_id]);
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
}
