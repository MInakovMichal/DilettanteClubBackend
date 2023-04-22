<?php

namespace Database\Seeders;

use Common\ValueObject\RoleValueObject;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = RoleValueObject::available();

        foreach ($roles as $role) {
            Role::firstOrNew(['name' => $role])->save();
        }
    }
}
