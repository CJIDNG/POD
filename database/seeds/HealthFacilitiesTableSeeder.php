<?php

use Illuminate\Database\Seeder;
use App\HealthFacility;

class HealthFacilitiesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = base_path('public/assets/healthfacilities.csv');
    $facilitiesArr = Helper::csvToArray($file);
    
    for ($i = 0; $i < count($facilitiesArr); $i ++) {
      HealthFacility::firstOrCreate($facilitiesArr[$i]);
    }
  }
}
