<?php

use App\Nrna\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('nrna.permissions');
        if ($permissions) {
            foreach($permissions as $permission){
                Permission::firstOrCreate($permission);
            }
        }
    }
}
