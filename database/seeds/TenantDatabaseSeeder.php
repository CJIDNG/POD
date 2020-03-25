<?php

use Illuminate\Database\Seeder;
use App\Subapp;

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
    $this->call(LocationTableSeeder::class);
    $this->call(AgenciesTableSeeder::class);
    $this->call(MinistriesTableSeeder::class);
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
