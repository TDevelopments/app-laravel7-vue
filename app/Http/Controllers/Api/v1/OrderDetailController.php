<?php

namespace App\Http\Controllers\Api\v1;

use File;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductRange;
use App\Models\Order;
use App\Models\Range;
use App\Models\SaleCustomer;
use App\Models\SaleProduct;
use App\Models\SaleStockRecord;
use App\Models\SaleProductStatus;
use App\Models\SalePicture;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDetailResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderDetailController extends Controller
{
    
    protected $orderDetail;
    protected $product;
    protected $productRange;
    protected $range;
    protected $saleCustomer;
    protected $saleProduct;
    protected $saleStockRecord;
    protected $saleProductStatus;

    public function __construct(OrderDetail $orderDetail, Product $product, 
      ProductRange $productRange, Range $range, SaleCustomer $saleCustomer, SaleProduct $saleProduct, SaleStockRecord $saleStockRecord, SaleProductStatus $saleProductStatus)
    {
        $this->middleware('api.admin');
        $this->orderDetail = $orderDetail;
        $this->product = $product;
        $this->productRange = $productRange;
        $this->range = $range;
        $this->saleCustomer = $saleCustomer;
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
    public function store(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'products.*.product_id' => ['required', 'integer', 'exists:App\Models\Product,id'],
            'products.*.quantity' => ['required', 'integer'],
            'product_ranges.*.product_id' => ['required', 'integer', 'exists:App\Models\ProductRange,id'],
            'product_ranges.*.quantity' => ['required', 'integer'],
            'product_ranges.*.meta' => ['required', 'array'],
            'product_ranges.*.meta.*.quantity' => ['required', 'integer'],
            'product_ranges.*.meta.*.color' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $data = $request->products;
        $data2 = $request->product_ranges;
        $products = array();
        if (empty($order->sale_customer_id)) 
        {
            $saleCustomer = $this->saleCustomer->firstOrCreate(['user_id' => $order->user_id],
                [
                   'FullName' => $order->user->name,
                   'Phone' => $order->user->phone,
                   'Email' => $order->user->email,
                   'Dni' => $order->user->dni
                ]);
            $order->update(['sale_customer_id' => $saleCustomer->id]);
        }
        if($request->products)
        {
            foreach($data as $row)
            {
                if((int)$row['quantity'] == 0)
                {
                    $productReference = $this->product->find($row['product_id']);
                    $consult = $this->orderDetail->where('order_id', '=', $order->id)->where('sku', '=', "$productReference->sku")->first();
                    if(!is_null($consult))
                    {
                        // if (!empty($consult->sale_stock_record_id))
                        //     $this->saleStockRecord->destroy($consult->sale_stock_record_id);
                        $consult->delete();
                        continue;
                    }
                    continue;
                }
                else
                {
                    $productReference = $this->product->find($row['product_id']);
                    if (empty($productReference))
                        continue;
                    else
                    {
                        $orderDetail = $this->orderDetail->updateOrCreate(
                            [
                                'product_id' => $row['product_id'],
                                'order_id' => $order->id,
                            ],
                            [
                                'quantity' => $row['quantity'],
                                'price' => $productReference->price_unit,
                                'model' => $productReference->model,
                                'sku' => $productReference->sku,
                                'total' => $productReference->price_unit * $row['quantity'],
                                'meta' => array("none"),
                            ]);
                        if (!$orderDetail->saleStockRecord()->exists())
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
                            $saleProductStatus = $this->saleProductStatus->firstOrCreate(['StatusName' => 'Reservado']);
                            $saleStockRecord = $this->saleStockRecord->create([
                                'order_detail_id' => $orderDetail->id,
                                'sale_product_id' => $saleProduct->id,
                                'sale_product_status_id' => $saleProductStatus->id,
                                'sale_business_location_id' => 1,
                                'sale_customer_id' => $order->sale_customer_id,
                                'Quantity' => $row['quantity']]);
                            // $orderDetail->update(['sale_stock_record_id' => $saleStockRecord->id]);
                        }
                        else
                        {
                            // $this->saleStockRecord->find($orderDetail->sale_stock_record_id)->update(['Quantity' => $row['quantity']]);
                            if (empty($orderDetail->saleStockRecord->sale_customer_id)) 
                                $orderDetail->saleStockRecord->update(['sale_customer_id' => $order->sale_customer_id]);
                            $orderDetail->saleStockRecord->update(['Quantity' => $row['quantity']]);
                        }
                    }
                }
            }
        }
        if($request->product_ranges)
        {
            foreach($data2 as $row)
            {
                if((int)$row['quantity'] == 0)
                {
                    $productRangeReference = $this->productRange->find($row['product_id']);
                    $consult = $this->orderDetail->where('order_id', '=', $order->id)->where('sku', '=', "$productRangeReference->sku")->first();
                    if(!is_null($consult))
                    {
                        // if (!empty($consult->sale_stock_record_id))
                        //     $this->saleStockRecord->destroy($consult->sale_stock_record_id);
                        $consult->delete();
                        continue;
                    }
                    continue;
                }
                else
                {
                    $productRangeReference = $this->productRange->find($row['product_id']);
                    $rangeReference = $this->range->where('product_range_id', $productRangeReference->id)
                                                  ->where('max', '>=', $row['quantity'])->first();
                    if(!isset($rangeReference))
                    {
                        continue;
                    }
                    $orderDetail = $this->orderDetail->updateOrCreate(
                        [
                            'product_range_id' => $productRangeReference->id,
                            'order_id' => $order->id,
                        ],[
                            'model' => $productRangeReference->model,
                            'sku' => $productRangeReference->sku,
                            'price' => $rangeReference->price,
                            'quantity' => $row['quantity'],
                            'total' => $rangeReference->price * $row['quantity'],
                            'meta' => $row['meta'],
                        ]);
                    if (empty($orderDetail->saleStockRecord))
                    {
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
                        $saleProductStatus = $this->saleProductStatus->firstOrCreate(['StatusName' => 'Reservado']);
                        $saleStockRecord = $this->saleStockRecord->create([
                            'order_detail_id' => $orderDetail->id,
                            'sale_product_id' => $saleProduct->id,
                            'sale_product_status_id' => $saleProductStatus->id,
                            'sale_business_location_id' => 1,
                            'sale_customer_id' => $order->sale_customer_id,
                            'Quantity' => $row['quantity']]);
                        // $orderDetail->update(['sale_stock_record_id' => $saleStockRecord->id]);
                    }
                    else
                    {
                        // $this->saleStockRecord->find($orderDetail->sale_stock_record_id)->update(['Quantity' => $row['quantity']]);
                            $orderDetail->saleStockRecord->update(['Quantity' => $row['quantity']]);
                    }
                    /* $productRangeReference->increment('count', $row['quantity']); */
                }
            }
        }
        return OrderDetailResource::collection($order->orderDetails);
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

    public function randomId() {
        $sku = strtoupper(Str::random(10));
        $validator = Validator::make(['Sku'=>$sku],['Sku'=>'unique:sale_products,Sku']);
        if($validator->fails()){
            return $this->randomId();
        }
        return $sku;
    }
}
