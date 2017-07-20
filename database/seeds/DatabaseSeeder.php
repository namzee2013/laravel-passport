<?php

use Illuminate\Database\Seeder;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
          'role'=>'ADMIN'
        ]);
        DB::table('roles')->insert([
          'role'=>'USER'
        ]);
        $roleId = Role::where('role', 'ADMIN')->get()->first()->id;
        DB::table('users')->insert([
          'name'=>'administrator',
          'email'=>'admin@admin.com',
          'password'=>bcrypt('abcd@1234'),
          'role_id'=>$roleId
        ]);
    }
}
