<?php

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color = new Color();
        $color->name = 'Rojo';
        $color->code= '#FF0000';
        $color->save();

        $color = new Color();
        $color->name = 'Verde';
        $color->code= '#008000';
        $color->save();

        $color = new Color();
        $color->name = 'Azul';
        $color->code= '#0000FF';
        $color->save();

        $color = new Color();
        $color->name = 'Amarillo';
        $color->code= '#FFFF00';
        $color->save();

        $color = new Color();
        $color->name = 'Blanco';
        $color->code= '#FFFFFF';
        $color->save();

        $color = new Color();
        $color->name = 'Plomo';
        $color->code= '#808080';
        $color->save();

        $color = new Color();
        $color->name = 'Negro';
        $color->code= '#000000';
        $color->save();

        $color = new Color();
        $color->name = 'Marron';
        $color->code= '#800000';
        $color->save();

        $color = new Color();
        $color->name = 'Lima';
        $color->code= '#00FF00';
        $color->save();

        $color = new Color();
        $color->name = 'Aqua';
        $color->code= '#00FFFF';
        $color->save();

        $color = new Color();
        $color->name = 'Rosado';
        $color->code= '#FF00FF';
        $color->save();

        $color = new Color();
        $color->name = 'Morado';
        $color->code= '#800080';
        $color->save();

        $color = new Color();
        $color->name = 'Verde Azulado';
        $color->code= '#008080';
        $color->save();

        $color = new Color();
        $color->name = 'Plateado';
        $color->code= '#C0C0C0';
        $color->save();
    }
}
