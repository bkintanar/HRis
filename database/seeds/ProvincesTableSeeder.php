<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @author Bertrand Kintanar
     */
    public function run()
    {
        DB::table('provinces')->delete();

        DB::table('provinces')->insert(
            [
                ['id' => 1, 'country_id' => 185, 'name' => 'Abra'],
                ['id' => 2, 'country_id' => 185, 'name' => 'Agusan del Norte'],
                ['id' => 3, 'country_id' => 185, 'name' => 'Agusan del Sur'],
                ['id' => 4, 'country_id' => 185, 'name' => 'Aklan'],
                ['id' => 5, 'country_id' => 185, 'name' => 'Albay'],
                ['id' => 6, 'country_id' => 185, 'name' => 'Antique'],
                ['id' => 7, 'country_id' => 185, 'name' => 'Apayao'],
                ['id' => 8, 'country_id' => 185, 'name' => 'Aurora'],
                ['id' => 9, 'country_id' => 185, 'name' => 'Basilan'],
                ['id' => 10, 'country_id' => 185, 'name' => 'Bataan'],
                ['id' => 11, 'country_id' => 185, 'name' => 'Batanes'],
                ['id' => 12, 'country_id' => 185, 'name' => 'Batangas'],
                ['id' => 13, 'country_id' => 185, 'name' => 'Benguet'],
                ['id' => 14, 'country_id' => 185, 'name' => 'Biliran'],
                ['id' => 15, 'country_id' => 185, 'name' => 'Bohol'],
                ['id' => 16, 'country_id' => 185, 'name' => 'Bukidnon'],
                ['id' => 17, 'country_id' => 185, 'name' => 'Bulacan'],
                ['id' => 18, 'country_id' => 185, 'name' => 'Cagayan'],
                ['id' => 19, 'country_id' => 185, 'name' => 'Camarines Norte'],
                ['id' => 20, 'country_id' => 185, 'name' => 'Camarines Sur'],
                ['id' => 21, 'country_id' => 185, 'name' => 'Camiguin'],
                ['id' => 22, 'country_id' => 185, 'name' => 'Capiz'],
                ['id' => 23, 'country_id' => 185, 'name' => 'Catanduanes'],
                ['id' => 24, 'country_id' => 185, 'name' => 'Cavite'],
                ['id' => 25, 'country_id' => 185, 'name' => 'Cebu'],
                ['id' => 26, 'country_id' => 185, 'name' => 'Compostela Valley'],
                ['id' => 27, 'country_id' => 185, 'name' => 'Cotabato'],
                ['id' => 28, 'country_id' => 185, 'name' => 'Davao del Norte'],
                ['id' => 29, 'country_id' => 185, 'name' => 'Davao del Sur'],
                ['id' => 30, 'country_id' => 185, 'name' => 'Davao Oriental'],
                ['id' => 31, 'country_id' => 185, 'name' => 'Dinagat Islands'],
                ['id' => 32, 'country_id' => 185, 'name' => 'Eastern Samar'],
                ['id' => 33, 'country_id' => 185, 'name' => 'Guimaras'],
                ['id' => 34, 'country_id' => 185, 'name' => 'Ifugao'],
                ['id' => 35, 'country_id' => 185, 'name' => 'Ilocos Norte'],
                ['id' => 36, 'country_id' => 185, 'name' => 'Ilocos Sur'],
                ['id' => 37, 'country_id' => 185, 'name' => 'Isabela'],
                ['id' => 38, 'country_id' => 185, 'name' => 'Iloilo'],
                ['id' => 39, 'country_id' => 185, 'name' => 'Kalinga'],
                ['id' => 40, 'country_id' => 185, 'name' => 'La Union'],
                ['id' => 41, 'country_id' => 185, 'name' => 'Laguna'],
                ['id' => 42, 'country_id' => 185, 'name' => 'Lanao del Norte'],
                ['id' => 43, 'country_id' => 185, 'name' => 'Lanao del Sur'],
                ['id' => 44, 'country_id' => 185, 'name' => 'Leyte'],
                ['id' => 45, 'country_id' => 185, 'name' => 'Maguindanao'],
                ['id' => 46, 'country_id' => 185, 'name' => 'Marinduque'],
                ['id' => 47, 'country_id' => 185, 'name' => 'Masbate'],
                ['id' => 48, 'country_id' => 185, 'name' => 'Metro Manila'],
                ['id' => 49, 'country_id' => 185, 'name' => 'Misamis Occidental'],
                ['id' => 50, 'country_id' => 185, 'name' => 'Misamis Oriental'],
                ['id' => 51, 'country_id' => 185, 'name' => 'Mountain Province'],
                ['id' => 52, 'country_id' => 185, 'name' => 'Negros Occidental'],
                ['id' => 53, 'country_id' => 185, 'name' => 'Negros Oriental'],
                ['id' => 54, 'country_id' => 185, 'name' => 'Northern Samar'],
                ['id' => 55, 'country_id' => 185, 'name' => 'Nueva Ecija'],
                ['id' => 56, 'country_id' => 185, 'name' => 'Nueva Vizcaya'],
                ['id' => 57, 'country_id' => 185, 'name' => 'Occidental Mindoro'],
                ['id' => 58, 'country_id' => 185, 'name' => 'Oriental Mindoro'],
                ['id' => 59, 'country_id' => 185, 'name' => 'Palawan'],
                ['id' => 60, 'country_id' => 185, 'name' => 'Pampanga'],
                ['id' => 61, 'country_id' => 185, 'name' => 'Pangasinan'],
                ['id' => 62, 'country_id' => 185, 'name' => 'Quezon'],
                ['id' => 63, 'country_id' => 185, 'name' => 'Quirino'],
                ['id' => 64, 'country_id' => 185, 'name' => 'Rizal'],
                ['id' => 65, 'country_id' => 185, 'name' => 'Romblon'],
                ['id' => 66, 'country_id' => 185, 'name' => 'Samar'],
                ['id' => 67, 'country_id' => 185, 'name' => 'Sarangani'],
                ['id' => 68, 'country_id' => 185, 'name' => 'Siquijor'],
                ['id' => 69, 'country_id' => 185, 'name' => 'Sorsogon'],
                ['id' => 70, 'country_id' => 185, 'name' => 'South Cotabato'],
                ['id' => 71, 'country_id' => 185, 'name' => 'Southern Leyte'],
                ['id' => 72, 'country_id' => 185, 'name' => 'Sultan Kudarat'],
                ['id' => 73, 'country_id' => 185, 'name' => 'Sulu'],
                ['id' => 74, 'country_id' => 185, 'name' => 'Surigao del Norte'],
                ['id' => 75, 'country_id' => 185, 'name' => 'Surigao del Sur'],
                ['id' => 76, 'country_id' => 185, 'name' => 'Tarlac'],
                ['id' => 77, 'country_id' => 185, 'name' => 'Tawi-Tawi'],
                ['id' => 78, 'country_id' => 185, 'name' => 'Zambales'],
                ['id' => 79, 'country_id' => 185, 'name' => 'Zamboanga del Norte'],
                ['id' => 80, 'country_id' => 185, 'name' => 'Zamboanga del Sur'],
                ['id' => 81, 'country_id' => 185, 'name' => 'Zamboanga Sibugay'],
            ]
        );
    }
}
