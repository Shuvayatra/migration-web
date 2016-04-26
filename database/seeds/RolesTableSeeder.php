<?php

use App\Nrna\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = config('nrna.roles');
        if ($roles) {
            foreach($roles as $role){
                Role::firstOrCreate($role);
            }
        }
    }
}
