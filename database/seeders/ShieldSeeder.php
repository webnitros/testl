<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
class ShieldSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_failed::jobs","view_any_failed::jobs","create_failed::jobs","update_failed::jobs","restore_failed::jobs","restore_any_failed::jobs","replicate_failed::jobs","reorder_failed::jobs","delete_failed::jobs","delete_any_failed::jobs","force_delete_failed::jobs","force_delete_any_failed::jobs","view_job::batches","view_any_job::batches","create_job::batches","update_job::batches","restore_job::batches","restore_any_job::batches","replicate_job::batches","reorder_job::batches","delete_job::batches","delete_any_job::batches","force_delete_job::batches","force_delete_any_job::batches","view_jobs","view_any_jobs","create_jobs","update_jobs","restore_jobs","restore_any_jobs","replicate_jobs","reorder_jobs","delete_jobs","delete_any_jobs","force_delete_jobs","force_delete_any_jobs","view_shield::role","view_any_shield::role","create_shield::role","update_shield::role","delete_shield::role","delete_any_shield::role","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","view_waiting::jobs","view_any_waiting::jobs","create_waiting::jobs","update_waiting::jobs","restore_waiting::jobs","restore_any_waiting::jobs","replicate_waiting::jobs","reorder_waiting::jobs","delete_waiting::jobs","delete_any_waiting::jobs","force_delete_waiting::jobs","force_delete_any_waiting::jobs","page_HealthCheckResults","page_MyProfilePage","page_Themes","page_ViewLog","widget_StatsOverview"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions,true))) {

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = Utils::getRoleModel()::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name']
                ]);

                if (! blank($rolePlusPermission['permissions'])) {

                    $permissionModels = collect();

                    collect($rolePlusPermission['permissions'])
                        ->each(function ($permission) use($permissionModels) {
                            $permissionModels->push(Utils::getPermissionModel()::firstOrCreate([
                                'name' => $permission,
                                'guard_name' => 'web'
                            ]));
                        });
                    $role->syncPermissions($permissionModels);

                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions,true))) {

            foreach($permissions as $permission) {

                if (Utils::getPermissionModel()::whereName($permission)->doesntExist()) {
                    Utils::getPermissionModel()::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
