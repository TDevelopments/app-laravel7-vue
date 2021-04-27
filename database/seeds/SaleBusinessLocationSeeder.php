<?php

use Illuminate\Database\Seeder;
use App\Models\SaleBusinessLocation;

class SaleBusinessLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $business = new SaleBusinessLocation();
        $business->Name= 'Almacen Calle Don Bosco';
        $business->Address = 'Calle Don Bosco 107';
        $business->City = 'Arequipa';
        $business->Region = 'Arequipa';
        $business->PostalCode = '04004';
        $business->Country = 'Perú';
        $business->save();
    }
}
