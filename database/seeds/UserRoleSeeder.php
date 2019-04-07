<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    protected $roles = ['administrator', 'production', 'logistic'];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $r) {
            Role::create(['name' => $r]); 
        }

        for ($i=1; $i < 4; $i++) { 
            $user = \App\User::find($i);
            $user->assignRole($this->roles[$i-1]);
        }
    }
}