<?php

use Illuminate\Database\Seeder;
use App\Model\Util\Subapp;

class TenantDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call(PermissionsTableSeeder::class);
    $this->call(DatalicenseSeeder::class);
    $this->call(DatavisualisationSeeder::class);
    $this->call(DataformatSeeder::class);

    // $platformName = session()->get('platform_name');

    // switch ($platformName) {
    //   case '':
    //     break;
      
    //   default:
    //     # code...
    //     break;
    // }
      
  }
}
