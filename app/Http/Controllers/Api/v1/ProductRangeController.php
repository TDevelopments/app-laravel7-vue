<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\ProductRange;
use App\Models\Range;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRangeRequest;
use App\Http\Requests\UpdateProductRangeRequest;
use App\Http\Requests\StoreProductRangeRequest;
use App\Http\Resources\ProductRangeResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\History;
use Carbon\Carbon;

class ProductRangeController extends Controller
{

    protected $product_range;

    public function __construct(ProductRange $product_range, Range $range)
    {
        /* $this->middleware('api.admin')->except(['index', 'show']); */
        $this->middleware('permission:Importaciones - listar productos con rango', ['only' => ['index']]);
        $this->middleware('permission:Importaciones - crear producto con rango', ['only' => ['store', 'createMassive']]);
        $this->middleware('permission:Importaciones - mostrar producto con rango', ['only' => ['show']]);
        $this->middleware('permission:Importaciones - editar producto con rango', ['only' => ['update']]);
        $this->middleware('permission:Importaciones - eliminar producto con rango', ['only' => ['destroy']]);
        $this->product_range = $product_range;
        $this->range = $range;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query("catalogue_id") || $request->query("category_id")) {
            $value1 = $request->query("category_id");
            $value2 = $request->query("catalogue_id");
            $query = $this->product_range->where('on_sale', false);
            if($request->query("catalogue_id"))
            {
                $query->where('catalogue_id', $value1);
            }
            if($request->query("category_id"))
            {
                $query->where("category_id", $value2);
            }
            return ProductRangeResource::collection($query->orderBy('model')->paginate()->withQueryString());
        }
        if ($request->query("model") && $request->query("sku")) {
            $value = $request->query("model");
            $value2 = $request->query("sku");
            $products = $this->product_range->where('model', 'like', "%$value%")
                                      ->orWhere('sku', 'like', "%$value2%")
                                      ->orderBy('model')->paginate()->withQueryString();
            return ProductRangeResource::collection($products);
        }
        return ProductRangeResource::collection($this->product_range->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRangeRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'sku' => ['unique:product_ranges'],
        //     'model' => ['required', 'unique:product_ranges'],
        //     'ranges' => ['array'],
        //     'ranges.*.min' => ['required', 'integer'],
        //     'ranges.*.max' => ['required', 'integer'],
        //     'ranges.*.price' => ['required', 'integer'],
        // ]);
        // if ($validator->fails()) {
        //     return response(['error' => $validator->errors(), 'Validation Error'], 422);
        // }
        if(!isset($request->sku)){
            $request->merge(['sku' => $this->randomId()]);
        }
        $product_range = $this->product_range->create($request->all());
        History::create([
            'action' => 'Creando Producto con rango',
            'model_type' => 'App\Models\ProductRange',
            'model_id' => $product_range->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $dataranges = $request->ranges;
        if($dataranges)
        {
            foreach($request->ranges as $row)
            {
                $this->range->create([
                    'product_range_id' => $product_range->id,
                    'min' => $row['min'],
                    'max' => $row['max'],
                    'price' => $row['price'],
                ]);
            }
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
    public function update(UpdateProductRangeRequest $request, ProductRange $productRange)
    {
        // $validator = Validator::make($request->all(), [
        //     'sku' => ['required', 'exists:App\Models\ProductRange,sku'],
        //     'model' => ['required','exists:App\Models\ProductRange,model'],
        // ]);
        // if ($validator->fails()) {
        //     return response(['error' => $validator->errors(), 'Validation Error'], 422);
        // }
        History::create([
            'action' => 'Actualizando Producto con rango',
            'model_type' => 'App\Models\ProductRange',
            'model_id' => $productRange->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $productRange->update($request->all());
        return new ProductRangeResource($productRange);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductRange  $productRange
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRange $productRange, Request $request)
    {
        History::create([
            'action' => 'Eliminando Producto con rango',
            'model_type' => 'App\Models\ProductRange',
            'model_id' => $productRange->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $productRange->delete();
        return response()->json(null, 204);
    }

    public function createMassive(Request $request)
    {
        $request->validate([
            'products' => ['array'],
            'products.*.name' => ['string'],
            'products.*.sku' => ['unique:product_ranges'],
            'products.*.model' => ['required', 'unique:product_ranges'],
            'products.*.description' => ['array'],
            'products.*.description.*' => ['string'],
            'products.*.images' => ['array'],
            'products.*.images.*.id' => ['required', 'exists:App\Models\Image,id'],
            'products.*.images.*.name' => ['required', 'exists:App\Models\Image,name'],
            'products.*.images.*.path' => ['required', 'exists:App\Models\Image,path'],
            'products.*.colors' => ['array'],
            'products.*.stock' => ['required', 'integer'],
            'products.*.brand' => ['string'],
            'products.*.price_sale' => ['numeric'],
            'products.*.on_sale' => ['boolean'],
            'products.*.ranges' => ['array'],
            'products.*.ranges.*.min' => ['required', 'integer'],
            'products.*.ranges.*.max' => ['required', 'integer'],
            'products.*.ranges.*.price' => ['required', 'integer'],
            'products.*.catalogue_id' => ['required', 'integer', 'exists:App\Models\Catalogue,id'],
            'products.*category_id' => ['required', 'integer', 'exists:App\Models\Category,id'],
        ]);
        $data = $request->products;
        $products = array();
        foreach($data as $row) {
            if(!isset($row['sku'])){
               $row['sku'] = $this->randomId();
            }
            $prange = $this->product_range->create($row);
            History::create([
                'action' => 'Creando Producto con rango',
                'model_type' => 'App\Models\ProductRange',
                'model_id' => $prange->id,
                'user_id' => $request->user()->id,
                'creation_date' => Carbon::now()
            ]);
            // return $row['ranges'];
            $products[] = $prange;
            foreach ($row['ranges'] as $value) {
                $this->range->create([
                    'min' => $value['min'],
                    'max' => $value['max'],
                    'price' => $value['price'],
                    'product_range_id' => $prange->id,
                ]);
            };
            
        }
        return ProductRangeResource::collection($products);
    }
    
    public function randomId(){
        $sku = strtoupper(Str::random(10));
        $validator = Validator::make(['sku'=>$sku],['sku'=>'unique:product_ranges,sku']);
        if($validator->fails()){
            return $this->randomId();
        }
        return $sku;
    }
}
