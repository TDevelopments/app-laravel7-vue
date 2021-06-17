<?php

namespace App\Http\Controllers\Api\v1;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\History;
use Carbon\Carbon;

class PermissionController extends Controller
{
    
    protected $permission;

    /**
     * Constructor
     *
     * @param \App\Models\Role $role.
     */
    public function __construct(Permission $permission)
    {
        /* $this->middleware('api.admin'); */
        $this->middleware('permission:listar permisos', ['only' => ['index']]);
        $this->middleware('permission:agregar permiso rol', ['only' => ['store']]);
        $this->middleware('permission:revocar permiso rol', ['only' => ['update']]);
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* if ($request->query("list")) { */
            $value = $request->query("list");
            $result = $this->permission->get();
            return response([
                'data' => $result
            ], Response::HTTP_OK);
        /* } */
        /* $roles = $this->role->paginate(); */
        /* return response($roles, Response::HTTP_OK); */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'permissions' => ['array'],
            'permissions.*' => ['string', 'exists:Spatie\Permission\Models\Permission,name'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $role->givePermissionTo($request->permissions);
        History::create([
            'action' => 'Agregando permisos rol',
            'model_type' => 'Spatie\Permission\Models\Role',
            'model_id' => $role->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        return response($role, Response::HTTP_OK);
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
    public function update(Request $request, Role $role)
    {
        History::create([
            'action' => 'Revocando permisos rol',
            'model_type' => 'Spatie\Permission\Models\Role',
            'model_id' => $role->id,
            'user_id' => $request->user()->id,
            'creation_date' => Carbon::now()
        ]);
        $validator = Validator::make($request->all(), [
            'permissions' => ['array'],
            'permissions.*' => ['string', 'exists:Spatie\Permission\Models\Permission,name'],
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }
        $role->revokePermissionTo($request->permissions);
        return response($role, Response::HTTP_OK);
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
