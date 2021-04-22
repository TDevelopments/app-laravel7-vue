<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleProduct;
use Illuminate\Http\Request;
use App\Http\Requests\SaleProductRequest;
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
    public function update(SaleProductRequest $request, SaleProduct $saleProduct)
    {
        $this->handle($request);
        $saleProduct->update($request->all());
        return response([
            'data' => new SaleProductResource($saleProduct)
        ],Response::HTTP_CREATED);
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
        return $request;
    }
}
