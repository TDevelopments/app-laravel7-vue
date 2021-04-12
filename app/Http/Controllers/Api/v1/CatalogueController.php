<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Http\Requests\CatalogueRequest;
use App\Http\Resources\CatalogueResource;
use App\Http\Resources\CatalogueAdminResource;

class CatalogueController extends Controller
{

    protected $catalogue;

    public function __construct(Catalogue $catalogue)
    {
        $this->middleware('api.admin')->except(['availables']);
        $this->catalogue = $catalogue;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CatalogueResource::collection($this->catalogue->orderBy('created_at', 'desc')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatalogueRequest $request)
    {
        $catalogue = $this->catalogue->create($request->all());
        return new CatalogueResource($catalogue);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Catalogue $catalogue)
    {
        return new CatalogueResource($catalogue);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CatalogueRequest $request,Catalogue $catalogue)
    {
        $catalogue->update($request->all());
        return new CatalogueResource($catalogue);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalogue $catalogue)
    {
        $catalogue->delete();
        return response()->json(null, 204);
    }

    public function availables()
    {
        $availables = $this->catalogue->where('is_available', true)->get();
        return CatalogueResource::collection($availables);
    }

    public function list(Request $request)
    {
        $value = $request->query("name");
        $catalagues = $this->catalogue->select('id', 'name')->where('name', 'like', "%$value%")->get();
        return response()->json(["data" => $catalagues], 200);
    }
}
