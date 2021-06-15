<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Range;
use App\Models\ProductRange;
use App\Http\Requests\RangeRequest;
use App\Http\Resources\RangeResource;
use Illuminate\Support\Facades\Validator;

class RangeController extends Controller
{

    protected $range;
    
    public function __construct(Range $range)
    {
        $this->middleware('api.admin');
        $this->middleware('permission:Importaciones - crear y actualizar rangos producto', ['only' => ['store']]);
        $this->middleware('permission:Importaciones - eliminar rango producto', ['only' => ['store']]);
        $this->range = $range;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductRange $productRange)
    {
        $validator = Validator::make($request->all(), [
            'items.*.min' => ['required', 'integer'],
            'items.*.max' => ['required', 'integer'],
            'items.*.price' => ['required', 'numeric'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $data = $request->items;
        $ranges = array();
        foreach($data as $row) { 
            $ranges[] = $this->range->updateOrCreate(
                [
                    'min' => $row['min'],
                    'max' => $row['max'],
                    'product_range_id' => $productRange->id
                ],['price' => $row['price']]);
        }
        return RangeResource::collection($ranges);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Range  $range
     * @return \Illuminate\Http\Response
     */
    // public function show(Range $range)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Range  $range
     * @return \Illuminate\Http\Response
     */
    // public function update(RangeRequest $request, Range $range)
    // {
    //     $range->update($request->only(['min', 'max', 'price']));
    //     return new RangeResource($range);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Range  $range
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => ['required', 'array'],
            'items.*' => ['required', 'integer','exists:App\Models\Range,id'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $this->range->destroy($request->items);
        return response()->json(['success'=>"Ranges Deleted successfully."]);
    }
}

