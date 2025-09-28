<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        // Zerar a tabela de produtos antes de inserir os novos dados
        DB::table('produtos')->truncate();
        
        $produtos = [
            ['nome' => 'Homeopático Belladonna 30CH', 'preco' => 45.90, 'estoque' => 50, 'ncm' => '30039019', 'observacao' => 'Para febre e inflamações em bovinos', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Arnica Montana 12CH', 'preco' => 35.90, 'estoque' => 75, 'ncm' => '30039019', 'observacao' => 'Trauma, hematomas e recuperação pós-parto', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Nux Vomica 6CH', 'preco' => 38.90, 'estoque' => 60, 'ncm' => '30039019', 'observacao' => 'Distúrbios digestivos e intoxicações', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Respiratório', 'preco' => 89.90, 'estoque' => 40, 'ncm' => '30039019', 'observacao' => 'Pneumonia, tosse e problemas respiratórios', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Phosphorus 30CH', 'preco' => 42.90, 'estoque' => 55, 'ncm' => '30039019', 'observacao' => 'Hemorragias e problemas hepáticos', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Calcarea Carbonica 12CH', 'preco' => 41.90, 'estoque' => 65, 'ncm' => '30039019', 'observacao' => 'Deficiências minerais e crescimento', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Mastite', 'preco' => 95.90, 'estoque' => 35, 'ncm' => '30039019', 'observacao' => 'Tratamento e prevenção de mastite', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Sepia 30CH', 'preco' => 44.90, 'estoque' => 45, 'ncm' => '30039019', 'observacao' => 'Problemas reprodutivos em fêmeas', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Lycopodium 12CH', 'preco' => 39.90, 'estoque' => 70, 'ncm' => '30039019', 'observacao' => 'Distúrbios digestivos e flatulência', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Stress', 'preco' => 78.90, 'estoque' => 30, 'ncm' => '30039019', 'observacao' => 'Reduz stress no manejo e transporte', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Sulphur 6CH', 'preco' => 37.90, 'estoque' => 80, 'ncm' => '30039019', 'observacao' => 'Problemas de pele e parasitas', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Carbo Vegetabilis 12CH', 'preco' => 40.90, 'estoque' => 50, 'ncm' => '30039019', 'observacao' => 'Debilidade e problemas circulatórios', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Reprodutivo', 'preco' => 105.90, 'estoque' => 25, 'ncm' => '30039019', 'observacao' => 'Fertilidade e problemas reprodutivos', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Pulsatilla 30CH', 'preco' => 43.90, 'estoque' => 55, 'ncm' => '30039019', 'observacao' => 'Problemas oculares e respiratórios', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Mercurius Solubilis 12CH', 'preco' => 46.90, 'estoque' => 40, 'ncm' => '30039019', 'observacao' => 'Infecções e processos supurativos', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Carrapaticida', 'preco' => 112.90, 'estoque' => 20, 'ncm' => '30039019', 'observacao' => 'Controle natural de carrapatos', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Apis Mellifica 30CH', 'preco' => 41.90, 'estoque' => 60, 'ncm' => '30039019', 'observacao' => 'Edemas e picadas de insetos', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Rhus Toxicodendron 12CH', 'preco' => 38.90, 'estoque' => 65, 'ncm' => '30039019', 'observacao' => 'Problemas articulares e reumatismo', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Digestivo', 'preco' => 85.90, 'estoque' => 35, 'ncm' => '30039019', 'observacao' => 'Diarreia, cólicas e indigestão', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Hepar Sulphuris 30CH', 'preco' => 44.90, 'estoque' => 45, 'ncm' => '30039019', 'observacao' => 'Abcessos e infecções purulentas', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Arsenicum Album 12CH', 'preco' => 42.90, 'estoque' => 55, 'ncm' => '30039019', 'observacao' => 'Diarreia aquosa e debilidade', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Imunológico', 'preco' => 98.90, 'estoque' => 30, 'ncm' => '30039019', 'observacao' => 'Fortalece o sistema imunológico', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Natrum Muriaticum 30CH', 'preco' => 40.90, 'estoque' => 70, 'ncm' => '30039019', 'observacao' => 'Deficiências de sal e depressão', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Bryonia Alba 12CH', 'preco' => 39.90, 'estoque' => 50, 'ncm' => '30039019', 'observacao' => 'Inflamações das serosas', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Hepático', 'preco' => 92.90, 'estoque' => 25, 'ncm' => '30039019', 'observacao' => 'Problemas hepáticos e intoxicações', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Silicea 30CH', 'preco' => 43.90, 'estoque' => 40, 'ncm' => '30039019', 'observacao' => 'Cicatrização e expulsão de corpos estranhos', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Chamomilla 12CH', 'preco' => 37.90, 'estoque' => 75, 'ncm' => '30039019', 'observacao' => 'Irritabilidade e cólicas', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Podal', 'preco' => 88.90, 'estoque' => 30, 'ncm' => '30039019', 'observacao' => 'Problemas de casco e claudicação', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático China 30CH', 'preco' => 41.90, 'estoque' => 60, 'ncm' => '30039019', 'observacao' => 'Debilidade por perda de fluidos', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Cantharis 12CH', 'preco' => 45.90, 'estoque' => 35, 'ncm' => '30039019', 'observacao' => 'Cistites e problemas urinários', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Vermífugo', 'preco' => 115.90, 'estoque' => 20, 'ncm' => '30039019', 'observacao' => 'Controle natural de verminose', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Ignatia 30CH', 'preco' => 42.90, 'estoque' => 45, 'ncm' => '30039019', 'observacao' => 'Stress emocional e mudanças', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Causticum 12CH', 'preco' => 44.90, 'estoque' => 50, 'ncm' => '30039019', 'observacao' => 'Paralisia e fraqueza muscular', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Ocular', 'preco' => 79.90, 'estoque' => 25, 'ncm' => '30039019', 'observacao' => 'Conjuntivite e problemas oculares', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Coffea Cruda 30CH', 'preco' => 38.90, 'estoque' => 65, 'ncm' => '30039019', 'observacao' => 'Excitação nervosa e insônia', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Ruta Graveolens 12CH', 'preco' => 40.90, 'estoque' => 55, 'ncm' => '30039019', 'observacao' => 'Lesões em tendões e ligamentos', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Dermatológico', 'preco' => 94.90, 'estoque' => 30, 'ncm' => '30039019', 'observacao' => 'Eczemas e dermatites', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Alumina 30CH', 'preco' => 43.90, 'estoque' => 40, 'ncm' => '30039019', 'observacao' => 'Constipação e paralisia', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Veratrum Album 12CH', 'preco' => 46.90, 'estoque' => 35, 'ncm' => '30039019', 'observacao' => 'Diarreia profusa e colapso', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Metrite', 'preco' => 108.90, 'estoque' => 18, 'ncm' => '30039019', 'observacao' => 'Infecções uterinas pós-parto', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Kali Carbonicum 30CH', 'preco' => 42.90, 'estoque' => 50, 'ncm' => '30039019', 'observacao' => 'Fraqueza e problemas respiratórios', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Lachesis 12CH', 'preco' => 48.90, 'estoque' => 30, 'ncm' => '30039019', 'observacao' => 'Septicemia e feridas infectadas', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Antitoxico', 'preco' => 102.90, 'estoque' => 22, 'ncm' => '30039019', 'observacao' => 'Intoxicações alimentares e químicas', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Aconitum Napellus 30CH', 'preco' => 41.90, 'estoque' => 60, 'ncm' => '30039019', 'observacao' => 'Febre súbita e sustos', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Gelsemium 12CH', 'preco' => 43.90, 'estoque' => 45, 'ncm' => '30039019', 'observacao' => 'Paralisia e tremores', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Neurológico', 'preco' => 96.90, 'estoque' => 25, 'ncm' => '30039019', 'observacao' => 'Distúrbios nervosos e convulsões', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Staphysagria 30CH', 'preco' => 44.90, 'estoque' => 40, 'ncm' => '30039019', 'observacao' => 'Feridas cortantes e cistites', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Hypericum 12CH', 'preco' => 39.90, 'estoque' => 70, 'ncm' => '30039019', 'observacao' => 'Lesões em nervos e feridas', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Complexo Homeopático Oftálmico', 'preco' => 82.90, 'estoque' => 28, 'ncm' => '30039019', 'observacao' => 'Úlceras de córnea e ceratites', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Thuja Occidentalis 30CH', 'preco' => 45.90, 'estoque' => 35, 'ncm' => '30039019', 'observacao' => 'Verrugas e tumores benignos', 'solucao' => 'Homeopatia Veterinária'],
            ['nome' => 'Homeopático Ipecacuanha 12CH', 'preco' => 41.90, 'estoque' => 55, 'ncm' => '30039019', 'observacao' => 'Náuseas e vômitos persistentes', 'solucao' => 'Homeopatia Veterinária']
        ];

        foreach ($produtos as $produto) {
            DB::table('produtos')->insert([
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'estoque' => $produto['estoque'],
                'ncm' => $produto['ncm'],
                'observacao' => $produto['observacao'],
                'solucao' => $produto['solucao'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
