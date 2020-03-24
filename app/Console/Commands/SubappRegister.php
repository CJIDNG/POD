<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SubappRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subapp:register {subapp}';

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
      $subapp = $this->argument('subapp');

      $subappId = \App\Subapp::where('name', $subapp)->first()->pluck('id');

      if ($subappId) {
        $this->error('subapp exists already');
        return false;
      }

      \App\Subapp::firstOrCreate([
        'name' => $subapp
      ]);

      $this->line('subapp successfully registered');
    }
}
