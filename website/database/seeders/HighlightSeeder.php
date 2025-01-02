<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HighlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $highlights = [
            ['year' => 2024, 'event' => 'Traveling (pending)'],
            ['year' => 2023, 'event' => 'Moved to a new Apartment'],
            ['year' => 2023, 'event' => 'Weeding'],
            ['year' => 2023, 'event' => 'New car'],
            ['year' => 2023, 'event' => 'Applied Masters degree in computer science'],
            ['year' => 2023, 'event' => 'Visited ArmadaJS – NoviSad'],
            ['year' => 2023, 'event' => 'Visited Lefkada and Islands – Greece'],
            ['year' => 2023, 'event' => 'Visited Paralia Katerinis'],
            ['year' => 2022, 'event' => 'I bought my first widescreen monitor LG 34 inc'],
            ['year' => 2022, 'event' => 'Visited Skiathos & Skopelos and Islands – Greece'],
            ['year' => 2022, 'event' => 'Totally moved to the Apple eco-system (phone, laptop)'],
            ['year' => 2022, 'event' => 'Close the year as a Guest lecturer at FINKI'],
            ['year' => 2021, 'event' => 'Bought a personal apartment in the city of Skopje'],
            ['year' => 2021, 'event' => 'Visited Serbia (Beograd) – PHPSerbia 2021'],
            ['year' => 2021, 'event' => 'Bought first Mac-mini'],
            ['year' => 2020, 'event' => 'Started working in IWConnect'],
            ['year' => 2020, 'event' => 'Become an Arctic Code Vault Contributor on GitHub'],
            ['year' => 2019, 'event' => 'Visited Germany (Bremen and Düsseldorf)'],
            ['year' => 2019, 'event' => 'Visited Slovenia (Ljubljana, Portoros, Blet, Postojnska jama)'],
            ['year' => 2018, 'event' => 'Began to work at GrabIT'],
            ['year' => 2017, 'event' => 'The most successful year on faculty'],
            ['year' => 2017, 'event' => 'Bachelor’s Degree with technical project done'],
            ['year' => 2016, 'event' => 'Met the most awesome girlfriend in my life'],
            ['year' => 2016, 'event' => 'First freelance project on Upwork'],
            ['year' => 2015, 'event' => 'First Internship for IT in Macedonian Telecom'],
            ['year' => 2015, 'event' => 'First IT certificate'],
            ['year' => 2014, 'event' => 'A first small amount of money from IT – private lessons for students'],
            ['year' => 2013, 'event' => 'Passed the national exam in Math'],
            ['year' => 2013, 'event' => 'Got accepted to the faculty FINKI'],
            ['year' => 2013, 'event' => 'Got driving license'],
        ];

        foreach ($highlights as $highlight) {
            DB::table('highlights')->insert([
                'year' => $highlight['year'],
                'event' => $highlight['event'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
