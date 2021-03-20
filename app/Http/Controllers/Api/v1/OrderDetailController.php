<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDetailResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderDetailController extends Controller
{
    
    protected $orderDetail;
    protected $product;

    public function __construct(OrderDetail $orderDetail, Product $product)
    {
        $this->orderDetail = $orderDetail;
        $this->product = $product;
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
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $data = $request->products;
        $products = array();
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
            'products' => ['required', 'array'],
            'products.*' => ['required', 'integer','exists:App\Models\Product,id'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $this->orderDetail->destroy($request->products);
        return response()->json(['success' => 'Order Detail Delete successfully.']);
    }
}
