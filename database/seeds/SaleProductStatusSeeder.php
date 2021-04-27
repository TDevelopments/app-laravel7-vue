<?php

use Illuminate\Database\Seeder;
use App\Models\SaleProductStatus;

class SaleProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $business = new SaleProductStatus();
        $business->StatusName = 'Observado';
        $business->save();

        $business = new SaleProductStatus();
        $business->StatusName = 'Reservado';
        $business->save();

        $business = new SaleProductStatus();
        $business->StatusName = 'En Venta';
        $business->save();
    }
}
