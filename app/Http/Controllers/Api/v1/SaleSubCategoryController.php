<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleSubCategory;
use Illuminate\Http\Request;
use App\Http\Requests\SaleSubCategoryRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class SaleSubCategoryController extends Controller
{
    protected $saleSubCategory;

    /**
     * Constructor
     *
     * @param \App\Models\SaleCategory $saleCategory
     */
    public function __construct(SaleSubCategory $saleSubCategory)
    {
        /* $this->middleware('api.admin')->except(['store']); */
        $this->middleware('permission:Ventas - listar sub-categorias', ['only' => ['index']]);
        $this->middleware('permission:Ventas - crear sub-categoria', ['only' => ['store']]);
        $this->middleware('permission:Ventas - mostrar sub-categoria', ['only' => ['show']]);
        $this->middleware('permission:Ventas - editar sub-categoria', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar sub-categoria', ['only' => ['destroy']]);
        $this->saleSubCategory = $saleSubCategory;
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
            $result = $this->saleSubCategory->get();
            $count = $this->saleSubCategory->count();
            return response([
                'count' => $count,
                'data' => $result
            ], Response::HTTP_OK);
        }
        $saleSubCategory = $this->saleSubCategory->paginate();
        return response($saleSubCategory, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleSubCategoryRequest $request)
    {
        $saleSubCategory = $this->saleSubCategory->updateOrCreate($request->toArray());
        History::create([
            'action' => 'Ventas - Creando sub-categoria',
            'model_type' => 'App\Models\SaleSubCategory',
            'model_id' => $saleSubCategory->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response([
            'data' => $saleSubCategory
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleSubCategory  $saleSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SaleSubCategory $saleSubCategory)
    {
        return response([
            'data' => $saleSubCategory
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleSubCategory  $saleSubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(SaleSubCategoryRequest $request, SaleSubCategory $saleSubCategory)
    {
        History::create([
            'action' => 'Ventas - Actualizando sub-categoria',
            'model_type' => 'App\Models\SaleSubCategory',
            'model_id' => $saleSubCategory->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleSubCategory->update($request->all());
        return response([
            'data' => $saleSubCategory
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleSubCategory  $saleSubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleSubCategory $saleSubCategory, Request $request)
    {
        History::create([
            'action' => 'Ventas - Eliminando sub-categoria',
            'model_type' => 'App\Models\SaleSubCategory',
            'model_id' => $saleSubCategory->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleSubCategory->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
