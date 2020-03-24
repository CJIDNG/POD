<?php

namespace App\Console\Commands;

use App\Platform;
use Hyn\Tenancy\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Helpers\Tenant;

class TenantInstall extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'tenant:install {fqdn}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'install tenant with the provided fqdn e.g. php artisan tenant:install example.com';

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

    $this->line("Checking if platform is already installed...");

    if (Tenant::platformExists($fqdn)) {
      $this->error("platform already installed...manually clean out the db before trying again");
      return;
    }

    session()->put('platform_name', $fqdn);

    $this->line("Creating website...");
    $website = Tenant::createWebsite();
    $this->info("website created!");

    $this->line("Creating hostname...");
    $hostname = Tenant::createHostname($fqdn);
    $this->info("Hostname create!");
    
    $this->line("Connecting hostname to website...");
    Tenant::connectHostnameToWebsite($hostname, $website);
    $this->info("hostname connected to website");

    $this->line("Switching to new website...");
    Tenant::switchToNewWebsite($website);
    $this->info("successfully switched to new website!");

    $this->line("Creating platform...");
    // create related platform
    Platform::create([
      'name' => $fqdn,
      'website_id' => $website->id,
    ]);
    $this->info("platform created!");

    $this->line("Calling db:seed...");

    Artisan::call('db:seed');

    $this->info("db:seeded!");

    $this->info("Forgetting session...");
    session()->forget('platform_name');

    $this->info("Website is created and is now accessible at {$hostname->fqdn}");
  }
}
