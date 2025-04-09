<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unidade;

class UnidadeSeeder extends Seeder {

    public function run(): void
    {
        Unidade::insert([
            [
                'unid_nome' => 'Secretaria Municipal de Educação',
                'unid_sigla' => 'SME'
            ],
            [
                'unid_nome' => 'Secretaria Municipal de Saúde',
                'unid_sigla' => 'SMS'
            ],
            [
                'unid_nome' => 'Secretaria de Assistência Social',
                'unid_sigla' => 'SAS'
            ]
        ]);
    }
}
