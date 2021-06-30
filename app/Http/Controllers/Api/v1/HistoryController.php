<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\History;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\HistoryResource;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

class HistoryController extends Controller
{
    protected $saleProduct;

    /**
     * Constructor
     *
     * @param \App\Models\SaleProduct $saleProduct
     */
    public function __construct(History $history)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:historial', ['only' => ['index']]);
        $this->history = $history;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query("date1") && $request->query("date2")) {
            $from = $request->query("date1");
            $to = $request->query("date2");
            $histories = $this->history->whereBetween('creation_date', [$from, $to])->orderBy('created_at', 'ASC')->paginate()->withQueryString();
            return HistoryResource::collection($histories);
        
        }
        $histories = $this->history->orderBy('created_at', 'ASC')->paginate();
        return HistoryResource::collection($histories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
