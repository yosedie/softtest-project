<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('oauth_clients')->delete();
        
        \DB::table('oauth_clients')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => NULL,
                'name' => 'eclass Personal Access Client',
                'secret' => 'HmAXRuNipLkvdzx3HcZg70VRifZwieezgeaEG7PS',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2021-12-31 10:10:40',
                'updated_at' => '2021-12-31 10:10:40',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => NULL,
                'name' => 'eclass Personal Access Client',
                'secret' => 'oO7caknGa3RKfNjIiXCzVzC6lN9yYKTeDsXKzttd',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2021-12-31 10:11:17',
                'updated_at' => '2021-12-31 10:11:17',
            ),
            2 => 
            array (
                'id' => 4,
                'user_id' => NULL,
                'name' => 'eClass-LearningManagementSystem Personal Access Client',
                'secret' => '4xY5MHGJdBYwvMBlsSmIjZPtip9Sqx5G1ey2IdRJ',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2022-01-17 12:04:13',
                'updated_at' => '2022-01-17 12:04:13',
            ),
            3 => 
            array (
                'id' => 5,
                'user_id' => NULL,
                'name' => 'eClass-LearningManagementSystem Password Grant Client',
                'secret' => 'xexUO5Q37SjAT3Ld7OCyKQ27Qf9jcGvzyZbGMXa5',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2022-01-17 12:04:13',
                'updated_at' => '2022-01-17 12:04:13',
            ),
            4 => 
            array (
                'id' => 6,
                'user_id' => NULL,
                'name' => 'eClass-LearningManagementSystem Personal Access Client',
                'secret' => 'Lz99GhYjTMAAR4jpPwSWmuTJDud4xZHaVTvmQSdK',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2022-01-17 12:05:13',
                'updated_at' => '2022-01-17 12:05:13',
            ),
            5 => 
            array (
                'id' => 7,
                'user_id' => NULL,
                'name' => 'eClass-LearningManagementSystem Password Grant Client',
                'secret' => 'sGpHkHDLJhNWLUJFTGoTISe06onUWm3wBNnKaKqz',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2022-01-17 12:05:13',
                'updated_at' => '2022-01-17 12:05:13',
            ),
            6 => 
            array (
                'id' => 100,
                'user_id' => NULL,
                'name' => 'eclass Personal Access Client',
                'secret' => 'RPGTalbNmbdavbNmcDQYDzBjJUnaZCv57fip8vkl',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2022-06-19 16:49:53',
                'updated_at' => '2022-06-19 16:49:53',
            ),
            7 => 
            array (
                'id' => 101,
                'user_id' => NULL,
                'name' => 'eclass Personal Access Client',
                'secret' => 'XBwQ3kKKwxJ0hPXj7HTd0rgGo0qdwuZErfqnyxXe',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2022-06-19 16:50:28',
                'updated_at' => '2022-06-19 16:50:28',
            ),
            8 => 
            array (
                'id' => 102,
                'user_id' => NULL,
                'name' => 'eclass Personal Access Client',
                'secret' => 'm85TiSVg8E8ah0RcPVHV3DBU8Eya3Ba1JDgVDZqj',
                'provider' => NULL,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2022-06-19 16:51:05',
                'updated_at' => '2022-06-19 16:51:05',
            ),
            9 => 
            array (
                'id' => 103,
                'user_id' => NULL,
                'name' => 'eclass Password Grant Client',
                'secret' => 'nqOXe5ZI5qIFBG46zD7Vot8QFHdMkUawSdZtCJKX',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2022-06-19 16:51:05',
                'updated_at' => '2022-06-19 16:51:05',
            ),
        ));
        
        
    }
}