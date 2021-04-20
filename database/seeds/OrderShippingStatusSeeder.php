<?php

use Illuminate\Database\Seeder;
use App\Models\OrderShippingStatus;

class OrderShippingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shipping = new OrderShippingStatus();
        $shipping->name = 'Pendiente';
        $shipping->save();
        
        $shipping = new OrderShippingStatus();
        $shipping->name = 'En Transito';
        $shipping->save();

        $shipping = new OrderShippingStatus();
        $shipping->name = 'Enviada';
        $shipping->save();
    }
}
