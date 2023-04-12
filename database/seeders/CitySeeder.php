<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            0 => [
                'id' => 1,
                'city_name' => 'Adana',
            ],
            1 => [
                'id' => 2,
                'city_name' => 'Adıyaman',
            ],
            2 => [
                'id' => 3,
                'city_name' => 'Afyonkarahisar',
            ],
            3 => [
                'id' => 4,
                'city_name' => 'Ağrı',
            ],
            4 => [
                'id' => 5,
                'city_name' => 'Amasya',
            ],
            5 => [
                'id' => 6,
                'city_name' => 'Ankara',
            ],
            6 => [
                'id' => 7,
                'city_name' => 'Antalya',
            ],
            7 => [
                'id' => 8,
                'city_name' => 'Artvin',
            ],
            8 => [
                'id' => 9,
                'city_name' => 'Aydın',
            ],
            9 => [
                'id' => 10,
                'city_name' => 'Balıkesir',
            ],
            10 => [
                'id' => 11,
                'city_name' => 'Bilecik',
            ],
            11 => [
                'id' => 12,
                'city_name' => 'Bingöl',
            ],
            12 => [
                'id' => 13,
                'city_name' => 'Bitlis',
            ],
            13 => [
                'id' => 14,
                'city_name' => 'Bolu',
            ],
            14 => [
                'id' => 15,
                'city_name' => 'Burdur',
            ],
            15 => [
                'id' => 16,
                'city_name' => 'Bursa',
            ],
            16 => [
                'id' => 17,
                'city_name' => 'Çanakkale',
            ],
            17 => [
                'id' => 18,
                'city_name' => 'Çankırı',
            ],
            18 => [
                'id' => 19,
                'city_name' => 'Çorum',
            ],
            19 => [
                'id' => 20,
                'city_name' => 'Denizli',
            ],
            20 => [
                'id' => 21,
                'city_name' => 'Diyarbakır',
            ],
            21 => [
                'id' => 22,
                'city_name' => 'Edirne',
            ],
            22 => [
                'id' => 23,
                'city_name' => 'Elazığ',
            ],
            23 => [
                'id' => 24,
                'city_name' => 'Erzincan',
            ],
            24 => [
                'id' => 25,
                'city_name' => 'Erzurum',
            ],
            25 => [
                'id' => 26,
                'city_name' => 'Eskişehir',
            ],
            26 => [
                'id' => 27,
                'city_name' => 'Gaziantep',
            ],
            27 => [
                'id' => 28,
                'city_name' => 'Giresun',
            ],
            28 => [
                'id' => 29,
                'city_name' => 'Gümüşhane',
            ],
            29 => [
                'id' => 30,
                'city_name' => 'Hakkari',
            ],
            30 => [
                'id' => 31,
                'city_name' => 'Hatay',
            ],
            31 => [
                'id' => 32,
                'city_name' => 'Isparta',
            ],
            32 => [
                'id' => 33,
                'city_name' => 'Mersin',
            ],
            33 => [
                'id' => 34,
                'city_name' => 'İstanbul',
            ],
            34 => [
                'id' => 35,
                'city_name' => 'İzmir',
            ],
            35 => [
                'id' => 36,
                'city_name' => 'Kars',
            ],
            36 => [
                'id' => 37,
                'city_name' => 'Kastamonu',
            ],
            37 => [
                'id' => 38,
                'city_name' => 'Kayseri',
            ],
            38 => [
                'id' => 39,
                'city_name' => 'Kırklareli',
            ],
            39 => [
                'id' => 40,
                'city_name' => 'Kırşehir',
            ],
            40 => [
                'id' => 41,
                'city_name' => 'Kocaeli',
            ],
            41 => [
                'id' => 42,
                'city_name' => 'Konya',
            ],
            42 => [
                'id' => 43,
                'city_name' => 'Kütahya',
            ],
            43 => [
                'id' => 44,
                'city_name' => 'Malatya',
            ],
            44 => [
                'id' => 45,
                'city_name' => 'Manisa',
            ],
            45 => [
                'id' => 46,
                'city_name' => 'Kahramanmaraş',
            ],
            46 => [
                'id' => 47,
                'city_name' => 'Mardin',
            ],
            47 => [
                'id' => 48,
                'city_name' => 'Muğla',
            ],
            48 => [
                'id' => 49,
                'city_name' => 'Muş',
            ],
            49 => [
                'id' => 50,
                'city_name' => 'Nevşehir',
            ],
            50 => [
                'id' => 51,
                'city_name' => 'Niğde',
            ],
            51 => [
                'id' => 52,
                'city_name' => 'Ordu',
            ],
            52 => [
                'id' => 53,
                'city_name' => 'Rize',
            ],
            53 => [
                'id' => 54,
                'city_name' => 'Sakarya',
            ],
            54 => [
                'id' => 55,
                'city_name' => 'Samsun',
            ],
            55 => [
                'id' => 56,
                'city_name' => 'Siirt',
            ],
            56 => [
                'id' => 57,
                'city_name' => 'Sinop',
            ],
            57 => [
                'id' => 58,
                'city_name' => 'Sivas',
            ],
            58 => [
                'id' => 59,
                'city_name' => 'Tekirdağ',
            ],
            59 => [
                'id' => 60,
                'city_name' => 'Tokat',
            ],
            60 => [
                'id' => 61,
                'city_name' => 'Trabzon',
            ],
            61 => [
                'id' => 62,
                'city_name' => 'Tunceli',
            ],
            62 => [
                'id' => 63,
                'city_name' => 'Şanlıurfa',
            ],
            63 => [
                'id' => 64,
                'city_name' => 'Uşak',
            ],
            64 => [
                'id' => 65,
                'city_name' => 'Van',
            ],
            65 => [
                'id' => 66,
                'city_name' => 'Yozgat',
            ],
            66 => [
                'id' => 67,
                'city_name' => 'Zonguldak',
            ],
            67 => [
                'id' => 68,
                'city_name' => 'Aksaray',
            ],
            68 => [
                'id' => 69,
                'city_name' => 'Bayburt',
            ],
            69 => [
                'id' => 70,
                'city_name' => 'Karaman',
            ],
            70 => [
                'id' => 71,
                'city_name' => 'Kırıkkale',
            ],
            71 => [
                'id' => 72,
                'city_name' => 'Batman',
            ],
            72 => [
                'id' => 73,
                'city_name' => 'Şırnak',
            ],
            73 => [
                'id' => 74,
                'city_name' => 'Bartın',
            ],
            74 => [
                'id' => 75,
                'city_name' => 'Ardahan',
            ],
            75 => [
                'id' => 76,
                'city_name' => 'Iğdır',
            ],
            76 => [
                'id' => 77,
                'city_name' => 'Yalova',
            ],
            77 => [
                'id' => 78,
                'city_name' => 'Karabük',
            ],
            78 => [
                'id' => 79,
                'city_name' => 'Kilis',
            ],
            79 => [
                'id' => 80,
                'city_name' => 'Osmaniye',
            ],
            80 => [
                'id' => 81,
                'city_name' => 'Düzce',
            ],
        ]);
    }
}
