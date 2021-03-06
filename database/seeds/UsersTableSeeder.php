<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
      	[

          'name'      => 'mr. yogesh sharma',
          'email'     => 'admin@laxyo.in',
          'password'  => bcrypt('12345678'),
          'remember_token'  => '',
          'deleted_at'=> '',
          'created_at'=> now(),
        ]
      ]);

      DB::table('emp_mast')->insert([
        [
          'id'        => 1,
          'status'    => 0,
          'user_id'   => 1,
          'role_id'   => 1 ,
          'emp_name'  => 'mr. yogesh sharma',
          'email'     => 'admin@laxyo.in',
          'status'    => 0,
          'created_at'=> now(),
        ]
      ]);

      DB::table('roles')->insert([
        [
          'id'          => 1,
          'name'        => 'hrms_admin',
          'display_name'=> 'Hrms Admin',
          'descrition'  => 'Admin for hrms module',
        ]
      ]);

      DB::table('role_user')->insert([
        [
          'role_id'    => 1,
          'user_id'    => 1,
          'user_type'  => 'App\User',
        ]
      ]);
      	/*[
            'name' => 'Ayush Likhar',
            'email' => 'alikhar@laxyo.in',
            'password' => bcrypt('laxyo123'),
            'emp_id' => 6,
            'created_at' => now(),
            'updated_at' => now()
        ],
      	[
            'name' => 'HS Sir',
            'email' => 'hsir@laxyo.in',
            'password' => bcrypt('laxyo123'),
            'emp_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ],
      	[
            'name' => 'HR- user',
            'email' => 'hr@laxyo.in',
            'password' => bcrypt('laxyo123'),
            'emp_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ],
      	[
            'name' => 'TL comp 1',
            'email' => 'tl1@laxyo.in',
            'password' => bcrypt('laxyo123'),
            'emp_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ],
      	[
            'name' => 'TL comp 2',
            'email' => 'tl2@laxyo.in',
            'password' => bcrypt('laxyo123'),
            'emp_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]*/
    	
    }
}
