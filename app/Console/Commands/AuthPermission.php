<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use App\Model\Auth\Permission;
use App\Model\Auth\Role;

class AuthPermission extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'auth:permission {name} {--R|remove}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'add crud permissions e.g. php artisan permission:add posts {--R|remove}';

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
  public function handle(Environment $environment, WebsiteRepository $repository)
  {
    $query = $repository->query();

    $permissions = $this->generatePermissions();

    $query->chunk(50, function ($websites) use ($environment, $permissions) {
      foreach ($websites as $website) {
        $environment->tenant($website);

        // check if its remove
        if( $is_remove = $this->option('remove') ) {
          // remove permission
          if( Permission::where('name', 'LIKE', '%'. $this->getNameArgument())->delete() ) {
            $this->warn('Permissions ' . implode(', ', $permissions) . ' deleted.');
          }  else {
            $this->warn('No permissions for ' . $this->getNameArgument() .' found!');
          }
        } else {
          // create permissions
          foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission ]);
          }

          $this->info('Permissions ' . implode(', ', $permissions) . ' created.');
        }

        // sync role for admin
        if( $role = Role::where('name', 'Admin')->first() ) {
          $role->syncPermissions(Permission::all());
          $this->info('Admin permissions');
        }
      }
    });
  }

  private function generatePermissions()
  {
    $abilities = ['view', 'create', 'update', 'delete'];
    $name = $this->getNameArgument();

    return array_map(function($val) use ($name) {
        return $val . '_'. $name;
    }, $abilities);
  }
  
  private function getNameArgument()
  {
    return strtolower(Str::plural($this->argument('name')));
  }
}
