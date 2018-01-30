<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role=new Role();
        $admin_role->name="Admin";
        $admin_role->description="Admin Role";
        $admin_role->save();

        $user_role= new Role();
        $user_role->name="User";
        $user_role->description="User role";
        $user_role->save();


    }
}
