<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'ho_ten' => 'Admin Badminton Pro',
                'email' => 'admin@badmintonpro.com',
                'so_dien_thoai' => '0900000000',
                'mat_khau_hash' => Hash::make('admin123'),
                'vai_tro' => 'admin',
            ],
            [
                'ho_ten' => 'Tuấn Nguyễn',
                'email' => 'tuan@gmail.com',
                'so_dien_thoai' => '0901234567',
                'mat_khau_hash' => Hash::make('123456'),
                'vai_tro' => 'khach_hang',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'ho_ten' => $user['ho_ten'],
                    'so_dien_thoai' => $user['so_dien_thoai'],
                    'mat_khau_hash' => $user['mat_khau_hash'],
                    'vai_tro' => $user['vai_tro'],
                ]
            );
        }
    }
}
