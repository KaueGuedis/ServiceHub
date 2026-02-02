<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Project;

class CompanyProjectSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::create(['name' => 'Empresa Exemplo']);
        Project::create(['name' => 'Projeto Alpha', 'company_id' => $company->id]);
        Project::create(['name' => 'Projeto Beta', 'company_id' => $company->id]);
    }
}
