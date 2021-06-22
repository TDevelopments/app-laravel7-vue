<?php

namespace App\Http\Controllers\Api\v1;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use Symfony\Component\HttpFoundation\Response;
use App\Models\History;
use Carbon\Carbon;

class RoleController extends Controller
{
    
    protected $role;

    /**
     * Constructor
     *
     * @param \App\Models\Role $role.
     */
    public function __construct(Role $role)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:listar roles', ['only' => ['index']]);
        $this->middleware('permission:crear rol', ['only' => ['store']]);
        $this->middleware('permission:mostrar rol', ['only' => ['show']]);
        $this->middleware('permission:editar rol', ['only' => ['update']]);
        $this->middleware('permission:eliminar rol', ['only' => ['destroy']]);
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* return response()->json(["data" => $this->role->all()]); */
        /* $admin = Role::firstWhere('name', 'admin'); */
        /* return $admin->permissions; */
        if ($request->query("list")) {
            $value = $request->query("list");
            $result = $this->role->get();
            return response([
                'data' => $result
            ], Response::HTTP_OK);
        }
        $roles = $this->role->paginate();
        return response($roles, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = $this->role->updateOrCreate([ 'name' => $request->name, 'guard_name' => 'web' ]);
        History::create([
            'action' => 'Creando rol',
            'model_type' => 'Spatie\Permission\Models\Role',
            'model_id' => $role->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response([
            'data' => $role
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return response([
            'data' => new RoleResource($role)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        History::create([
            'action' => 'Actualizando rol',
            'model_type' => 'Spatie\Permission\Models\Role',
            'model_id' => $role->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $role->update($request->all());
        return response([
            'data' => $role
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role, Request $request)
    {
        History::create([
            'action' => 'Eliminando rol',
            'model_type' => 'Spatie\Permission\Models\Role',
            'model_id' => $role->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $role->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
