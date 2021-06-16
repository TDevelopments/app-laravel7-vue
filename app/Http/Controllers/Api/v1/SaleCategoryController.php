<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleCategory;
use Illuminate\Http\Request;
use App\Http\Requests\SaleCategoryRequest;
use App\Http\Resources\SaleCategoryResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class SaleCategoryController extends Controller
{
    protected $saleCategory;

    /**
     * Constructor
     *
     * @param \App\Models\SaleCategory $saleCategory
     */
    public function __construct(SaleCategory $saleCategory)
    {
        /* $this->middleware('api.admin')->except(['index', 'show']); */
        $this->middleware('permission:Ventas - listar categorias', ['only' => ['index']]);
        $this->middleware('permission:Ventas - crear categoria', ['only' => ['store']]);
        $this->middleware('permission:Ventas - mostrar categoria', ['only' => ['show']]);
        $this->middleware('permission:Ventas - editar categoria', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar categoria', ['only' => ['destroy']]);
        $this->saleCategory = $saleCategory;
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
            $result = $this->saleCategory->get();
            $count = $this->saleCategory->count();
            return response([
                'count' => $count,
                'data' => $result
            ], Response::HTTP_OK);
        }
        $saleCategories = $this->saleCategory->paginate();
        return SaleCategoryResource::collection($saleCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleCategoryRequest $request)
    {
        $saleCategory = $this->saleCategory->updateOrCreate($request->toArray());
        History::create([
            'action' => 'Ventas - Creando categoria',
            'model_type' => 'App\Models\SaleCategory',
            'model_id' => $saleCategory->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response([
            'data' => new SaleCategoryResource($saleCategory)
        ],Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleCategory  $saleCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SaleCategory $saleCategory)
    {
        return new SaleCategoryResource($saleCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleCategory  $saleCategory
     * @return \Illuminate\Http\Response
     */
    public function update(SaleCategoryRequest $request, SaleCategory $saleCategory)
    {
        $saleCategory->update($request->all());
        History::create([
            'action' => 'Ventas - Actualizando categoria',
            'model_type' => 'App\Models\SaleCategory',
            'model_id' => $saleCategory->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response([
            'data' => new SaleCategoryResource($saleCategory)
        ],Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleCategory  $saleCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleCategory $saleCategory)
    {
        History::create([
            'action' => 'Ventas - Eliminando categoria',
            'model_type' => 'App\Models\SaleCategory',
            'model_id' => $saleCategory->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleCategory->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
