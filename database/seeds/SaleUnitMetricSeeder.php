<?php

use Illuminate\Database\Seeder;
use App\Models\SaleUnitMetric;

class SaleUnitMetricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metric = new SaleUnitMetric();
        $metric->MetricName = 'Kilogramos';
        $metric->MetricSymbol = 'Kg';
        $metric->save();

        $metric = new SaleUnitMetric();
        $metric->MetricName = 'Gramos';
        $metric->MetricSymbol = 'g';
        $metric->save();

        $metric = new SaleUnitMetric();
        $metric->MetricName = 'Libras';
        $metric->MetricSymbol = 'L';
        $metric->save();
    }
}
