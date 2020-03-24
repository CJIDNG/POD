<?php

use Illuminate\Database\Seeder;

class DatalicenseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $allLicenses = \App\Datalicense::defaultLicenses();

    foreach ($allLicenses as $license) {
      \App\Datalicense::firstOrCreate($license);
    }
  }
}
