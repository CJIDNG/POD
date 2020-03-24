<?php

use Illuminate\Database\Seeder;
use App\Type;

class TypesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $platformName = session()->get('platform_name');

    $file = base_path("public/assets/{$platformName}_types.csv");
    $typesArr = Helper::csvToArray($file);
    
    for ($i = 0; $i < count($typesArr); $i ++) {
      Type::firstOrCreate($typesArr[$i]);
    }
  }
}
