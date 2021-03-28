<?php

use Illuminate\Database\Seeder;
use App\Models\BankEntity;
class BankEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bank = new BankEntity();
        $bank->name = 'Banco Continental';
        $bank->short_name = 'BBVA';
        $bank->save();
    }
}
