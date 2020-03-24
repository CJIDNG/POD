<?php

use Illuminate\Database\Seeder;

use App\State;
use App\LocalGovernment;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = base_path('public/assets/states.csv');
        $statesArr = Helper::csvToArray($file);
        
        for ($i = 0; $i < count($statesArr); $i ++) {
            State::firstOrCreate($statesArr[$i]);
        }

        $file = base_path('public/assets/local_governments.csv');
        $lgArr = Helper::csvToArray($file);

        for ($i = 0; $i < count($lgArr); $i ++) {
            LocalGovernment::firstOrCreate($lgArr[$i]);
        }
    }
}
