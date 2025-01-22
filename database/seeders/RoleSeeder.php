<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         
        $adminRole = Role::create(['name' => 'super admin']);
        $customerRole = Role::create(['name' => 'customer']);
        $freelancerRole = Role::create(['name' => 'freelancer']);
        $user = User::find(1); // Example user with ID 1
        $user->assignRole('super admin');
    }
}
