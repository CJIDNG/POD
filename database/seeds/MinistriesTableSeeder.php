<?php

use Illuminate\Database\Seeder;

use App\Ministry;

class MinistriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = base_path('public/assets/ministries.csv');
        $ministriesArr = Helper::csvToArray($file);
        
        for ($i = 0; $i < count($ministriesArr); $i ++) {
            Ministry::firstOrCreate($ministriesArr[$i]);
        }
    }
}
