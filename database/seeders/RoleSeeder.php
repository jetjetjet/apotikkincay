<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Role::truncate();
		$role = Role::insert([
			'name'       => 'SUPER ADMIN',
			'guard_name' => 'sanctum',
			'created_at' => \Carbon\Carbon::now(),
		]);

		$user = User::find(1);
		$user->assignRole('SUPER ADMIN');

		$permissions = [
			[
				'name'       => 'dashboard',
				'guard_name' => 'sanctum',
				'action'     => ['lihat'],
			],
			[
				'name'       => 'user',
				'guard_name' => 'sanctum',
				'action'     => ['lihat', 'tambah', 'ubah', 'hapus'],
			],
			[
				'name'       => 'role',
				'guard_name' => 'sanctum',
				'action'     => ['lihat', 'tambah', 'ubah', 'hapus'],
			]
		];

		$role_first = Role::first();
		Permission::truncate();
		foreach ($permissions as $row) {
			foreach ($row['action'] as $key => $val) {
				$temp = [
					'name'       => $row['name'].'-'.$val,
					'guard_name' => $row['guard_name']
				];	
				// create permission and assign to role
				$perms = Permission::create($temp);
				$role_first->givePermissionTo($perms);
			}
		}
	}
}
