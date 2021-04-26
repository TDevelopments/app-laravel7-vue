<?php

use Illuminate\Database\Seeder;
use App\Models\SaleProductType;

class SaleProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unit = new SaleProductType();
        $unit->TypeName = 'Variable';
        $unit->save();

        $unit = new SaleProductType();
        $unit->TypeName = 'Combo';
        $unit->save();
    }
}
