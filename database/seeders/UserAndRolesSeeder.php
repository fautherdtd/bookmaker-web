<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['guard_name' => 'web', 'name' => 'user']);
        Role::create(['guard_name' => 'web', 'name' => 'administrator']);
        $user = User::create([
            'name' => 'Ivan Ivanov',
            'email' => 'admin@test.ru',
            'password' => Hash::make(getenv('ADMIN_SEED_PASSWORD')),
        ]);
        $user->assignRole('administrator');
    }
}
