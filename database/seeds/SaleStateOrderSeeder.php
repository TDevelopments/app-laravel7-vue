<?php

use Illuminate\Database\Seeder;
use App\Models\SaleStateOrder;

class SaleStateOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $state = new SaleStateOrder();
        $state->Name = 'Pendiente';
        $state->ShortName = 'P';
        $state->save();
        
        $state = new SaleStateOrder();
        $state->Name = 'Anulado';
        $state->ShortName = 'A';
        $state->save();
        
        $state = new SaleStateOrder();
        $state->Name = 'Pagado';
        $state->ShortName = 'C';
        $state->save();
    }
}
