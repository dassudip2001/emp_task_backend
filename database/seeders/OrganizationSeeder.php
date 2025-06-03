<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = new Organization();
        $organization->name = 'Organization 1';

        $organization->userId = 1;
        $organization->save();
    }
}
