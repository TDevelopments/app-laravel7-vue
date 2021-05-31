<?php

use Illuminate\Database\Seeder;
use App\Models\User;
/* use App\Models\Role; */
use Spatie\Permission\Models\Role;
use App\Models\SaleCustomer;

use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(MeasureSeeder::class);
        $this->call(BankEntitySeeder::class);
        $this->call(PaymentConceptSeeder::class);
        $this->call(StateOrderSeeder::class);

        $user = User::create([
            'name' => 'George Miguel',
            'lastname' => 'Puma S.',
            'email' => 'g@gmail.com',
            'password' => bcrypt('12345678'),
            'address' => 'Calle Cuba 102',
            'dni' => 74867621,
            'phone' => 969266730,
            'gender' => 'masculine',
            'city' => 'Arequipa',
        ]);

        SaleCustomer::create([
            'FullName' => 'George Miguel Puma Salcedo',
            'Phone' => '969266730',
            'Email' => 'g@gmail.com',
            'Dni' => '74867621',
            'user_id' => $user->id
        ]);
        $user->roles()->attach(Role::where('name', 'user')->first());
        $user->roles()->attach(Role::where('name', 'admin')->first());

        // \App\Models\Catalogue::factory(1)->create();
        // \App\Models\Arrival::factory(2)->create();
        // User::factory()->count(20)->create();
        // \App\Models\Category::factory(4)->create();
        // \App\Models\Product::factory(20)->create();
        // \App\Models\ProductRange::factory(20)->create();
        // \App\Models\Range::factory(20)->create();
        factory(\App\Models\Catalogue::class,2)->create();
        factory(\App\Models\Arrival::class,2)->create();
        factory(\App\Models\User::class,20)->create();
        factory(\App\Models\Category::class,4)->create();
        factory(\App\Models\Product::class,20)->create();
        factory(\App\Models\ProductRange::class,20)->create();
        factory(\App\Models\Range::class,20)->create();
    }
}
