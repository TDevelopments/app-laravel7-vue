<?php

use Illuminate\Database\Seeder;
use App\Models\SaleBrand;

class SaleBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand = new SaleBrand();
        $brand->BrandName = 'Sin Marca';
        $brand->save();
    }
}
