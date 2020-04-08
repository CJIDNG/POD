<?php

use Illuminate\Foundation\Inspiring;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Environment;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

function csvToArray($filename = '', $delimiter = ',') {
  if (!file_exists($filename) || !is_readable($filename))
    return false;
  $data = array();
  if (($handle = fopen($filename, 'r')) !== false)
  {
    while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
    {
      array_push($data, $row);
    }
    fclose($handle);
  }
  return $data;
}

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('upload', function (
  Environment $environment,
  HostnameRepository $hostnameRepo
) {
  $query = $hostnameRepo->query();
  $hostname = $hostnameRepo->query()->where('fqdn', 'bodyofbenchers.org')->first();
  $website = $hostname->website;

  $environment->tenant($website);

  $designations = csvToArray('designations.csv');

  foreach ($designations as $designation) {
    \App\Designation::updateOrInsert(
      ['id' => $designation[0]],
      ['title' => $designation[1]]
    );
  }

  $this->comment('designations done!');

  $members = csvToArray('members.csv');
  
  foreach ($members as $member) {
    \App\Member::updateOrInsert(
      ['id' => $member[0]],
      [
        'name' => $member[1],
        'bio' => $member[3]
      ]
    );
  }

  $this->comment('members done!');

  $designationMembers = csvToArray('designation_member.csv');

  foreach ($designationMembers as $dm) {
    \App\DesignationMember::updateOrInsert(
      ['id' => $dm[0]],
      [
        'designation_id' => $dm[1],
        'member_id' => $dm[2]
      ]
    );
  }

  $this->comment('members done!');
  
})->describe('This uploads');
