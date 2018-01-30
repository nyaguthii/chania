<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_role=Role::where('name','User')->first();
        $admin_role=Role::where('name','Admin')->first();

        $user=new User();
        $user->name="User";
        $user->email="user@chania.com";
        $user->password=bcrypt('user123');
        $user->save();
        $user->roles()->attach($user_role);

        $admin=new User();
        $admin->name="Admin";
        $admin->email="admin@chania.com";
        $admin->password=bcrypt('admin123');
        $admin->save();
        $admin->roles()->attach($admin_role);
    }
}
