<?php

use Illuminate\Database\Seeder;
use App\Models\SalePaymentStatus;
class SalePaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new SalePaymentStatus();
        $status->PaymentStatusName = 'Pagado';
        $status->save();

        $status = new SalePaymentStatus();
        $status->PaymentStatusName = 'Debiendo';
        $status->save();
    }
}
