<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SubappAdd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'subapp:add {fqdn} {subapp}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'add subapp to tenant with the provided fqdn e.g. php artisan subapp:add example.com blog';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $fqdn = $this->argument('fqdn');
    $subapp = $this->argument('subapp');

    // set up platform subapps
    $platform = \App\Platform::where('name', $fqdn)->first();

    if (!$platform) {
      $this->error('unrecognised platform');
      return false;
    }

    $subappId = \App\Subapp::where('name', $subapp)->get(['id'])->pluck('id');

    if (!$subappId) {
      $this->error('unrecognised subapp');
      return false;
    }

    $platform->subapps()->attach($subappId);

    $this->line('subapp successfully added');
  }
}
