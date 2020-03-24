<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $platformName = session()->get('platform_name');

    $file = base_path("public/assets/{$platformName}_statuses.csv");
    $statusesArr = Helper::csvToArray($file);
    
    for ($i = 0; $i < count($statusesArr); $i ++) {
      Status::firstOrCreate($statusesArr[$i]);
    }
  }
}
