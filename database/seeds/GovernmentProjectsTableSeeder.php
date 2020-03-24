<?php

use Illuminate\Database\Seeder;
use App\GovernmentProject;

class GovernmentProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = base_path('public/assets/governmentProjects.csv');
        $governmentProjectsArr = Helper::csvToArray($file);
        
        for ($i = 0; $i < count($governmentProjectsArr); $i ++) {
            GovernmentProject::firstOrCreate($governmentProjectsArr[$i]);
        }
    }
}
