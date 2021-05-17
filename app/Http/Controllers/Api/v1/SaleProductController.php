<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleProduct;
use App\Models\SalePicture;
use App\Models\SaleStockRecord;
use Illuminate\Http\Request;
use App\Http\Requests\SaleProductRequest;
use App\Http\Requests\UpdateSaleProductRequest;
use App\Http\Resources\SaleProductResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SaleProductController extends Controller
{
    protected $saleProduct;

    /**
     * Constructor
     *
     * @param \App\Models\SaleProduct $saleProduct
     */
    public function __construct(SaleProduct $saleProduct)
    {
        $this->middleware('api.admin')->except(['index', 'show']);
        $this->saleProduct = $saleProduct;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query("list")) {
            $value = $request->query("list");
            $result = $this->saleProduct->select('id', 'ProductName')->get();
            return response([
                'data' => $result
            ], Response::HTTP_OK);
        }
        if ($request->query("ProductName")) {
            $value = $request->query("ProductName");
            $result = $this->saleProduct->where('ProductName', 'like', "%$value%")->get();
            return response([
                'data' => $result,
            ], Response::HTTP_OK);
        }
        if ($request->query("ProductAvailable")) 
        {
            $value = $request->query("ProductAvailable");
            switch ($value2) {
                case "true":
                    $products = $this->product->where('ProductAvailable', 1)
                                            ->orderBy('ProductName')->paginate()->withQueryString();
                    return SaleProductResource::collection($products);
                    break;
                case "false":
                    $products = $this->product->where('ProductAvailable', 0)
                                            ->orderBy('ProductName')->paginate()->withQueryString();
                    return SaleProductResource::collection($products);
                    break;
            }
        }
        $saleProducts = $this->saleProduct->paginate();
        return SaleProductResource::collection($saleProducts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleProductRequest $request)
    {
        $this->handle($request);
        $request->merge(['Sku' => $this->randomId()]);
        $saleProduct = $this->saleProduct->create($request->toArray());
        if ($request->has('Image')) {
            foreach($request->file('Image') as $file)
            {
                $name = Str::uuid() . "." . $file->getClientOriginalExtension();
                $file->move(public_path().'/uploads/salesModule/', $name);
                $picture = new SalePicture();
                $picture->PictureName = $name;
                $picture->PicturePath = '/uploads/salesModule/'.$name;
                $picture->save();
                $saleProduct->SalePictures()->attach($picture);
            }
        }
        if ($request->has('stock'))
        {
            foreach($request->input('stock') as $stock)
            {
                $stockRecord = new SaleStockRecord();
                $stockRecord->sale_product_id = $saleProduct->id;
                $stockRecord->Quantity = $stock['Quantity'];
                $stockRecord->sale_product_status_id = $stock['sale_product_status_id'];
                $stockRecord->sale_business_location_id = $stock['sale_business_location_id'];
                $stockRecord->save();
            }
        }
        return response([
            'data' => new SaleProductResource($saleProduct)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleProduct  $saleProduct
     * @return \Illuminate\Http\Response
     */
    public function show(SaleProduct $saleProduct)
    {
        return new SaleProductResource($saleProduct);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleProduct  $saleProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSaleProductRequest $request, SaleProduct $saleProduct)
    {
        $this->handle($request);
        $saleProduct->update($request->all());
        if ($request->has('Image')) {
            foreach($request->file('Image') as $file)
            {
                $name = Str::uuid() . "." . $file->getClientOriginalExtension();
                $file->move(public_path().'/uploads/salesModule/', $name);
                $picture = new SalePicture();
                $picture->PictureName = $name;
                $picture->PicturePath = '/uploads/salesModule/'.$name;
                $picture->save();
                $saleProduct->SalePictures()->attach($picture);
            }
        }
        return response([
            'data' => new SaleProductResource($saleProduct)
        ],Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleProduct  $saleProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleProduct $saleProduct)
    {
        $saleProduct->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }

    public function randomId() {
        $sku = strtoupper(Str::random(10));
        $validator = Validator::make(['Sku'=>$sku],['Sku'=>'unique:sale_products,Sku']);
        if($validator->fails()){
            return $this->randomId();
        }
        return $sku;
    }

    public function handle(Request $request)
    {
        unset($request['Sku']);
        unset($request['Slug']);
        return $request;
    }
}
