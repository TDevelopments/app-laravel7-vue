<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\SaleCustomer;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permission list
        Permission::create(['name' => 'listar usuarios']);
        Permission::create(['name' => 'crear usuario']);
        Permission::create(['name' => 'mostrar usuario']);
        Permission::create(['name' => 'editar usuario']);
        Permission::create(['name' => 'eliminar usuario']);
        
        Permission::create(['name' => 'Importaciones - listar productos']);
        Permission::create(['name' => 'Importaciones - crear producto']);
        Permission::create(['name' => 'Importaciones - mostrar producto']);
        Permission::create(['name' => 'Importaciones - editar producto']);
        Permission::create(['name' => 'Importaciones - eliminar producto']);
        
        Permission::create(['name' => 'Importaciones - listar categorias']);
        Permission::create(['name' => 'Importaciones - crear categoria']);
        Permission::create(['name' => 'Importaciones - mostrar categoria']);
        Permission::create(['name' => 'Importaciones - editar categoria']);
        Permission::create(['name' => 'Importaciones - eliminar categoria']);
        
        Permission::create(['name' => 'Importaciones - listar catalogos']);
        Permission::create(['name' => 'Importaciones - crear catalogo']);
        Permission::create(['name' => 'Importaciones - mostrar catalogo']);
        Permission::create(['name' => 'Importaciones - editar catalogo']);
        Permission::create(['name' => 'Importaciones - eliminar catalogo']);
        
        Permission::create(['name' => 'Importaciones - listar productos con rango']);
        Permission::create(['name' => 'Importaciones - crear producto con rango']);
        Permission::create(['name' => 'Importaciones - mostrar producto con rango']);
        Permission::create(['name' => 'Importaciones - editar producto con rango']);
        Permission::create(['name' => 'Importaciones - eliminar producto con rango']);
        
        Permission::create(['name' => 'Importaciones - listar unidades']);
        Permission::create(['name' => 'Importaciones - crear unidad']);
        Permission::create(['name' => 'Importaciones - mostrar unidad']);
        Permission::create(['name' => 'Importaciones - editar unidad']);
        Permission::create(['name' => 'Importaciones - eliminar unidad']);
        
        /* Permission::create(['name' => 'Importaciones - listar entidades bancarias']); */
        Permission::create(['name' => 'Importaciones - crear entidad bancaria']);
        Permission::create(['name' => 'Importaciones - mostrar entidad bancaria']);
        Permission::create(['name' => 'Importaciones - editar entidad bancaria']);
        Permission::create(['name' => 'Importaciones - eliminar entidad bancaria']);
        
        Permission::create(['name' => 'Importaciones - listar estados de orden']);
        Permission::create(['name' => 'Importaciones - crear estado de orden']);
        Permission::create(['name' => 'Importaciones - mostrar estado de orden']);
        Permission::create(['name' => 'Importaciones - editar estado de orden']);
        Permission::create(['name' => 'Importaciones - eliminar estado de orden']);
        
        Permission::create(['name' => 'Importaciones - listar estados de envio']);
        Permission::create(['name' => 'Importaciones - crear estado de envio']);
        Permission::create(['name' => 'Importaciones - mostrar estado de envio']);
        Permission::create(['name' => 'Importaciones - editar estado de envio']);
        Permission::create(['name' => 'Importaciones - eliminar estado de envio']);
        
        Permission::create(['name' => 'Importaciones - listar conceptos de pago']);
        Permission::create(['name' => 'Importaciones - crear concepto de pago']);
        Permission::create(['name' => 'Importaciones - mostrar concepto de pago']);
        Permission::create(['name' => 'Importaciones - editar concepto de pago']);
        Permission::create(['name' => 'Importaciones - eliminar concepto de pago']);
        
        /* Permission::create(['name' => 'Importaciones - crear productos masivo']); */
        /* Permission::create(['name' => 'Importaciones - crear productos con rango massivo']); */
        
        /* Permission::create(['name' => 'Importaciones - listar asesores']); */
        Permission::create(['name' => 'Importaciones - crear asesor']);
        Permission::create(['name' => 'Importaciones - mostrar asesor']);
        Permission::create(['name' => 'Importaciones - editar asesor']);
        Permission::create(['name' => 'Importaciones - eliminar asesor']);
        
        /* Permission::create(['name' => 'Importaciones - lista catalogos']); */
        /* Permission::create(['name' => 'Importaciones - lista categorias']); */
        
        Permission::create(['name' => 'Importaciones - crear y actualizar llegadas catalogo']);
        Permission::create(['name' => 'Importaciones - eliminar llegada catalogo']);
        
        Permission::create(['name' => 'Importaciones - crear y actualizar rangos producto']);
        Permission::create(['name' => 'Importaciones - eliminar rango producto']);
        
        Permission::create(['name' => 'Importaciones - listar ordenes']);
        Permission::create(['name' => 'Importaciones - crear orden']);
        Permission::create(['name' => 'Importaciones - mostrar orden']);
        Permission::create(['name' => 'Importaciones - editar orden']);
        Permission::create(['name' => 'Importaciones - eliminar orden']);
        
        Permission::create(['name' => 'Importaciones - crear y actualizar detalles de orden']);
        Permission::create(['name' => 'Importaciones - eliminar detalles de orden']);
        
        Permission::create(['name' => 'Importaciones - crear y actualizar pagos orden']);
        Permission::create(['name' => 'Importaciones - eliminar pagos orden']);
        
        Permission::create(['name' => 'Importaciones - crear imagenes']);
        
        Permission::create(['name' => 'Ventas - listar categorias']);
        Permission::create(['name' => 'Ventas - crear categoria']);
        Permission::create(['name' => 'Ventas - mostrar categoria']);
        Permission::create(['name' => 'Ventas - editar categoria']);
        Permission::create(['name' => 'Ventas - eliminar categoria']);
        
        Permission::create(['name' => 'Ventas - listar productos']);
        Permission::create(['name' => 'Ventas - crear producto']);
        Permission::create(['name' => 'Ventas - mostrar producto']);
        Permission::create(['name' => 'Ventas - editar producto']);
        Permission::create(['name' => 'Ventas - eliminar producto']);
        
        Permission::create(['name' => 'listar clientes']);
        Permission::create(['name' => 'crear cliente']);
        Permission::create(['name' => 'mostrar cliente']);
        Permission::create(['name' => 'editar cliente']);
        Permission::create(['name' => 'eliminar cliente']);
        
        Permission::create(['name' => 'Ventas - listar marcas']);
        Permission::create(['name' => 'Ventas - crear marca']);
        Permission::create(['name' => 'Ventas - mostrar marca']);
        Permission::create(['name' => 'Ventas - editar marca']);
        Permission::create(['name' => 'Ventas - eliminar marca']);
        
        Permission::create(['name' => 'Ventas - listar sub-categorias']);
        Permission::create(['name' => 'Ventas - crear sub-categoria']);
        Permission::create(['name' => 'Ventas - mostrar sub-categoria']);
        Permission::create(['name' => 'Ventas - editar sub-categoria']);
        Permission::create(['name' => 'Ventas - eliminar sub-categoria']);
        
        Permission::create(['name' => 'Ventas - listar unidades de producto']);
        Permission::create(['name' => 'Ventas - crear unidad de producto']);
        Permission::create(['name' => 'Ventas - mostrar unidad de producto']);
        Permission::create(['name' => 'Ventas - editar unidad de producto']);
        Permission::create(['name' => 'Ventas - eliminar unidad de producto']);
        
        Permission::create(['name' => 'Ventas - listar tipos de producto']);
        Permission::create(['name' => 'Ventas - crear tipo de producto']);
        Permission::create(['name' => 'Ventas - mostrar tipo de producto']);
        Permission::create(['name' => 'Ventas - editar tipo de producto']);
        Permission::create(['name' => 'Ventas - eliminar tipo de producto']);
        
        Permission::create(['name' => 'Ventas - listar ubicaciones empresa']);
        Permission::create(['name' => 'Ventas - crear ubicacion empresa']);
        Permission::create(['name' => 'Ventas - mostrar ubicacion empresa']);
        Permission::create(['name' => 'Ventas - editar ubicacion empresa']);
        Permission::create(['name' => 'Ventas - eliminar ubicacion empresa']);
        
        Permission::create(['name' => 'Ventas - listar estados de producto']);
        Permission::create(['name' => 'Ventas - crear estado de producto']);
        Permission::create(['name' => 'Ventas - mostrar estado de producto']);
        Permission::create(['name' => 'Ventas - editar estado de producto']);
        Permission::create(['name' => 'Ventas - eliminar estado de producto']);
        
        Permission::create(['name' => 'Ventas - listar registro de stock']);
        Permission::create(['name' => 'Ventas - crear registro stock']);
        Permission::create(['name' => 'Ventas - mostrar registro stock']);
        Permission::create(['name' => 'Ventas - editar registro stock']);
        Permission::create(['name' => 'Ventas - eliminar registro stock']);
        
        Permission::create(['name' => 'Ventas - listar entregas']);
        Permission::create(['name' => 'Ventas - crear entrega']);
        Permission::create(['name' => 'Ventas - mostrar entrega']);
        Permission::create(['name' => 'Ventas - editar entrega']);
        Permission::create(['name' => 'Ventas - eliminar entrega']);
        
        Permission::create(['name' => 'Ventas - listar estados de orden']);
        Permission::create(['name' => 'Ventas - crear estado de orden']);
        Permission::create(['name' => 'Ventas - mostrar estado de orden']);
        Permission::create(['name' => 'Ventas - editar estado de orden']);
        Permission::create(['name' => 'Ventas - eliminar estado de orden']);
        
        Permission::create(['name' => 'Ventas - listar ordenes']);
        Permission::create(['name' => 'Ventas - crear orden']);
        Permission::create(['name' => 'Ventas - mostrar orden']);
        Permission::create(['name' => 'Ventas - editar orden']);
        Permission::create(['name' => 'Ventas - eliminar orden']);

        Permission::create(['name' => 'Ventas - crear y actualizar detalles de orden']);
        Permission::create(['name' => 'Ventas - eliminar detalles de orden']);
        
        Permission::create(['name' => 'Ventas - listar metodos de pago']);
        Permission::create(['name' => 'Ventas - crear metodo de pago']);
        Permission::create(['name' => 'Ventas - mostrar metodo de pago']);
        Permission::create(['name' => 'Ventas - editar metodo de pago']);
        Permission::create(['name' => 'Ventas - eliminar metodo de pago']);
        
        Permission::create(['name' => 'Ventas - listar estados de pago']);
        Permission::create(['name' => 'Ventas - crear estado de pago']);
        Permission::create(['name' => 'Ventas - mostrar estado de pago']);
        Permission::create(['name' => 'Ventas - editar estado de pago']);
        Permission::create(['name' => 'Ventas - eliminar estado de pago']);
        
        Permission::create(['name' => 'Ventas - crear pago de orden']);
        Permission::create(['name' => 'Ventas - actualizar pago de orden']);
        Permission::create(['name' => 'Ventas - eliminar pago de orden']);
        
        Permission::create(['name' => 'listar roles']);
        Permission::create(['name' => 'crear rol']);
        Permission::create(['name' => 'mostrar rol']);
        Permission::create(['name' => 'editar rol']);
        Permission::create(['name' => 'eliminar rol']);
        
        Permission::create(['name' => 'listar permisos']);
        Permission::create(['name' => 'agregar permiso rol']);
        Permission::create(['name' => 'revocar permiso rol']);

        Permission::create(['name' => 'historial']);
        
        Permission::create(['name' => 'listar colores']);
        Permission::create(['name' => 'crear color']);
        Permission::create(['name' => 'mostrar color']);
        Permission::create(['name' => 'editar color']);
        Permission::create(['name' => 'eliminar color']);

        $admin = Role::findByName('admin');
        $admin->givePermissionTo([
            'listar usuarios',
            'Importaciones - listar productos',
            'Importaciones - listar categorias',
            'Importaciones - listar catalogos',
            'Importaciones - listar productos con rango',
            'Importaciones - listar unidades',
            /* 'Importaciones - listar entidades bancarias', */
            'Importaciones - listar estados de orden',
            'Importaciones - listar estados de orden',
            'Importaciones - listar estados de envio',
            'Importaciones - listar conceptos de pago',
            /* 'Importaciones - listar asesores', */
            'Importaciones - listar ordenes',
            'Importaciones - crear imagenes',
            'Ventas - listar categorias',
            'Ventas - listar productos',
            'listar clientes',
            'Ventas - listar marcas',
            'Ventas - listar sub-categorias',
            'Ventas - listar unidades de producto',
            'Ventas - listar tipos de producto',
            'Ventas - listar ubicaciones empresa',
            'Ventas - listar estados de producto',
            'Ventas - listar registro de stock',
            'Ventas - listar entregas',
            'Ventas - listar estados de orden',
            'Ventas - listar ordenes',
            'Ventas - listar metodos de pago',
            'Ventas - listar estados de pago',
            'listar roles',
            'listar permisos',
            'Importaciones - crear orden',
            'Ventas - crear orden',
            'historial',
            'listar colores',
        ]);
        
        $user = Role::firstWhere('name', 'user');
        $user->givePermissionTo([
            'Importaciones - crear orden',
            'Ventas - crear orden',
        ]);

        $superAdmin = Role::create(['name' => 'Super Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $superAdmin->syncPermissions($permissions);
        
        $user = User::create([
            'name' => 'Nezky Cary Viveros',
            'email' => 'nezky@gmail.com',
            'password' => bcrypt('administrador'),
            'address' => 'Calle Don Bosco 108',
            'dni' => 42472778,
            'phone' => 958073710,
            'city' => 'Arequipa',
        ]);

        SaleCustomer::create([
            'FullName' => 'Nezky Cary Viveros',
            'Phone' => '958073710',
            'Email' => 'nezky@gmail.com',
            'Dni' => '42472778',
            'user_id' => $user->id
        ]);
        $user->assignRole([$superAdmin->id, $admin->id]);
    }
}
