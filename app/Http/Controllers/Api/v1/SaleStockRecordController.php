<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SaleStockRecord;
use App\Models\SaleProduct;
use App\Models\SaleProductStatus;
use App\Models\SaleCustomer;
use Illuminate\Http\Request;
use App\Http\Requests\SaleStockRecordRequest;
use App\Http\Resources\SaleStockRecordResource;
use App\Http\Resources\SaleStockRecordCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;

class SaleStockRecordController extends Controller
{
    protected $saleStockRecord;
    protected $saleProduct;
    protected $saleCustomer;
    protected $saleProductStatus;

    public function __construct(SaleStockRecord $saleStockRecord, SaleCustomer $saleCustomer, SaleProduct $saleProduct, SaleProductStatus $saleProductStatus)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Ventas - listar registro de stock', ['only' => ['index']]);
        $this->middleware('permission:Ventas - crear registro stock', ['only' => ['store']]);
        $this->middleware('permission:Ventas - mostrar registro stock', ['only' => ['show']]);
        $this->middleware('permission:Ventas - editar registro stock', ['only' => ['update']]);
        $this->middleware('permission:Ventas - eliminar registro stock', ['only' => ['destroy']]);
        $this->saleStockRecord = $saleStockRecord;
        $this->saleCustomer = $saleCustomer;
        $this->saleProduct = $saleProduct;
        $this->saleProductStatus = $saleProductStatus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query('ByCustomer')) {
            $value = $request->query('ByCustomer');
            $saleProductStatus = $this->saleProductStatus->firstWhere('StatusName', 'Reservado');
            $consult = $this->saleStockRecord->where('sale_product_status_id', $saleProductStatus->id)->where('sale_customer_id', $value)->paginate()->withQueryString();
            return SaleStockRecordResource::collection($consult);
        }
        if ($request->query("BusinessId") || $request->query("StatusId") || $request->query("ProductName") || $request->query("CustomerName") || $request->query("ColorCode") || $request->query("Size")) {
            $value1 = $request->query("BusinessId");
            $value2 = $request->query("StatusId");
            $value3 = $request->query("ProductName");
            $value4 = $request->query("CustomerName");
            $value5 = $request->query("ColorCode");
            $value6 = $request->query("Size");
            $query = $this->saleStockRecord->where('Quantity', '>', 0);
            if($request->query("BusinessId"))
            {
                $query->where('sale_business_location_id', $value1);
            }
            if($request->query("StatusId"))
            {
                $query->where("sale_product_status_id", $value2);
            }
            if($request->query("ProductName"))
            {
                $productReference = $this->saleProduct->firstWhere("ProductName", "like", "%$value3%");
                if (!empty($productReference))
                    $query->where("sale_product_id", $productReference->id);
            }
            if($request->query("CustomerName"))
            {
                // $customerReference = $this->saleCustomer->where("FirstName", "like", "%$value4%")->orWhere("LastName", "like", "%$value4%")->first();
                $customerReference = $this->saleCustomer->where('FullName', 'like', "%$value4%")->first();
                if (!empty($customerReference))
                    $query->where("sale_customer_id", $customerReference->id);
            }
            if($request->query("ColorCode"))
            {
                $query->where("Color", $value5);
            }
            if($request->query("Size"))
            {
                $query->where("Size", $value6);
            }
            return new SaleStockRecordCollection($query->orderBy('created_at', 'desc')->paginate()->withQueryString());
        }
        $saleStockRecords = $this->saleStockRecord->where('Quantity', '>', 0)->orderBy('created_at', 'desc')->paginate();
        return SaleStockRecordResource::collection($saleStockRecords);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleStockRecordRequest $request)
    {
        if ($request->StockRecords) {
            foreach ($request->StockRecords as $stockRecord) {
                if (empty($stockRecord['Size']))
                    $stockRecord['Size'] = null;
                if (empty($stockRecord['Color']))
                    $stockRecord['Color'] = null;
                if (empty($stockRecord['StockRecordId'])) {
                    $referenceStockRecord = $this->saleStockRecord->create([
                        'sale_product_id' => $stockRecord['ProductId'],
                        'sale_business_location_id' => $stockRecord['BusinessLocationId'],
                        'sale_product_status_id' => $stockRecord['ProductStatusId'],
                        'sale_customer_id' => $stockRecord['CustomerId'],
                        'Quantity' => $stockRecord['Quantity'],
                        'Size' => $stockRecord['Size'],
                        'Color' => $stockRecord['Color'],
                    ]);
                    History::create([
                        'action' => 'Ventas - Creando registro stock',
                        'model_type' => 'App\Models\SaleStockRecord',
                        'model_id' => $referenceStockRecord->id,
                        'user_id' => $request->user()->id,
                        'creation_date' => Carbon::now()
                    ]);
                    $saleStockRecord[] = $referenceStockRecord;
                } else {
                    $stockRecordReference = $this->saleStockRecord->find($stockRecord['StockRecordId']);
                    $stockRecordReference->sale_business_location_id = $stockRecord['BusinessLocationId'];
                    $stockRecordReference->sale_product_status_id = $stockRecord['ProductStatusId'];
                    $stockRecordReference->sale_customer_id = $stockRecord['CustomerId'];
                    $stockRecordReference->Quantity = $stockRecord['Quantity'];
                    $stockRecordReference->Size = $stockRecord['Size'];
                    $stockRecordReference->Color = $stockRecord['Color'];
                    $stockRecordReference->save();
                    History::create([
                        'action' => 'Ventas - Actualizando registro stock',
                        'model_type' => 'App\Models\SaleStockRecord',
                        'model_id' => $stockRecordReference->id,
                        'user_id' => $request->user()->id,
                        'creation_date' => Carbon::now()
                    ]);
                    $saleStockRecords[] = $stockRecordReference;
                }
            }
            return SaleStockRecordResource::collection($saleStockRecords);
        }
        $saleStockRecord = $this->saleStockRecord->create($request->toArray());
        return response([
            'data' => new SaleStockRecordResource($saleStockRecord)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleStockRecord  $saleStockRecord
     * @return \Illuminate\Http\Response
     */
    public function show(SaleStockRecord $saleStockRecord)
    {
        return new SaleStockRecordResource($saleStockRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleStockRecord  $saleStockRecord
     * @return \Illuminate\Http\Response
     */
    public function update(SaleStockRecordRequest $request, SaleStockRecord $saleStockRecord)
    {
        History::create([
            'action' => 'Ventas - Actualizando registro stock',
            'model_type' => 'App\Models\SaleStockRecord',
            'model_id' => $saleStockRecord->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleStockRecord->update($request->all());
        /* $saleStockRecord->update(['order_detail_id' => NULL]); */
        return response([
            'data' => new SaleStockRecordResource($saleStockRecord)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleStockRecord  $saleStockRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleStockRecord $saleStockRecord, Request $request)
    {
        History::create([
            'action' => 'Ventas - Eliminando registro stock',
            'model_type' => 'App\Models\SaleStockRecord',
            'model_id' => $saleStockRecord->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $saleStockRecord->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
