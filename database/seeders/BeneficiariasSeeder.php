<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeneficiariasSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            [101, 'Mariana Costa', '11122233344', 'mariana.costa@example.test', '(47) 99901-0101', '(47) 98801-0101', '1993-02-10', 'ativo', 101, 'ubs', 'Gestante acompanhada pela UBS.'],
            [102, 'Juliana Pereira', '22233344455', 'juliana.pereira@example.test', '(47) 99902-0202', '(47) 98802-0202', '1990-06-18', 'ativo', 102, 'indicacao', 'Necessita suporte para pega.'],
            [103, 'Fernanda Martins', '33344455566', 'fernanda.martins@example.test', '(47) 99903-0303', '(47) 98803-0303', '1988-11-04', 'ativo', 103, 'rede_social', 'Primeiro atendimento pos-parto.'],
            [104, 'Patricia Almeida', '44455566677', 'patricia.almeida@example.test', '(47) 99904-0404', '(47) 98804-0404', '1995-09-22', 'inativo', 104, 'evento', 'Cadastro para acompanhamento futuro.'],
            [105, 'Renata Gomes', '55566677788', 'renata.gomes@example.test', '(47) 99905-0505', '(47) 98805-0505', '1991-12-30', 'ativo', 105, 'busca_espontanea', 'Solicitou orientacao sobre ordenha.'],
        ] as [$id, $nome, $cpf, $email, $telefone, $telefoneAlternativo, $dataNascimento, $situacao, $idEndereco, $origemCadastro, $observacao]) {
            DB::table('beneficiarias')->updateOrInsert(
                ['id' => $id],
                ['nome' => $nome, 'cpf' => $cpf, 'email' => $email, 'telefone' => $telefone, 'telefone_alternativo' => $telefoneAlternativo, 'data_nascimento' => $dataNascimento, 'situacao' => $situacao, 'id_endereco' => $idEndereco, 'origem_cadastro' => $origemCadastro, 'observacao' => $observacao, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
