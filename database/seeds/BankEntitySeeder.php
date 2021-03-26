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
        $role = new BankEntity();
        $role->name = 'Banco Continental';
        $role->short_name = 'BBVA';
        $role->save();
    }
}
