<?php

use Illuminate\Database\Seeder;

use App\Agency;

class AgenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = base_path('public/assets/agencies.csv');
        $agenciesArr = Helper::csvToArray($file);
        
        for ($i = 0; $i < count($agenciesArr); $i ++) {
            Agency::firstOrCreate($agenciesArr[$i]);
        }
    }
}
