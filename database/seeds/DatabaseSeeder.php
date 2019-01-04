<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\User::class, 1)->create();
        factory(App\Role::class, 3)->create();
        factory(App\RoleUser::class, 3)->create();
        factory(App\Permission::class, 3)->create();
        factory(App\PermissionRole::class, 3)->create();
        factory(App\Owner::class, 3)->create();
        factory(App\Driver::class, 3)->create();
        factory(App\Conductor::class, 3)->create();
        factory(App\Location::class, 3)->create();
        factory(App\Endpoint::class, 3)->create();
        factory(App\Seat::class, 3)->create();
        factory(App\Seatnumberorder::class, 3)->create();
        factory(App\Seatstructure::class, 3)->create();
        factory(App\Search::class, 3)->create();
        factory(App\Route::class, 3)->create();
        factory(App\Bus::class, 3)->create();
        factory(App\BusEndpoint::class, 3)->create();
        factory(App\BusLocation::class, 3)->create();
        factory(App\BusSearch::class, 3)->create();
        factory(App\BusSeat::class, 3)->create();
        factory(App\Passenger::class, 3)->create();
        factory(App\PassengerRole::class, 3)->create();
        factory(App\Passengerlog::class, 3)->create();
        factory(App\Bookingdetail::class, 3)->create();
        factory(App\Transaction::class, 3)->create();
    }
}
