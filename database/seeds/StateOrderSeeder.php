<?php

use Illuminate\Database\Seeder;
use App\Models\StateOrder;

class StateOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $concept = new StateOrder();
        $concept->name = 'Separado';
        $concept->save();

        $concept = new StateOrder();
        $concept->name = 'Pagado';
        $concept->save();

        $concept = new StateOrder();
        $concept->name = 'Anulado';
        $concept->save();
    }
}
