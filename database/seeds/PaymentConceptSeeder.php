<?php

use Illuminate\Database\Seeder;
use App\Models\PaymentConcept;

class PaymentConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $concept = new PaymentConcept();
        $concept->name = 'Pago de separación de cupo';
        $concept->save();
        
        $concept = new PaymentConcept();
        $concept->name = 'Pago de la primera cuota';
        $concept->save();

        $concept = new PaymentConcept();
        $concept->name = 'Pago de la segunda cuota';
        $concept->save();

        $concept = new PaymentConcept();
        $concept->name = 'Comisión';
        $concept->save();
    }
}
