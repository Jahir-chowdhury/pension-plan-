<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = [
            'name' => 'Jahirul Islam',
            'email' => 'jahir@guardianlife.com.bd',
            'staff_id' => 20220042,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => 'https://picsum.photos/200/300?nocache=' . microtime(),
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $user1 = User::create($super_admin);
        $user1->assignRole(1);

        $admin = [
            'name' => 'Admin',
            'email' => 'admin@guardianlife.com.bd',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => 'https://picsum.photos/200/300?nocache=' . microtime(),
            'status' => 1,
            'remember_token' => Str::random(10),
        ];

        $user2 = User::create($admin);
        $user2->assignRole(2);

        $opereator = [
            'name' => 'Operator',
            'email' => 'operator@guardianlife.com.bd',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => 'https://picsum.photos/200/300?nocache=' . microtime(),
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $user3 = User::create($opereator);
        $user3->assignRole(3);

        $claim_officer = [
            'name' => 'Md. Asaduzzaman',
            'email' => 'asad@guardianlife.com.bd',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => 'https://picsum.photos/200/300?nocache=' . microtime(),
            'status' => 1,
            'remember_token' => Str::random(10),
        ];

        $user4 = User::create($claim_officer);
        $user4->assignRole(4);



        $investigation_admin = [
            'name' => ' Rafiqul',
            'email' => 'rafiqul@guardianlife.com.bd',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => 'https://picsum.photos/200/300?nocache=' . microtime(),
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $user5 = User::create($investigation_admin);
        $user5->assignRole(5);

        $doc_admin = [
            'name' => 'Dr Fatema Binte Jalal',
            'email' => 'fatema@guardianlife.com.bd',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => 'https://picsum.photos/200/300?nocache=' . microtime(),
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $user6 = User::create($doc_admin);
        $user6->assignRole(6);


        $hod_admin = [
            'name' => 'Dr. Zubair Ahmed',
            'email' => 'dr.zubair@guardianlife.com.bd',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => 'https://picsum.photos/200/300?nocache=' . microtime(),
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $user7 = User::create($hod_admin);
        $user7->assignRole(7);


        $coo_admin = [
            'name' => 'Test User1',
            'email' => 'testcoo@guardianlife.com.bd',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => 'https://picsum.photos/200/300?nocache=' . microtime(),
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $user8 = User::create($coo_admin);
        $user8->assignRole(8);


        $ceo_admin = [
            'name' => 'Test User2',
            'email' => 'testceo@guardianlife.com.bd',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => 'https://picsum.photos/200/300?nocache=' . microtime(),
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $user9 = User::create($ceo_admin);
        $user9->assignRole(9);


        $accountant_admin = [
            'name' => 'Mohammad Sazzad Hossain',
            'email' => 'sazzad@guardianlife.com.bd',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => 'https://picsum.photos/200/300?nocache=' . microtime(),
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $user10 = User::create($accountant_admin);
        $user10->assignRole(10);
    }
}
