<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductRange;
use App\Models\Order;
use App\Models\Range;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDetailResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderDetailController extends Controller
{
    
    protected $orderDetail;
    protected $product;
    protected $productRange;
    protected $range;

    public function __construct(OrderDetail $orderDetail, Product $product, 
      ProductRange $productRange, Range $range)
    {
        $this->middleware('api.admin');
        $this->orderDetail = $orderDetail;
        $this->product = $product;
        $this->productRange = $productRange;
        $this->range = $range;
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
    public function store(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'products.*.product_id' => ['required', 'integer', 'exists:App\Models\Product,id'],
            'products.*.quantity' => ['required', 'integer'],
            'product_ranges.*.product_id' => ['required', 'integer', 'exists:App\Models\ProductRange,id'],
            'product_ranges.*.quantity' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $data = $request->products;
        $data2 = $request->product_ranges;
        $products = array();
        if($request->products)
        {

            foreach($data as $row)
            {
                $productReference = $this->product->find($row['product_id']);
                $products[] = $this->orderDetail->updateOrCreate(
                    [
                        'product_id' => $row['product_id'],
                        'order_id' => $order->id,
                    ],
                    [
                        'quantity' => $row['quantity'],
                        'price' => $productReference->price_unit,
                        'total' => $productReference->price_unit * $row['quantity']
                    ]);
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
                $product_ranges[] = $this->orderDetail->updateOrCreate(
                    [
                        'product_range_id' => $productRangeReference->id,
                        'order_id' => $order->id,
                    ],[
                        'price' => $rangeReference->price,
                        'quantity' => $row['quantity'],
                        'total' => $rangeReference->price * $row['quantity']
                    ]);
                $productRangeReference->increment('count', $row['quantity']);
            }
        }
        return OrderDetailResource::collection($products);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function show(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_details' => ['required', 'array'],
            'order_details.*' => ['required', 'integer','exists:App\Models\OrderDetail,id'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $this->orderDetail->destroy($request->order_details);
        return response()->json(['success' => 'Order Detail Delete successfully.']);
    }
}
