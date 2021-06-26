<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Catalogue;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\History;
use Carbon\Carbon;

class ProductController extends Controller
{

    protected $product;

    public function __construct(Product $product)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Importaciones - listar productos', ['only' => ['index']]);
        $this->middleware('permission:Importaciones - crear producto', ['only' => ['store', 'createMassive']]);
        $this->middleware('permission:Importaciones - mostrar producto', ['only' => ['show']]);
        $this->middleware('permission:Importaciones - editar producto', ['only' => ['update']]);
        $this->middleware('permission:Importaciones - eliminar producto', ['only' => ['destroy']]);
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query("catalogue_id") || $request->query("category_id") || $request->query("measure") || $request->query("model") || $request->query("sku")) {
            $value1 = $request->query("category_id");
            $value2 = $request->query("catalogue_id");
            $value3 = $request->query("measure");
            $value4 = $request->query("model");
            $value5 = $request->query("sku");
            $query = $this->product->where('on_sale', false);
            if($request->query("catalogue_id"))
            {
                $query->where('catalogue_id', $value2);
            }
            if($request->query("category_id"))
            {
                $query->where("category_id", $value1);
            }
            if($request->query("measure"))
            {
                $query->where('type_group', $value3);
            }
            if($request->query("model") && $request->query("sku"))
            {
                $query->where('model', 'like', "%$value4%")
                        ->orWhere('sku', 'like', "%$value5%");
            }
            return ProductResource::collection($query->orderBy('model')->paginate()->withQueryString());
        }
        // if ($request->query("model")) {
        //     $value = $request->query("model");
        //     $products = $this->product->where('model', 'like', "%$value%")
        //                               ->orderBy('model')->paginate();
        //     return ProductResource::collection($products);
        // }
        // if ($request->query("sku")) {
        //     $value2 = $request->query("sku");
        //     $products = $this->product->where('sku', 'like', "%$value2%")
        //                               ->orderBy('sku')->paginate();
        //     return ProductResource::collection($products);
        // }
        if ($request->query("meta")) 
        {
            $value2 = $request->query("meta");
            switch ($value2) {
                case "true":
                  $products = $this->product->whereColumn('count', '>=', 'stock')
                                            ->orderBy('count')->paginate()->withQueryString();
                    return ProductResource::collection($products);
                    break;
                case "false":
                  $products = $this->product->whereColumn('count', '<=', 'stock')
                                            ->orderBy('count')->paginate()->withQueryString();
                    return ProductResource::collection($products);
                    break;
            }
        }
        return ProductResource::collection($this->product->orderBy('model')->paginate());
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'sku' => ['unique:products'],
        //     'model' => ['required','unique:products'],
        // ]);
        // if ($validator->fails()) {
        //     return response(['error' => $validator->errors(), 'Validation Error'], 422);
        // }
        if(!isset($request->sku)){
            $request->merge(['sku' => $this->randomId()]);
        }
        $product = $this->product->create($request->all());
        History::create([
            'action' => 'Creando Producto',
            'model_type' => 'App\Models\Product',
            'model_id' => $product->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // $validator = Validator::make($request->all(), [
        //     'sku' => ['required', 'exists:App\Models\Product,sku'],
        //     'model' => ['required','exists:App\Models\Product,model'],
        // ]);
        // if ($validator->fails()) {
        //     return response(['error' => $validator->errors(), 'Validation Error'], 422);
        // }
        History::create([
            'action' => 'Actualizando Producto',
            'model_type' => 'App\Models\Product',
            'model_id' => $product->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $product->update($request->all());
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Request $request)
    {
        History::create([
            'action' => 'Eliminando Producto',
            'model_type' => 'App\Models\Product',
            'model_id' => $product->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $product->delete();
        return response()->json(null, 204);
    }

    public function createMassive(Request $request)
    {
        $request->validate([
            'products' => ['array'],
            'products.*.name' => ['string'],
            'products.*.sku' => ['unique:products'],
            'products.*.model' => ['required', 'unique:products'],
            'products.*.magnifying' => ['integer'],
            'products.*.description' => ['array'],
            'products.*.description.*' => ['string'],
            'products.*.gender' => ['string', 'in:masculine,female,none'],
            'products.*.images' => ['array'],
            'products.*.images.*.id' => ['required', 'exists:App\Models\Image,id'],
            'products.*.images.*.name' => ['required', 'exists:App\Models\Image,name'],
            'products.*.images.*.path' => ['required', 'exists:App\Models\Image,path'],
            'products.*.colors' => ['array'],
            'products.*.stock' => ['required', 'integer'],
            'products.*.brand' => ['string'],
            'products.*.price_sale' => ['numeric'],
            'products.*.on_sale' => ['boolean'],
            'products.*.price_unit' => ['required','numeric'],
            'products.*.price_group' => ['required','numeric'],
            'products.*.quantity_group' => ['required','integer'],
            'products.*.type_group' => ['required', 'string'],
            'products.*.catalogue_id' => ['required', 'integer', 'exists:App\Models\Catalogue,id'],
            'products.*category_id' => ['required', 'integer', 'exists:App\Models\Category,id'],
        ]);
        $data = $request->products;
        $products = array();
        foreach($data as $row) {
            if(!isset($row['sku'])){
                $row['sku'] = $this->randomId();
            }
            $productState = $this->product->create($row);
            History::create([
                'action' => 'Creando Producto',
                'model_type' => 'App\Models\Product',
                'model_id' => $productState->id,
                'user_id' => $request->user()->id,
                'creation_date' => Carbon::now()
            ]);
            $products[] = $productState;
        }
        return ProductResource::collection($products);
    }

    public function randomId(){
        $sku = strtoupper(Str::random(10));
        $validator = Validator::make(['sku'=>$sku],['sku'=>'unique:products,sku']);
        if($validator->fails()){
            return $this->randomId();
        }
        return $sku;
    }
}
