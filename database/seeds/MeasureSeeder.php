<?php

use Illuminate\Database\Seeder;
use App\Models\Measure;

class MeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $measure = new Measure();
        $measure->name = 'Unidades';
        $measure->save();

        $measure = new Measure();
        $measure->name = 'Sets';
        $measure->save();

        $measure = new Measure();
        $measure->name = 'Pares';
        $measure->save();
    }
}
