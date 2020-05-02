<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Util\Subapp;
use App\Model\Settings\Platform;

class TenantSubapp extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'tenant:subapp {fqdn} {subapp} {--R|remove}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'add subapp to tenant with the provided fqdn e.g. php artisan tenant:subapp example.com blog';

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
    $platform = Platform::where('name', $fqdn)->first();

    if (!$platform) {
      $this->error('unrecognised platform');
      return false;
    }

    $subappId = Subapp::where('name', $subapp)->get(['id'])->pluck('id');

    if (!$subappId) {
      $this->error('unrecognised subapp');
      return false;
    }

    // check if its remove
    if( $is_remove = $this->option('remove') ) {
      $platform->subapps()->detach($subappId);
      $this->info('subapp successfully removed');
    } else {
      $platform->subapps()->attach($subappId);
      $this->info('subapp successfully added');
    }
  }
}
