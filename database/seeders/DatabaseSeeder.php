<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Device;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        Test data
        for($i=1;$i<100; $i++)
        {
            $dates = [
                "2021-04-28 22:32:57",
                "2021-02-10 22:32:57",
                "2021-01-28 22:32:57",
                "2021-01-12 22:32:57",
                "2020-12-28 22:32:57",
                "2020-11-28 22:32:57"
            ];

            $device = Device::create([
                "uid"=>$i,
                "app_id"=>$i,
                "language"=> "TR",
                "operating_system"=> "iOS",
                "client_token"=> generateClientToken(),
            ]);

            Application::create([
                "device_id"=>$device->id,
                'username' => "test".$i,
                'password' => encrypt(""),
                'callback_url' => getBaseUrl(). "api/test-callback"
            ]);

            Subscription::create([
                "device_id"=>$device->id,
                'expire_date' => $dates[rand(0, 5)],
                'status' => SUBSCRIPTON_STATUS_STARTED
            ]);
        }
        // \App\Models\User::factory(10)->create();
    }
}
