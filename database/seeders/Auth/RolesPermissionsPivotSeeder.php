<?php

namespace Database\Seeders\Auth;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesPermissionsPivotSeeder extends Seeder
{
    /**
     * Get the permission entity by the slug value
     *
     * @param  string  $slug
     *
     * @return Permission|null
     */
    protected function getPermissionBySlug(string $slug): ?Permission
    {
        return Permission::where('slug', $slug)->firstOrFail();
    }


    /**
     * Get the role entity by the slug value
     *
     * @param  string  $slug
     *
     * @return Role|null
     */
    protected function getRoleBySlug(string $slug): ?Role
    {
        return Role::where('slug', $slug)->firstOrFail();
    }


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission ids
        $account = $this->getPermissionBySlug('manage-account')->id;
        $users = $this->getPermissionBySlug('manage-users')->id;
        $roles = $this->getPermissionBySlug('manage-roles')->id;
        $permissions = $this->getPermissionBySlug('manage-permissions')->id;

        $galleries = $this->getPermissionBySlug('manage-galleries')->id;
        $goals = $this->getPermissionBySlug('manage-goals')->id;
        $photos = $this->getPermissionBySlug('manage-photos')->id;
        $tags = $this->getPermissionBySlug('manage-tags')->id;


        // Add permissions to the superadmin
        $admin = $this->getRoleBySlug('super-administrator');
        $admin->permissions()->sync([$account, $users, $roles, $permissions, $galleries, $goals, $photos, $tags]);

        // Add permissions to the admin
        $admin2 = $this->getRoleBySlug('administrator');
        $admin2->permissions()->sync([$account, $users, $galleries, $goals, $photos, $tags]);

        // Add permissions to the admin
        $customer = $this->getRoleBySlug('customer');
        $customer->permissions()->sync([$account, $galleries, $goals, $photos, $tags]);

    }
}
