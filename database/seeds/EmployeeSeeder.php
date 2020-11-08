<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'name' => "Funcinário 172",
            'role' => "Estagiário",
            'email' => "employee@simsave.com.br",
            'phone_number' => "3723-9909",
            'admission_date' => "2018-05-31",
            'company_id' => 1
        ]);
    }
}
