<?php

use Illuminate\Database\Seeder;
use App\Models\SaleGender;

class SaleGenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gender = new SaleGender();
        $gender->GenderName = 'Ninguno';
        $gender->GenderChar = 'N';
        $gender->save();

        $gender = new SaleGender();
        $gender->GenderName = 'Masculino';
        $gender->GenderChar = 'M';
        $gender->save();

        $gender = new SaleGender();
        $gender->GenderName = 'Femenino';
        $gender->GenderChar = 'F';
        $gender->save();

        $gender = new SaleGender();
        $gender->GenderName = 'Unisex';
        $gender->GenderChar = 'U';
        $gender->save();
    }
}
