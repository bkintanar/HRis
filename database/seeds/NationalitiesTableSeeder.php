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

class NationalitiesTableSeeder extends Seeder
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
        DB::table('nationalities')->delete();

        DB::table('nationalities')->insert(
            [
                ['id' => 1, 'name' => 'Afghan'],
                ['id' => 2, 'name' => 'Albanian'],
                ['id' => 3, 'name' => 'Algerian'],
                ['id' => 4, 'name' => 'American'],
                ['id' => 5, 'name' => 'Andorran'],
                ['id' => 6, 'name' => 'Angolan'],
                ['id' => 7, 'name' => 'Antiguans'],
                ['id' => 8, 'name' => 'Argentinean'],
                ['id' => 9, 'name' => 'Armenian'],
                ['id' => 10, 'name' => 'Australian'],
                ['id' => 11, 'name' => 'Austrian'],
                ['id' => 12, 'name' => 'Azerbaijani'],
                ['id' => 13, 'name' => 'Bahamian'],
                ['id' => 14, 'name' => 'Bahraini'],
                ['id' => 15, 'name' => 'Bangladeshi'],
                ['id' => 16, 'name' => 'Barbadian'],
                ['id' => 17, 'name' => 'Barbudans'],
                ['id' => 18, 'name' => 'Batswana'],
                ['id' => 19, 'name' => 'Belarusian'],
                ['id' => 20, 'name' => 'Belgian'],
                ['id' => 21, 'name' => 'Belizean'],
                ['id' => 22, 'name' => 'Beninese'],
                ['id' => 23, 'name' => 'Bhutanese'],
                ['id' => 24, 'name' => 'Bolivian'],
                ['id' => 25, 'name' => 'Bosnian'],
                ['id' => 26, 'name' => 'Brazilian'],
                ['id' => 27, 'name' => 'British'],
                ['id' => 28, 'name' => 'Bruneian'],
                ['id' => 29, 'name' => 'Bulgarian'],
                ['id' => 30, 'name' => 'Burkinabe'],
                ['id' => 31, 'name' => 'Burmese'],
                ['id' => 32, 'name' => 'Burundian'],
                ['id' => 33, 'name' => 'Cambodian'],
                ['id' => 34, 'name' => 'Cameroonian'],
                ['id' => 35, 'name' => 'Canadian'],
                ['id' => 36, 'name' => 'Cape Verdean'],
                ['id' => 37, 'name' => 'Central African'],
                ['id' => 38, 'name' => 'Chadian'],
                ['id' => 39, 'name' => 'Chilean'],
                ['id' => 40, 'name' => 'Chinese'],
                ['id' => 41, 'name' => 'Colombian'],
                ['id' => 42, 'name' => 'Comoran'],
                ['id' => 43, 'name' => 'Congolese'],
                ['id' => 44, 'name' => 'Costa Rican'],
                ['id' => 45, 'name' => 'Croatian'],
                ['id' => 46, 'name' => 'Cuban'],
                ['id' => 47, 'name' => 'Cypriot'],
                ['id' => 48, 'name' => 'Czech'],
                ['id' => 49, 'name' => 'Danish'],
                ['id' => 50, 'name' => 'Djibouti'],
                ['id' => 51, 'name' => 'Dominican'],
                ['id' => 52, 'name' => 'Dutch'],
                ['id' => 53, 'name' => 'East Timorese'],
                ['id' => 54, 'name' => 'Ecuadorean'],
                ['id' => 55, 'name' => 'Egyptian'],
                ['id' => 56, 'name' => 'Emirian'],
                ['id' => 57, 'name' => 'Equatorial Guinean'],
                ['id' => 58, 'name' => 'Eritrean'],
                ['id' => 59, 'name' => 'Estonian'],
                ['id' => 60, 'name' => 'Ethiopian'],
                ['id' => 61, 'name' => 'Fijian'],
                ['id' => 62, 'name' => 'Filipino'],
                ['id' => 63, 'name' => 'Finnish'],
                ['id' => 64, 'name' => 'French'],
                ['id' => 65, 'name' => 'Gabonese'],
                ['id' => 66, 'name' => 'Gambian'],
                ['id' => 67, 'name' => 'Georgian'],
                ['id' => 68, 'name' => 'German'],
                ['id' => 69, 'name' => 'Ghanaian'],
                ['id' => 70, 'name' => 'Greek'],
                ['id' => 71, 'name' => 'Grenadian'],
                ['id' => 72, 'name' => 'Guatemalan'],
                ['id' => 73, 'name' => 'Guinea-Bissauan'],
                ['id' => 74, 'name' => 'Guinean'],
                ['id' => 75, 'name' => 'Guyanese'],
                ['id' => 76, 'name' => 'Haitian'],
                ['id' => 77, 'name' => 'Herzegovinian'],
                ['id' => 78, 'name' => 'Honduran'],
                ['id' => 79, 'name' => 'Hungarian'],
                ['id' => 80, 'name' => 'I-Kiribati'],
                ['id' => 81, 'name' => 'Icelander'],
                ['id' => 82, 'name' => 'Indian'],
                ['id' => 83, 'name' => 'Indonesian'],
                ['id' => 84, 'name' => 'Iranian'],
                ['id' => 85, 'name' => 'Iraqi'],
                ['id' => 86, 'name' => 'Irish'],
                ['id' => 87, 'name' => 'Israeli'],
                ['id' => 88, 'name' => 'Italian'],
                ['id' => 89, 'name' => 'Ivorian'],
                ['id' => 90, 'name' => 'Jamaican'],
                ['id' => 91, 'name' => 'Japanese'],
                ['id' => 92, 'name' => 'Jordanian'],
                ['id' => 93, 'name' => 'Kazakhstani'],
                ['id' => 94, 'name' => 'Kenyan'],
                ['id' => 95, 'name' => 'Kittian and Nevisian'],
                ['id' => 96, 'name' => 'Kuwaiti'],
                ['id' => 97, 'name' => 'Kyrgyz'],
                ['id' => 98, 'name' => 'Laotian'],
                ['id' => 99, 'name' => 'Latvian'],
                ['id' => 100, 'name' => 'Lebanese'],
                ['id' => 101, 'name' => 'Liberian'],
                ['id' => 102, 'name' => 'Libyan'],
                ['id' => 103, 'name' => 'Liechtensteiner'],
                ['id' => 104, 'name' => 'Lithuanian'],
                ['id' => 105, 'name' => 'Luxembourger'],
                ['id' => 106, 'name' => 'Macedonian'],
                ['id' => 107, 'name' => 'Malagasy'],
                ['id' => 108, 'name' => 'Malawian'],
                ['id' => 109, 'name' => 'Malaysian'],
                ['id' => 110, 'name' => 'Maldivan'],
                ['id' => 111, 'name' => 'Malian'],
                ['id' => 112, 'name' => 'Maltese'],
                ['id' => 113, 'name' => 'Marshallese'],
                ['id' => 114, 'name' => 'Mauritanian'],
                ['id' => 115, 'name' => 'Mauritian'],
                ['id' => 116, 'name' => 'Mexican'],
                ['id' => 117, 'name' => 'Micronesian'],
                ['id' => 118, 'name' => 'Moldovan'],
                ['id' => 119, 'name' => 'Monacan'],
                ['id' => 120, 'name' => 'Mongolian'],
                ['id' => 121, 'name' => 'Moroccan'],
                ['id' => 122, 'name' => 'Mosotho'],
                ['id' => 123, 'name' => 'Motswana'],
                ['id' => 124, 'name' => 'Mozambican'],
                ['id' => 125, 'name' => 'Namibian'],
                ['id' => 126, 'name' => 'Nauruan'],
                ['id' => 127, 'name' => 'Nepalese'],
                ['id' => 128, 'name' => 'New Zealander'],
                ['id' => 129, 'name' => 'Nicaraguan'],
                ['id' => 130, 'name' => 'Nigerian'],
                ['id' => 131, 'name' => 'Nigerien'],
                ['id' => 132, 'name' => 'North Korean'],
                ['id' => 133, 'name' => 'Northern Irish'],
                ['id' => 134, 'name' => 'Norwegian'],
                ['id' => 135, 'name' => 'Omani'],
                ['id' => 136, 'name' => 'Pakistani'],
                ['id' => 137, 'name' => 'Palauan'],
                ['id' => 138, 'name' => 'Panamanian'],
                ['id' => 139, 'name' => 'Papua New Guinean'],
                ['id' => 140, 'name' => 'Paraguayan'],
                ['id' => 141, 'name' => 'Peruvian'],
                ['id' => 142, 'name' => 'Polish'],
                ['id' => 143, 'name' => 'Portuguese'],
                ['id' => 144, 'name' => 'Qatari'],
                ['id' => 145, 'name' => 'Romanian'],
                ['id' => 146, 'name' => 'Russian'],
                ['id' => 147, 'name' => 'Rwandan'],
                ['id' => 148, 'name' => 'Saint Lucian'],
                ['id' => 149, 'name' => 'Salvadoran'],
                ['id' => 150, 'name' => 'Samoan'],
                ['id' => 151, 'name' => 'San Marinese'],
                ['id' => 152, 'name' => 'Sao Tomean'],
                ['id' => 153, 'name' => 'Saudi'],
                ['id' => 154, 'name' => 'Scottish'],
                ['id' => 155, 'name' => 'Senegalese'],
                ['id' => 156, 'name' => 'Serbian'],
                ['id' => 157, 'name' => 'Seychellois'],
                ['id' => 158, 'name' => 'Sierra Leonean'],
                ['id' => 159, 'name' => 'Singaporean'],
                ['id' => 160, 'name' => 'Slovakian'],
                ['id' => 161, 'name' => 'Slovenian'],
                ['id' => 162, 'name' => 'Solomon Islander'],
                ['id' => 163, 'name' => 'Somali'],
                ['id' => 164, 'name' => 'South African'],
                ['id' => 165, 'name' => 'South Korean'],
                ['id' => 166, 'name' => 'Spanish'],
                ['id' => 167, 'name' => 'Sri Lankan'],
                ['id' => 168, 'name' => 'Sudanese'],
                ['id' => 169, 'name' => 'Surinamer'],
                ['id' => 170, 'name' => 'Swazi'],
                ['id' => 171, 'name' => 'Swedish'],
                ['id' => 172, 'name' => 'Swiss'],
                ['id' => 173, 'name' => 'Syrian'],
                ['id' => 174, 'name' => 'Taiwanese'],
                ['id' => 175, 'name' => 'Tajik'],
                ['id' => 176, 'name' => 'Tanzanian'],
                ['id' => 177, 'name' => 'Thai'],
                ['id' => 178, 'name' => 'Togolese'],
                ['id' => 179, 'name' => 'Tongan'],
                ['id' => 180, 'name' => 'Trinidadian or Tobagonian'],
                ['id' => 181, 'name' => 'Tunisian'],
                ['id' => 182, 'name' => 'Turkish'],
                ['id' => 183, 'name' => 'Tuvaluan'],
                ['id' => 184, 'name' => 'Ugandan'],
                ['id' => 185, 'name' => 'Ukrainian'],
                ['id' => 186, 'name' => 'Uruguayan'],
                ['id' => 187, 'name' => 'Uzbekistani'],
                ['id' => 188, 'name' => 'Venezuelan'],
                ['id' => 189, 'name' => 'Vietnamese'],
                ['id' => 190, 'name' => 'Welsh'],
                ['id' => 191, 'name' => 'Yemenite'],
                ['id' => 192, 'name' => 'Zambian'],
                ['id' => 193, 'name' => 'Zimbabwean'],
            ]
        );
    }
}
