<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = new User();
    $user->name = 'Husk Admin';
    $user->email = 'admin@husk.app';
    $user->password = Hash::make('password');
    $user->save();

    $user->assignRole('Admin');
  }
}
