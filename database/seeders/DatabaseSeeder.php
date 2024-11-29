<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $company = Company::create([
            'name' => 'Amerck',
            'address' => 'Stafford Ave',
            'email' => 'hello@amerck.com',
            'phone' => '+94111234567'
        ]);

        $superAdmin = User::create([
            'company_id' => $company->id,
            'name' => 'Super Admin',
            'role' => 'Super Admin',
            'email' => 'superadmin@amerck.com',
            'password' => Hash::make('superadmin@amerck.com')
        ]);
    }
}