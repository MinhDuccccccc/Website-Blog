<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => '1',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$nGB6TXDB5bTNRv3X5Rgv8exDXc.4uBQJA7bmSYeljH/oH75TQMWrG',
                'is_admin' => '1',
                'created_at' => '2025-04-10 05:02:10',
                'updated_at' => '2025-04-10 05:02:10',
            ],
            [
                'id' => '2',
                'name' => 'Nguyen',
                'email' => 'nguyen@gmail.com',
                'password' => '$2y$12$nGB6TXDB5bTNRv3X5Rgv8exDXc.4uBQJA7bmSYeljH/oH75TQMWrG',
                'is_admin' => '0',
                'created_at' => '2025-04-10 05:02:10',
                'updated_at' => '2025-04-10 05:02:10',
            ],
            [
                'id' => '3',
                'name' => 'Duc',
                'email' => 'duc@gmail.com',
                'password' => '$2y$12$nGB6TXDB5bTNRv3X5Rgv8exDXc.4uBQJA7bmSYeljH/oH75TQMWrG',
                'is_admin' => '0',
                'created_at' => '2025-04-10 05:02:10',
                'updated_at' => '2025-04-10 05:02:10',
            ],
        ]);
    }
}
