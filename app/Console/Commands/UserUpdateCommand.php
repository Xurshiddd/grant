<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UserUpdateCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'app:user-update';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Talaba malumotlarini yangilash';
    
    /**
    * Execute the console command.
    */
    public function handle()
    {
        $mutaxasisliklar = [
            '331-101' => [
                '10' => [
                    [
                        'code' => '5311000',
                        'name' => 'Texnologik jarayonlar va ishlab chiqarishni avtomatlashtirish va boshqarish'
                    ],
                    [
                        'code' => '5320300',
                        'name' => 'Texnologik mashinalar va jihozlar'
                    ],
                    [
                        'code' => '5321200',
                        'name' => 'Tabiiy tolalarni dastlabki ishlash texnologiyasi'
                    ],
                    [
                        'code' => '5321500',
                        'name' => 'Yengil sanoat texnologiyalari va jihozlari'
                    ],
                    [
                        'code' => '5322000',
                        'name' => 'Paxtani ishlab chiqarishga tayyorlash texnologiyasi'
                    ],
                    [
                        'code' => '5610600',
                        'name' => 'Xizmat ko‘rsatish texnikasi va texnologiyasi'
                    ],
                    [
                        'code' => '5640100',
                        'name' => 'Hayotiy faoliyat xavfsizligi'
                    ],
                    [
                        'code' => '5640200',
                        'name' => '	Mehnat muhofazasi va texnika xavfsizligi'
                    ],
                    [
                        'code' => '60520200',
                        'name' => 'Ekologiya va atrof-muhit muhofazasi'
                    ],
                    [
                        'code' => '60710400',
                        'name' => 'Ekologiya va atrof - muhit muhofazasi'
                    ],
                    [
                        'code' => '60710900',
                        'name' => 'Texnologik jarayonlar va ishlab chiqarishni avtomatlashtirish'
                    ],
                    [
                        'code' => '60711400',
                        'name' => 'Texnologik jarayonlar va ishlab chiqarishni avtomatlashtirish va boshqarish (tarmoqlar bo‘yicha)'
                    ],
                    [
                        'code' => '60712300',
                        'name' => '	Mexanika muhandisligi'
                    ],
                    [
                        'code' => '60720700',
                        'name' => 'Texnologik mashinalar va jihozlar'
                    ],
                    [
                        'code' => '60720700',
                        'name' => 'Yengil sanoat muhandisligi'
                    ],
                    [
                        'code' => '60721300',
                        'name' => 'Tabiiy tolalarni dastlabki ishlash texnologiyasi'
                    ],
                    [
                        'code' => '60721400',
                        'name' => 'Yengil sanoat texnologiyalari va jihozlari'
                    ],
                    [
                        'code' => '61020100',
                        'name' => 'Hayot faoliyati xavfsizligi'
                    ],
                    [
                        'code' => '61020200',
                        'name' => 'Mehnat muhofazasi va texnika xavfsizligi'
                    ],
                ],
                '11' => [
                    [
                        'code' => '70710901',
                        'name' => 'Texnologik jarayonlar va ishlab chiqarishni avtomatlashtirish'
                    ],
                    [
                        'code' => '70711401',
                        'name' => 'Texnologik jarayonlar va ishlab chiqarishni avtomatlashtirish'
                    ],
                    [
                        'code' => '70720401',
                        'name' => 'Mashinashunoslik'
                    ],
                    [
                        'code' => '70720409',
                        'name' => 'Yengil sanoat mashinalari va apparatlari'
                    ],
                    [
                        'code' => '70720411',
                        'name' => 'Paxta sanoati mashinalari va jihozlari'
                    ],
                    [
                        'code' => '70720705',
                        'name' => 'Paxtani dastlabki ishlash va urugʻ tayyorlash texnologiyasi'
                    ],
                    [
                        'code' => '70720707',
                        'name' => 'Yengil sanoat texnologiyalari va jihozlari'
                    ],
                    [
                        'code' => '70720709',
                        'name' => 'To‘qimachilik va yengil sanoat mashinalari hamda apparatlari'
                    ],
                    [
                        'code' => '70721301',
                        'name' => 'Paxtani dastlabki ishlash va urug‘ tayyorlash texnologiyasi'
                    ],
                    [
                        'code' => '70721401',
                        'name' => 'Texnologik mashinalar va jihozlarga texnik xizmat ko‘rsatish (tarmoqlar bo‘yicha)'
                    ],
                    ]
                ],
                '331-102' => [
                    '10' => [
                        [
                            'code' => '5310900',
                            'name' => 'Metrologiya, standartlashtirish va mahsulot sifati menejmenti'
                        ],
                        [
                            'code' => '5320100',
                            'name' => 'Materialshunoslik va yangi materiallar texnologiyasi (tarmoqlar bo‘yicha)'
                        ],
                        [
                            'code' => '5320400',
                            'name' => 'Kimyoviy texnologiya (to‘qimachilik sanoati)'
                        ],
                        [
                            'code' => '5320800',
                            'name' => 'Matbaa va qadoqlash jarayonlari texnologiyasi'
                        ],
                        [
                            'code' => '5320900',
                            'name' => 'Yengil sanoat buyumlari konstruksiyasini ishlash va texnologiyasi'
                        ],
                        [
                            'code' => '5321500',
                            'name' => 'Yengil sanoat texnologiyalari va jihozlari'
                        ],
                        [
                            'code' => '60710100',
                            'name' => 'Kimyo muhandisligi'
                        ],
                        [
                            'code' => '60710300',
                            'name' => 'Matbaa va qadoqlash jarayonlari texnologiyasi'
                        ],
                        [
                            'code' => '60710800',
                            'name' => 'Metrologiya va standartlashtirish'
                        ],  
                        [
                            'code' => '60711300',
                            'name' => 'Metrologiya, standartlashtirish va mahsulot sifati menejmenti'
                        ],
                        [
                            'code' => '60720300',
                            'name' => 'Materialshunoslik'
                        ],
                        [
                            'code' => '60720600',
                            'name' => 'Materialshunoslik va yangi materiallar texnologiyasi'
                        ],
                        [
                            'code' => '60720700',
                            'name' => 'Yengil sanoat muhandisligi'
                        ],
                        [
                            'code' => '60721200',
                            'name' => 'Yengil sanoat buyumlari konstruksiyasini ishlash va texnologiyasi'
                        ],
                    ],
                    '11' => [
                        [
                            'code' => '70710101',
                            'name' => 'Kimyoviy texnologiya'
                        ],
                        [
                            'code' => '70710301',
                            'name' => 'Matbaa va qadoqlash texnologiyasi'
                        ],
                        [
                            'code' => '70710802',
                            'name' => 'Metrologiya, standartlashtirish va sifatni boshqarish'
                        ],
                        [
                            'code' => '70711302',
                            'name' => 'Metrologiya, standartlashtirish va sifatni boshqarish (tarmoqlar bo‘yicha)'
                        ],
                        [
                            'code' => '70720301',
                            'name' => 'Materialshunoslik va materiallar texnologiyasi'
                        ],
                        [
                            'code' => '70720701',
                            'name' => 'Toʻqimachilik mahsulotlari texnologiyasi'
                        ],
                        [
                            'code' => '70720702',
                            'name' => 'Toʻqimachilik sanoati buyumlarini badiiy loyihalash'
                        ],
                        [
                            'code' => '70721201',
                            'name' => 'To‘qimachilik mahsulotlari texnologiyasi'
                        ],
                        [
                            'code' => '70721202',
                            'name' => 'To‘qimachilik sanoati buyumlarini badiiy loyihalash'
                        ],
                        ]
                    ],
                    '331-103'=>[
                        '10' => [
                            [
                                'code' => '5111000',
                                'name' => 'Kasb ta’limi : Yengil sanoat buyumlari konstruksiyasini ishlash va texnologiyasi'
                            ],
                            [
                                'code' => '5150900',
                                'name' => 'Dizayn'
                            ],
                            [
                                'code' => '5320900',
                                'name' => 'Yengil sanoat buyumlari konstruksiyasini ishlash va texnologiyasi'
                            ],
                            [
                                'code' => '5321500',
                                'name' => 'Yengil sanoat texnologiyalari va jihozlari '
                            ],
                            [
                                'code' => '60210400',
                                'name' => 'Dizayn'
                            ],
                            [
                                'code' => '60720700',
                                'name' => 'Yengil sanoat muhandisligi'
                            ],
                            [
                                'code' => '60721200',
                                'name' => 'Yengil sanoat buyumlari konstruksiyasini ishlash va texnologiyasi'
                            ],
                        ],
                        '11' => [
                            [
                                'code' => '5A320902',
                                'name' => 'Tikuv buyumlari texnologiyasi va konstruksiyasini ishlash'
                            ],
                            [
                                'code' => '70210401',
                                'name' => 'Dizayn'
                            ],
                            [
                                'code' => '70720704',
                                'name' => 'Tikuv buyumlari texnologiyasi va konstruksiyasini ishlash'
                            ],
                            [
                                'code' => '70720707',
                                'name' => 'Yengil sanoat texnologiyalari va jihozlari'
                            ],
                            [
                                'code' => '70721403',
                                'name' => 'Yengil sanoat mahsulotlari texnologiyasi va jihozlari'
                            ],
                            ]
                        ],
                        '331-104' => [
                            '10' => [
                                [
                                    'code' => '5230100',
                                    'name' => 'Iqtisodiyot'
                                ],
                                [
                                    'code' => '5230400',
                                    'name' => 'Marketing'
                                ],
                                [
                                    'code' => '5230900',
                                    'name' => 'Buxgalteriya hisobi va audit'
                                ],
                                [
                                    'code' => '5231900',
                                    'name' => 'Korporativ boshqaruv'
                                ],
                                [
                                    'code' => '5232900',
                                    'name' => 'Ishlab chiqarishni tashkil etish va boshqarish'
                                ],
                                [
                                    'code' => '60310100',
                                    'name' => 'Iqtisodiyot'
                                ],
                                [
                                    'code' => '60410100',
                                    'name' => 'Iqtisodiyot'
                                ],
                                [
                                    'code' => '60410200',
                                    'name' => 'Buxgalteriya hisobi'
                                ],
                                [
                                    'code' => '60410800',
                                    'name' => 'Menejment'
                                ],
                                [
                                    'code' => '60410900',
                                    'name' => 'Biznesni boshqarish'
                                ],
                                [
                                    'code' => '60411200',
                                    'name' => 'Marketing'
                                ],
                                [
                                    'code' => '60412500',
                                    'name' => 'Marketing (tarmoqlar va sohalar bo‘yicha)'
                                ],
                                [
                                    'code' => '61010400',
                                    'name' => 'Logistika'
                                ],
                            ],
                            '11' => [
                                [
                                    'code' => '70410102',
                                    'name' => 'Iqtisodiyot'
                                ],
                                [
                                    'code' => '70410201',
                                    'name' => 'Buxgalteriya hisobi'
                                ],
                                [
                                    'code' => '70411201',
                                    'name' => 'Marketing'
                                ],
                                [
                                    'code' => '70412501',
                                    'name' => 'Marketing'
                                    ]
                                    ]
                                    ]
                                ];
                                $data = [
                                    '331-101' => [
                                        'codes' => ['60520200', '60710900', '60710900', '60712300', '60712300', '60720700', '60720700', '61020100', '61020200', '61020200', '61020200', '61020200', '60721300', '60721300', '60710400', '60710400', '60711400', '60711400', '60721400', '60721400', '60721400', '60711400', '60720700', '60720700', '60720700', '60721300', '61020200', '61020200', '60710400', '60711400', '60711400', '60720700', '60720700', '60720700', '60721300', '60721300', '61020200', '61020200'],
                                        'groups' => ['19-24', '22-24', '22a-24', '3-24', '3a-24', '1-24', '2-24', '31-24', '24-24', '24a-24', '24-23', '24a-23', '1-23', '1a-23', '29-23', '29a-23', '22-23', '22a-23', '2-23', '3-23', '3r-23', '22-22', '3a-22', '3b-22', '3r-22', '1-22', '24-22', '24a-23', '29-22', '22-21', '22r-21', '3a-21', '3b-21', '3r-21', '1-21', '1r-21', '24-21', '24r-21']
                                    ],
                                    '331-102' => [
                                        'groups' => ['9-24', '16-24', '16r-24', '8-24', '8r-24', '28-24', '4-24', '5-24', '6-24', '7-24', '15-23', '5-23', '5r-23', '6-23', '6r-23', '9-23', '9a-23', '16-23', '7-23', '7r-23', '23-23', '8-23', '8a-23', '8r-23', '17-23', '21-22', '9-22', '9a-22', '9r-22', '16-22', '16r-22', '8-22', '8r-22', '17-22', '7-22', '7r-22', '5-22', '5a-23', '6-2', '6r-22', '4-22', '4r-22', '15-22', '23-22', '16-21', '16r-21', '21-21', '9-21', '9r-21', '8-21', '8a-21', '8r-21', '17-21', '7-21', '5-21', '6-21', '6r-21', '4-21', '4a-21'],
                                        'codes' => ['60710100', '60710300', '60710300', '60710800', '60710800', '60720300', '60720700', '60720700', '60720700', '60720700', '60721200', '60721200', '60721200', '60721200', '60721200', '60710100', '60710100', '60710300', '60721200', '60721200', '60721200', '60711300', '60711300', '60711300', '60720600', '60710100', '60710100', '60710100', '60710100', '60710300', '60710300', '60711300', '60711300', '60720600', '60721200', '60721200', '60721200', '60721200', '60721200', '60721200', '60721200', '60721200', '60721200', '60721200', '60710300', '60710300', '60710100', '60710100', '60710100', '60711300', '60711300', '60711300', '60720600', '60721200', '60721200', '60721200', '60721200', '60721200', '60721200'] 
                                    ],
                                    '331-103' => [
                                        'groups' => ['10-24', '10r-24', '30-24', '12-20-24', '25-24', '25a-24', '25b-24', '25r-24', '35-24', '27-24', '18-24', '25-23', '25a-23', '25b-23', '25r-23', '27-23', '26a-23', '18-23', '18a-23', '10-23', '10r-23', '26-23', '11-23', '11a-23', '12-20-23', '20r-23', '30-23', '30r-23', '25-22', '25a-22', '25r-22', '27-22', '27r-22', '10-22', '10r-22', '12-20-22', '30-22', '26a-22', '26-22', '18-22', '25-21', '25a-21', '25r-21', '27-21', '10-21', '10a-21', '10r-21', '11-21', '10-20-21', '30-21', '30r-21', '26a-21', '26ar-21', '26-21'],
                                        'codes' => ['60720700', '60720700', '60720700', '60720700', '60210400', '60210400', '60210400', '60210400', '60210400', '60210400', '60720700', '60210400', '60210400', '60210400', '60210400', '60210400', '60721400', '60721400', '60721400', '60721200', '60721200', '60721400', '60721200', '60721200', '60721200', '60721200', '60721200', '60721200', '60210400', '60210400', '60210400', '60210400', '60210400', '60721200', '60721200', '60721200', '60721200', '60721400', '60721400', '60721400', '60210400', '60210400', '60210400', '60210400', '60721200', '60721200', '60721200', '60721200', '60721200', '60721200', '60721200', '60721400', '60721400', '60721400']
                                    ],
                                    '331-104' => [
                                        'groups' => ['13-24', '13a-24', '13b-24', '13v-24', '13r-24', '14-24', '14a-24', '14b-24', '14v-24', '14r-24', '32-24', '33-24', '19-24', '19a-24', '19b-24', '19v-24', '19r-24', '34-24', '13-23', '13a-23', '13b-23', '13v-23', '13g-23', '13r-23', '14-23', '14a-23', '14b-23', '14v-23', '14g-23', '14r-23', '19-23', '19a-23', '19b-23', '19v-23', '19g-23', '19r-23', '13-22', '13a-22', '13r-22', '14-22', '14r-22', '19-22', '19r-22', '13-21', '13a-21', '13r-21', '14-21', '14r-21', '19-21'],
                                        'codes' => ['60410100', '60410100', '60410100', '60410100', '60410100', '60410200', '60410200', '60410200', '60410200', '60410200', '60410800', '60410900', '60411200', '60411200', '60411200', '60411200', '60411200', '61010400', '60310100', '60310100', '60310100', '60310100', '60310100', '60310100', '60410100', '60410100', '60410100', '60410100', '60410100', '60410100', '60412500', '60412500', '60412500', '60412500', '60412500', '60412500', '60310100', '60310100', '60310100', '60410100', '60410100', '60412500', '60412500', '60310100', '60310100', '60310100', '60410100', '60410100', '60412500']
                                    ],
                                ];
                                foreach ($data as $facultyCode => $info) {
                                    $groups = $info['groups'];
                                    $codes = $info['codes'];
                                    $this->info('qoshildi');
                                    foreach ($groups as $index => $groupName) {
                                        $directionCode = $codes[$index] ?? null;
                                        
                                        if ($directionCode) {
                                            DB::table('users')
                                            ->where('faculity', $facultyCode)
                                            ->where('group_name', $groupName)
                                            ->update(['education_direction_code' => $directionCode]);
                                        }
                                    }
                                }
                                
                            }
                        }
                        