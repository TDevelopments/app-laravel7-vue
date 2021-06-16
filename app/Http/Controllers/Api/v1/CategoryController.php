<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\History;
use Carbon\Carbon;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:Importaciones - listar categorias', ['only' => ['index', 'list']]);
        $this->middleware('permission:Importaciones - crear categoria', ['only' => ['store']]);
        $this->middleware('permission:Importaciones - mostrar categoria', ['only' => ['show']]);
        $this->middleware('permission:Importaciones - editar categoria', ['only' => ['update']]);
        $this->middleware('permission:Importaciones - eliminar categoria', ['only' => ['destroy']]);
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryResource::collection($this->category->orderBy('name')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->category->create($request->all());
        History::create([
            'action' => 'Creando Categoria',
            'model_type' => 'App\Models\Category',
            'model_id' => $category->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        History::create([
            'action' => 'Actualizando Categoria',
            'model_type' => 'App\Models\Category',
            'model_id' => $category->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $category->update($request->all());
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Request $request)
    {
        History::create([
            'action' => 'Eliminando Categoria',
            'model_type' => 'App\Models\Category',
            'model_id' => $category->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $category->delete();
        return response()->json(null, 204);
    }
    
    public function list()
    {
        return response()->json(["data" => $this->category->select('id', 'name')->get()], 200);
    }
}
