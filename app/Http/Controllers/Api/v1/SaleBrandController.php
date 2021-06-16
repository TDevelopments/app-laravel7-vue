<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleBrand;
use Illuminate\Http\Request;
use App\Http\Requests\SaleBrandRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class SaleBrandController extends Controller
{
    protected $saleBrand;

    /**
     * Constructor
     *
     * @param \App\Models\SaleCategory $saleCategory
     */
    public function __construct(SaleBrand $saleBrand)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Ventas - listar marcas', ['only' => ['index']]);
        $this->middleware('permission:Ventas - crear marca', ['only' => ['store']]);
        $this->middleware('permission:Ventas - mostrar marca', ['only' => ['show']]);
        $this->middleware('permission:Ventas - editar marca', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar marca', ['only' => ['destroy']]);
        $this->saleBrand = $saleBrand;
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
            $result = $this->saleBrand->get();
            $count = $this->saleBrand->count();
            return response([
                'count' => $count,
                'data' => $result
            ], Response::HTTP_OK);
        }
        $saleBrands = $this->saleBrand->paginate();
        return response($saleBrands, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleBrandRequest $request)
    {
        $saleBrand = $this->saleBrand->updateOrCreate($request->toArray());
        History::create([
            'action' => 'Ventas - Creando marca',
            'model_type' => 'App\Models\SaleBrand',
            'model_id' => $saleBrand->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response([
            'data' => $saleBrand
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleBrand  $saleBrand
     * @return \Illuminate\Http\Response
     */
    public function show(SaleBrand $saleBrand)
    {
        return response([
            'data' => $saleBrand
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleBrand  $saleBrand
     * @return \Illuminate\Http\Response
     */
    public function update(SaleBrandRequest $request, SaleBrand $saleBrand)
    {
        History::create([
            'action' => 'Ventas - Actualizando marca',
            'model_type' => 'App\Models\SaleBrand',
            'model_id' => $saleBrand->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleBrand->update($request->all());
        return response([
            'data' => $saleBrand
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleBrand  $saleBrand
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleBrand $saleBrand, Request $request)
    {
        History::create([
            'action' => 'Ventas - Eliminando marca',
            'model_type' => 'App\Models\SaleBrand',
            'model_id' => $saleBrand->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleBrand->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
