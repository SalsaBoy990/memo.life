<?php

namespace Database\Seeders\Auth;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manageUsers = new Permission();
        $manageUsers->name = 'Manage users';
        $manageUsers->slug = 'manage-users';
        $manageUsers->save();

        $manageAccount = new Permission();
        $manageAccount->name = 'Manage Account';
        $manageAccount->slug = 'manage-account';
        $manageAccount->save();

        $manageEvents = new Permission();
        $manageEvents->name = 'Manage Articles';
        $manageEvents->slug = 'manage-articles';
        $manageEvents->save();

        $manageRoles = new Permission();
        $manageRoles->name = 'Manage Roles';
        $manageRoles->slug = 'manage-roles';
        $manageRoles->save();

        $managePermissions = new Permission();
        $managePermissions->name = 'Manage Permissions';
        $managePermissions->slug = 'manage-permissions';
        $managePermissions->save();

        $manageGalleries = new Permission();
        $manageGalleries->name = 'Manage Galleries';
        $manageGalleries->slug = 'manage-galleries';
        $manageGalleries->save();

        $manageGoals = new Permission();
        $manageGoals->name = 'Manage Goals';
        $manageGoals->slug = 'manage-goals';
        $manageGoals->save();

        $managePhotos = new Permission();
        $managePhotos->name = 'Manage Photos';
        $managePhotos->slug = 'manage-photos';
        $managePhotos->save();

        $manageTags = new Permission();
        $manageTags->name = 'manage-tags';
        $manageTags->slug = 'manage-tags';
        $manageTags->save();

    }
}
