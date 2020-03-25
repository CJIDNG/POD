<?php

use App\Subapp;
use App\Platform;
use App\CurrentTenant;
use App\Constants\Subapps\Udeme;
use App\Constants\Subapps\HealthCareTracka;
use Illuminate\Database\Seeder;

class SubappsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $allProvided = Subapp::getAllProvided();

      foreach ($allProvided as $key => $subapp) {
        Subapp::firstOrCreate([
          'name' => $subapp
        ]);
      }

      // $platformName = session()->get('platform_name');

      // switch ($platformName) {
      //   case '':

      //     break;
        
      //   default:
      //     $subapps = [];
      //     break;
      // }

      // if (count($subapps) === 0) {
      //   return;
      // }

      // // set up platform subapps
      // $platform = Platform::where('name', $platformName)->first();
      // $platform->subapps()->attach($subapps);
    }
}
