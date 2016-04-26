<?php

namespace App\Console\Commands;

use App\Nrna\Models\Permission;
use App\Nrna\Models\Role;
use App\Nrna\Models\User;
use Illuminate\Console\Command;

class AclSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nrna:acl-setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ACL setup';
    /**
     * @var Role
     */
    protected $role;
    /**
     * @var Permission
     */
    protected $permission;

    /**
     * Create a new command instance.
     *
     * @param Role       $role
     * @param Permission $permission
     */
    public function __construct(Role $role, Permission $permission)
    {
        parent::__construct();
        $this->role       = $role;
        $this->permission = $permission;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->setRoles();
        $this->setPermissions();
        $this->attachPermissionToRole();
        $this->attachRoleForAdmin();
    }

    /**
     * Set rolesN
     */
    protected function setRoles()
    {
        try {
            $this->line('');
            $this->warn(sprintf('Setting roles...'));

            $roles = config('nrna.roles');

            foreach ($roles as $role) {
                if (!$this->role->where('name', $role['name'])->first()) {
                    $this->warn(sprintf('Adding role: %s', $role['name']));

                    $newRole               = new Role();
                    $newRole->name         = $role['name'];
                    $newRole->display_name = $role['display_name'];
                    $newRole->description  = $role['description'];
                    $newRole->save();
                }

            }
            $this->info(sprintf('Setting roles complete...'));
        } catch (\Exception $e) {
            $this->error(sprintf($e->getMessage()));
        }
    }

    /**
     * Set permission
     */
    protected function setPermissions()
    {
        $this->line('');
        $this->warn(sprintf('Initializing permissions...'));

        $permissions = config('nrna.permissions');

        foreach ($permissions as $permission) {
            if (!$this->permission->where('name', $permission['name'])->first()) {
                $this->warn(sprintf('Adding permission: %s', $permission['name']));

                $newPermission               = new Permission();
                $newPermission->name         = $permission['name'];
                $newPermission->display_name = $permission['display_name'];
                $newPermission->description  = $permission['description'];
                $newPermission->save();
            }
        }

        $this->info(sprintf('Setting permission complete...'));
    }

    /**
     * Attach permission to role
     */
    protected function attachPermissionToRole()
    {
        $this->line('');
        $this->warn(sprintf('Initializing permissions attach to roles...'));

        $roles = $this->role->all();
        foreach ($roles as $role) {
            $this->warn(sprintf('Attaching permission to role: %s', $role['name']));
            $permissions = config('nrna.' . $role['name']);
            foreach ($permissions as $permission) {
                if (!$role->perms()->where('name', $permission)->first()) {
                    $permissionModel = $this->permission->where('name', $permission)->first();
                    $this->warn(sprintf('Attaching permission: %s', $permission));
                    $role->attachPermission($permissionModel);
                }
            }
        }


        $this->info(sprintf('Setting permission complete...'));
    }

    /**
     * Attach role as admin for default provided user
     */
    protected function attachRoleForAdmin()
    {
        $this->line('');
        $this->info(sprintf('Attach role for default admin'));
        $adminEmail = $this->ask("Enter default admin email");

        $user = User::where('email', '=', $adminEmail)->first();

        if ($user) {
            if ($user->hasRole('admin')) {
                $this->error(sprintf('%s has been already been assigned with admin role', $adminEmail));
            } else {
                $role = Role::where('name', '=', 'admin')->first();
                $user->attachRole($role);
                $this->info(sprintf('%s has been assigned with admin role', $adminEmail));
            }
        } else {
            $this->error(sprintf('No user found with the email: %s', $adminEmail));
        }
    }


}
