<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            'Abkhazia',
            'Australia',
            'Austria',
            'Azerbaijan',
            'Albania',
            'Algeria',
            'American Samoa',
            'Anguilla',
            'Angola',
            'Andorra',
            'Antarctica',
            'Antigua and Barbuda',
            'Argentina',
            'Armenia',
            'Aruba',
            'Afghanistan',
            'Bahamas',
            'Bangladesh',
            'Barbados',
            'Bahrain',
            "Belarus",
            'Belize',
            'Belgium',
            'Benin',
            'Bermuda',
            'Bulgaria',
            'Bolivia, Plurinational State',
            'Bonaire, Saba and Sint Eustatius',
            'Bosnia and Herzegovina',
            'Botswana',
            'Brazil',
            'British Indian Ocean Territory',
            'Brunei Darussalam',
            'Burkina Faso',
            'Burundi',
            'Butane',
            'Vanuatu',
            'Hungary',
            'Venezuela Bolivarian Republic',
            'Virgin Islands, British',
            'US Virgin Islands',
            'Vietnam',
            'Gabon',
            'Haiti',
            'Guyana',
            'Gambia',
            'Ghana',
            'Guadeloupe',
            'Guatemala',
            'Guinea',
            'Guinea-Bissau',
            'Germany',
            'Guernsey',
            'Gibraltar',
            'Honduras',
            'Hong Kong',
            'Grenada',
            'Greenland',
            'Greece',
            'Georgia',
            'Guam',
            'Denmark',
            'Jersey',
            'Djibouti',
            'Dominica',
            'Dominican Republic',
            'Egypt',
            'Zambia',
            'West Sahara',
            'Zimbabwe',
            'Israel',
            'India',
            'Indonesia',
            'Jordan',
            'Iraq',
            'Iran, Islamic Republic',
            'Ireland',
            'Iceland',
            'Spain',
            'Italy',
            'Yemen',
            "Cape Verde",
            "Kazakhstan",
            'Cambodia',
            'Cameroon',
            'Canada',
            "Qatar",
            'Kenya',
            'Cyprus',
            'Kyrgyzstan',
            'Kiribati',
            'China',
            'Cocos (Keeling) Islands',
            'Colombia',
            'Comoros',
            'Congo',
            'Congo, Democratic Republic',
            'Korea, Democratic People\'s Republic',
            'Korea, Republic',
            'Costa Rica',
            'Ivory Coast',
            'Cuba',
            "Kuwait",
            'Curacao',
            'Laos',
            "Latvia",
            'Lesotho',
            'Lebanon',
            'Libyan Arab Jamahiriya',
            'Liberia',
            'Liechtenstein',
            'Lithuania',
            'Luxembourg',
            'Mauritius',
            'Mauritania',
            'Madagascar',
            'Mayotte',
            'Macau',
            'Malawi',
            'Malaysia',
            'Mali',
            'States Minor Outlying Islands',
            'Maldives',
            'Malta',
            'Morocco',
            'Martinique',
            'Marshall Islands',
            'Mexico',
            'Micronesia, Federated States',
            'Mozambique',
            'Moldova, Republic',
            'Monaco',
            'Mongolia',
            'Montserrat',
            'Myanmar',
            'Namibia',
            'Nauru',
            'Nepal',
            'Niger',
            'Nigeria',
            'Netherlands',
            'Nicaragua',
            'Niue',
            'New Zealand',
            'New Caledonia',
            'Norway',
            'United Arab Emirates',
            'Oman',
            'Bouvet Island',
            'Isle Of Man',
            'Norfolk Island',
            'Christmas Island',
            'Heard Island and McDonald Islands',
            'Cayman Islands',
            'Cook Islands',
            'Turks and Caicos Islands',
            "Pakistan",
            'Palau',
            'Palestinian Territory occupied',
            'Panama',
            'Papal See (State - Vatican City)',
            'Papua New Guinea',
            'Paraguay',
            'Peru',
            'Pitcairn',
            'Poland',
            'Portugal',
            'Puerto Rico',
            'Republic of Macedonia',
            'Reunion',
            'Russia',
            'Rwanda',
            'Romania',
            'Samoa',
            "San Marino",
            'Sao Tome and Principe',
            'Saudi Arabia',
            'Saint Helena, Ascension Island, Tristan da Cunha',
            'Northern Mariana Islands',
            'Saint Barthelemy',
            'Saint Martin',
            'Senegal',
            'Saint Vincent and the Grenadines',
            'Saint Lucia',
            'Saint Kitts and Nevis',
            'Saint Pierre and Miquelon',
            'Serbia',
            'Seychelles',
            'Singapore',
            'Sint Maarten',
            'Syrian Arab Republic',
            'Slovakia',
            'Slovenia',
            'United Kingdom',
            'United States',
            'Solomon islands',
            'Somalia',
            'Sudan',
            'Suriname',
            'Sierra Leone',
            'Tajikistan',
            'Thailand',
            'Taiwan (China)',
            'Tanzania, United Republic',
            'Timor-Leste',
            'Togo',
            'Tokelau',
            'Tonga',
            'Trinidad and Tobago',
            'Tuvalu',
            'Tunisia',
            'Turkmenistan',
            'Turkey',
            'Uganda',
            'Uzbekistan',
            'Ukraine',
            'Wallis and Futuna',
            'Uruguay',
            'Faroe islands',
            'Fiji',
            'Philippines',
            'Finland',
            'Falkland Islands (Malvinas)',
            'France',
            'French Guiana',
            'French polynesia',
            'French Southern Territories',
            'Croatia',
            'Central African Republic',
            'Chad',
            'Montenegro',
            'Czech Republic',
            'Chile',
            'Switzerland',
            'Sweden',
            'Spitsbergen and Jan Mayen',
            'Sri Lanka',
            'Ecuador',
            'Equatorial Guinea',
            'Eland Islands',
            'El Salvador',
            'Eritrea',
            'Eswatini',
            'Estonia',
            'Ethiopia',
            'South Africa',
            'South Georgia and the South Sandwich Islands',
            'South Ossetia',
            'South Sudan',
            'Jamaica',
            'Japan'
        ];
        foreach ($countries as $county) {
            DB::table('countries')->insert([
                'name' => $county
            ]);
        };
    }
}
