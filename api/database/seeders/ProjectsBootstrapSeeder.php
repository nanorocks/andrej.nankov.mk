<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsBootstrapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table(Project::TABLE)->insert([
            Project::TITLE => 'Blog',
            Project::DESCRIPTION => "Production ready blog system. Build with PHP Lumen API, ReactJS Admin Panel, ReactJS Blog Web site. Build for personal use only.",
            Project::DATE => '25.11.2020',
            Project::STATUS => 'maintained',
            Project::LINK => 'https://github.com/nanorocks/blog-api',
            Project::USER_ID => User::all()->random()->id
        ]);

        DB::table(Project::TABLE)->insert([
            Project::TITLE => 'POCO',
            Project::DESCRIPTION => "Minimalist PHP framework based on MVC design pattern.",
            Project::DATE => '12.10.2020',
            Project::STATUS => 'maintained',
            Project::LINK => 'https://github.com/nanorocks/poco',
            Project::IMAGE => 'https://camo.githubusercontent.com/92ca9033334ec7232f0b2f4366416e3ea3a6cab23f4ca7d0fc4da99aabf8163f/68747470733a2f2f692e6962622e636f2f76715278624e6b2f53637265656e73686f742d66726f6d2d323032302d31302d31322d31312d32322d32322d322e706e67',
            Project::USER_ID => User::all()->random()->id
        ]);


        DB::table(Project::TABLE)->insert([
            Project::TITLE => 'S.M.C',
            Project::DESCRIPTION => "Production ready social network build with Laravel 8",
            Project::DATE => '01.10.2020',
            Project::STATUS => 'maintained',
            Project::LINK => 'https://github.com/nanorocks/smc',
            Project::USER_ID => User::all()->random()->id
        ]);

        DB::table(Project::TABLE)->insert([
            Project::TITLE => 'Console key-chain',
            Project::DESCRIPTION => "Console app to store your profile's username and password. Developed with python. Only for personal use. Cross-platform WIN/Linux/MAC",
            Project::DATE => '12.01.2020',
            Project::STATUS => 'active',
            Project::LINK => 'https://github.com/nanorocks/console-keychain',
            Project::USER_ID => User::all()->random()->id
        ]);

        DB::table(Project::TABLE)->insert([
            Project::TITLE => 'Exchange rate',
            Project::DESCRIPTION => "An api service that prepare data for exchange rates and VueJs and Angular SPA apps.",
            Project::DATE => '08.09.2020',
            Project::STATUS => 'maintained',
            Project::USER_ID => User::all()->random()->id
        ]);

        DB::table(Project::TABLE)->insert([
            Project::TITLE => 'Forgotten Traveler Service',
            Project::DESCRIPTION => "Web app and service for manage players, levels on android game. With external services integration. Developed with PHP/Slim/Custom Bootstrap/JavaScript.",
            Project::DATE => '29.12.2019',
            Project::STATUS => 'active',
            Project::USER_ID => User::all()->random()->id
        ]);

        DB::table(Project::TABLE)->insert([
            Project::TITLE => 'Short URL',
            Project::DESCRIPTION => "Web app for short url's. Developed with PHP/JavaScript.",
            Project::DATE => '09.12.2019',
            Project::STATUS => 'active',
            Project::USER_ID => User::all()->random()->id
        ]);

        DB::table(Project::TABLE)->insert([
            Project::TITLE => 'Minifier',
            Project::DESCRIPTION => "Web app for minify css & js. Developed with HTML/Material design/PHP.",
            Project::DATE => '01.12.2019',
            Project::STATUS => 'active',
            Project::USER_ID => User::all()->random()->id
        ]);

        DB::table(Project::TABLE)->insert([
            Project::TITLE => 'Dictionary',
            Project::DESCRIPTION => "It's an English dictionary where you can find description for your beloved word. Developed with flight php and bootstrap material.",
            Project::DATE => '31.08.2019',
            Project::STATUS => 'active',
            Project::USER_ID => User::all()->random()->id
        ]);

        DB::table(Project::TABLE)->insert([
            Project::TITLE => 'Toobloop',
            Project::DESCRIPTION => "Web app for listening music from YOUTUBE in forever loop. Developed with html/css/js.",
            Project::DATE => '31.07.2019',
            Project::STATUS => 'active',
            Project::USER_ID => User::all()->random()->id
        ]);

        DB::table(Project::TABLE)->insert([
            Project::TITLE => 'Personal biography',
            Project::DESCRIPTION => "System for management personal biography. Contains Web app, Api service, Frontend app and Wordpress. With focus on php-laravel and vue.js.",
            Project::DATE => '20.02.2019',
            Project::STATUS => 'active',
            Project::USER_ID => User::all()->random()->id
        ]);
    }
}
