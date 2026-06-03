<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::factory()->count(4)->sequence(
            ['name' => 'Sembark Tech Private Limited'],
            ['name' => 'Todquest Enterprises Private Limited'],
            ['name' => 'Webkul Software Private Limited'],
            ['name' => 'Incapp Technologies Private Limited'],
        )->create();
    }
}