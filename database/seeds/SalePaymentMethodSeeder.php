<?php

use Illuminate\Database\Seeder;
use App\Models\SalePaymentMethod;

class SalePaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $method = new SalePaymentMethod();
        $method->PaymentMethodName = 'Efectivo';
        $method->save();
        
        $method = new SalePaymentMethod();
        $method->PaymentMethodName = 'Tarjeta de Credito';
        $method->save();
        
        $method = new SalePaymentMethod();
        $method->PaymentMethodName = 'Cheque';
        $method->save();
        
        $method = new SalePaymentMethod();
        $method->PaymentMethodName = 'Transferencia Bancaria';
        $method->save();
    }
}
