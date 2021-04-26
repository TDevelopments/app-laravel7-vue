<?php

use Illuminate\Database\Seeder;
use App\Models\SaleProductUnit;

class SaleProductUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unit = new SaleProductUnit();
        $unit->UnitName = 'Pieza';
        $unit->UnitShortName = 'Pc(s)';
        $unit->save();

        $unit = new SaleProductUnit();
        $unit->UnitName = 'Par';
        $unit->UnitShortName = 'Par';
        $unit->save();
    }
}
