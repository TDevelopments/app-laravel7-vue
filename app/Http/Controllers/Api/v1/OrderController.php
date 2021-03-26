<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductRange;
use App\Models\Range;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    protected $order;
    protected $payment;
    protected $product;
    protected $productRange;
    protected $orderDetail;
    protected $range;

    public function __construct(Order $order, Catalogue $catalogue, Product $product, OrderDetail $orderDetail, ProductRange $productRange, Range $range)
    {
        $this->middleware('api.admin')->except(['store']);
        $this->order = $order;
        $this->catalogue = $catalogue;
        $this->product = $product;
        $this->productRange = $productRange;
        $this->orderDetail = $orderDetail;
        $this->range = $range;
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
            return OrderResource::collection($this->order->find($value)->get());
        }
        if ($request->query("username"))
        {
            $value = $request->query("username");
            
        }
        return OrderResource::collection($this->order->paginate());
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
                'products.*.product_id' => ['required', 'integer', 'exists:App\Models\Product,id'],
                'products.*.quantity' => ['required', 'integer'],
                'product_ranges' => ['array'],
                'product_ranges.*.product_id' => ['required', 'integer', 'exists:App\Models\ProductRange,id'],
                'product_ranges.*.quantity' => ['required', 'integer']
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $order = $this->order->create([
            'user_id' => $request->user()->id,
            'catalogue_id' => $request->catalogue_id,
            'status' => 'pending',
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
                $productReference = $this->product->find($row['product_id']);
                $products[] = $this->orderDetail->updateOrCreate(
                    [
                        'product_id' => $row['product_id'],
                        'order_id' => $order->id,
                        'quantity' => $row['quantity'],
                        'price' => $productReference->price_unit,
                        'model' => $productReference->model,
                        'sku' => $productReference->sku,
                        'total' => $productReference->price_unit * $row['quantity']
                    ]);
                $productReference->increment('count', $row['quantity']);
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
                        'total' => $rangeReference->price * $row['quantity']
                    ]);
                $productRangeReference->increment('count', $row['quantity']);
            }
        }
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
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
            'status' => ['in:pending,paid,cancelled,separated,first_payment'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $order->update([ 'status' => $request->status ]);
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
