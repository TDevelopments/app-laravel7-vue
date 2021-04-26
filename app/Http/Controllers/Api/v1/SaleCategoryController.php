<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleCategory;
use Illuminate\Http\Request;
use App\Http\Requests\SaleCategoryRequest;
use App\Http\Resources\SaleCategoryResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

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
        $this->middleware('api.admin')->except(['index', 'show']);
        $this->saleCategory = $saleCategory;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
        return response([
            'data' => new SaleCategoryResource($saleCategory)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleCategory  $saleCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleCategory $saleCategory)
    {
        $saleCategory->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
