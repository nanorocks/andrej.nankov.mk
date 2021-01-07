<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(User::TABLE)->insert([
            User::EMAIL => env('DEFAULT_USER_EMAIL'),
            User::NAME => 'Andrej Nankov',
            User::INTRO => 'Hello, and welcome to my personal website. My name is <strong>Andrej Nankov</strong> but I introduce myself as nanorocks. I use this nick as better introduction to myself on the internet. This nick is tide connect to my social life and my field of work.
                            On this site you can find content most about my work as a software engineer, experience in various fields of IT, open-source, solved problems, how to grow as an engineer and blog posts related to contend that is interesting to read and know.
                            My goal is to be better self promoted to the IT world and to share my knowledge with others.',
            User::SUMMARY => 'Software engineer with a Bachelor\'s degree (Faculty of Computer Science and Engineering - Skopje, Macedonia) experience in various fields in IT with wide skills. Familiar with each layer of the development process and comfortable to work as a member of a team or independently. Worked with different programming languages and frameworks in different fields like web, desktop-mobile software development and system administration. Also, related to open source with interest in leveraging technology to make the world a better place.',
            User::CURRENT_WORK => 'Working in the field of web development & web services, web design, testing, server configuration solutions.',
            User::TOP_PROGRAMMING_LANGUAGES => 'fab fa-git-alt;
            fab fa-linux;
            fab fa-raspberry-pi;
            fab fa-html5;
            fab fa-css3;
            fab fa-js;
            fab fa-angular;
            fab fa-react;
            fab fa-vuejs;
            fab fa-python;
            fab fa-node;
            fab fa-docker;
            fab fa-wordpress;
            fab fa-bootstrap;
            fab fa-java;
            fa fa-database;
            fab fa-laravel;
            fab fa-symfony;
            fab fa-php',
            USER::QUOTES => json_encode(["Q1" => "\"Talk is cheap. Show me the code.\" - Linus Torvalds"]),
            User::GOALS => 'Generalist with focus on concepts.;
            Believer that success in career depends on persistence and willingness to learn.;
            Understanding client requirements and communicating the progress of the project are core values in achieving the project goals.',
            User::SOC_MEDIA => json_encode([
                "facebook-f" => "https://www.facebook.com/nanorocks",
                "github"   => "https://github.com/nanorocks",
                "linkedin-in" => "https://www.linkedin.com/in/nanorocks"
            ], true),
            User::PASSWORD => Hash::make('secret'),
            User::HIGHLIGHTS => json_encode([
                "2018" => [
                    "By a new car",
                    "Get a new computer"
                ],
                "2020" => [
                    "Begin to work in interworks",
                    "Bachelor Degree degree"
                ]
            ]),
            User::ADDRESS => 'Skopje, Macedonia',
            User::PHONE => '(+389)712-16813',
        ]);
    }
}
