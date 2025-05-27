<?php

namespace Database\Seeders;

use App\DTOs\RoleDto;
use App\Services\RoleService;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin' => 'Administrator',
            'editor' => 'Editor',
            'viewer' => 'Viewer',
        ];

        $roleService = app(RoleService::class);

        try {
            foreach ($roles as $name => $nickname) {

                $roleDto = RoleDto::fromArray(['name' => $name, 'nickname' => $nickname]);

                $roleService->create($roleDto);
            }
        } catch (\Exception $e) {
            echo "Error seeding roles: " . $e->getMessage() . "\n";
        }

    }
}
