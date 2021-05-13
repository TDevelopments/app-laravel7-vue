<?php

use Illuminate\Database\Seeder;

class SalesModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SaleStateOrderSeeder::class,
            SalePaymentMethodSeeder::class,
            SalePaymentStatusSeeder::class,
            SaleGenderSeeder::class,
            SaleProductUnitSeeder::class,
            SaleProductTypeSeeder::class,
            SaleBrandSeeder::class,
            SaleBusinessLocationSeeder::class,
            SaleProductStatusSeeder::class,
        ]);

        factory(\App\Models\SaleCategory::class, 10)->create()
        ->each(function ($saleCategory) {
            $saleCategory->SalePictures()->save(factory(App\Models\SalePicture::class)->make());
        });
        /* factory(\App\Models\SaleProduct::class, 35)->create() */
        /* ->each(function ($saleProduct) { */
        /*     $saleProduct->SalePictures()->save(factory(App\Models\SalePicture::class)->make()); */
        /* }); */
        factory(\App\Models\SaleCustomer::class, 20)->create();
        /* factory(\App\Models\SaleStockRecord::class, 15)->create(); */
    }
}
