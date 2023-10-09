<?php

namespace Database\Seeders;

use App\Models\User;
use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class SeedUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = [
            [
                'email' => 'admin@filament.example',
                'name' => 'admin',
                'password' => 'admin',
                'role' => 'super-admin',
            ]
        ];

        foreach ($superAdmin as $item) {
            $email = $item['email'];
            $role = $item['role'];
            $User = \App\Models\User::firstOrCreate(['email' => $email], [
                'name' => $item['name'],
                'email' => $email,
                'password' => Hash::make($item['password'])
            ]);
            if ($role === 'manager') {
                $User->assignRole($role);
            } else {
                Artisan::call('shield:super-admin', [
                    '--user' => $User->id,
                ]);
            }
        }

    }
}
