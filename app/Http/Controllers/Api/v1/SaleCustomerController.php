<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleCustomer;
use Illuminate\Http\Request;
use App\Http\Requests\SaleCustomerRequest;
use App\Http\Requests\UpdateSaleCustomerRequest;
use App\Http\Resources\SaleCustomerResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class SaleCustomerController extends Controller
{
    protected $saleCustomer;

    /**
     * Constructor
     *
     * @param \App\Models\SaleCategory $saleCategory
     */
    public function __construct(SaleCustomer $saleCustomer)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:listar clientes', ['only' => ['index']]);
        $this->middleware('permission:crear cliente', ['only' => ['store']]);
        $this->middleware('permission:mostrar cliente', ['only' => ['show']]);
        $this->middleware('permission:editar cliente', ['only' => ['update']]);
        $this->middleware('permission:eliminar cliente', ['only' => ['destroy']]);
        $this->saleCustomer = $saleCustomer;
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
            $result = $this->saleCustomer->select('id', 'FullName')->get();
            $count = $this->saleCustomer->count();
            return response([
                'count' => $count,
                'data' => $result,
            ], Response::HTTP_OK);
        }
        if ($request->query("Search")) {
            $value = $request->query("Search");
            $result = $this->saleCustomer->where('FullName', 'like', "%$value%")
                    ->orWhere('Email', 'like', "%$value%")
                    ->orWhere('Phone', 'like', "%$value%")
                    ->orWhere('Dni', 'like', "%$value%")->paginate()->withQueryString();
            return SaleCustomerResource::collection($result);
            /* return response([ */
            /*     'data' => $result, */
            /* ], Response::HTTP_OK); */
        }
        $saleCustomer = $this->saleCustomer->paginate();
        return SaleCustomerResource::collection($saleCustomer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleCustomerRequest $request)
    {
        $saleCustomer = $this->saleCustomer->create($request->toArray());
        History::create([
            'action' => 'Creando cliente',
            'model_type' => 'App\Models\SaleCustomer',
            'model_id' => $saleCustomer->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response([
            'data' => new SaleCustomerResource($saleCustomer)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleCustomer  $saleCustomer
     * @return \Illuminate\Http\Response
     */
    public function show(SaleCustomer $saleCustomer)
    {
        return new SaleCustomerResource($saleCustomer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleCustomer  $saleCustomer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSaleCustomerRequest $request, SaleCustomer $saleCustomer)
    {
        History::create([
            'action' => 'Actualizando cliente',
            'model_type' => 'App\Models\SaleCustomer',
            'model_id' => $saleCustomer->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleCustomer->update($request->all());
        return response([
            'data' => new SaleCustomerResource($saleCustomer)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleCustomer  $saleCustomer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleCustomer $saleCustomer, Request $request)
    {
        History::create([
            'action' => 'Eliminando cliente',
            'model_type' => 'App\Models\SaleCustomer',
            'model_id' => $saleCustomer->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleCustomer->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
