<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Util\Subapp;

class SubappRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subapp:register {title} {--R|remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'register a new subapp e.g. php artisan subapp:register blog';

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
      $title = $this->argument('title');

      $subapp = Subapp::where('name', $title)->first();

      if ($subapp) {
        if ($is_remove = $this->option('remove')) {
          $subapp->delete();
          $this->info('subapp successfully removed');
        } else {
          $this->error('subapp exists already');
          return false;
        }
      } else {
        Subapp::firstOrCreate([
          'name' => $title
        ]);

        $this->info('subapp successfully registered');
      }
    }
}
