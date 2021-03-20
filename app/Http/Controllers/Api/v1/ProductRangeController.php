<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\ProductRange;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRangeRequest;
use App\Http\Resources\ProductRangeResource;
use Illuminate\Support\Facades\Validator;

class ProductRangeController extends Controller
{

    protected $product_range;

    public function __construct(ProductRange $product_range)
    {
        $this->middleware('api.admin')->except(['index', 'show']);
        $this->product_range = $product_range;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductRangeResource::collection($this->product_range->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRangeRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'model' => ['required','unique:product_ranges'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        return new ProductRangeResource($product_range);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductRange  $productRange
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRange $productRange)
    {
        return new ProductRangeResource($productRange);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductRange  $productRange
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRangeRequest $request, ProductRange $productRange)
    {
        $validator = Validator::make($request->all(), [
            'model' => ['required','exists:App\Models\ProductRange,model'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $productRange->update($request->all());
        return new ProductRangeResource($productRange);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductRange  $productRange
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRange $productRange)
    {
        $productRange->delete();
        return response()->json(null, 204);
    }
}
