<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunSeeder extends Seeder
{
    public function run()
    {
        DB::table('akun')->insert([
            [
                'email' => 'lunastarlight@gmail.com',
                'password' => Hash::make('password123'),
                'namaPengguna' => 'Luna Starlight',
                'fotoProfil' => 'https://www.electricallicenserenewal.com/app-assets/images/user/12.jpg',
                'nomorTelepon' => '08110012345',
                'jenis_akun_id' => 1
            ],
            [
                'email' => 'kai.wave@gmail.com',
                'password' => Hash::make('password123'),
                'namaPengguna' => 'Kai Wave',
                'fotoProfil' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlciUyMHByb2ZpbGV8ZW58MHx8MHx8fDA%3D',
                'nomorTelepon' => '08110054321',
                'jenis_akun_id' => 1
            ],
            [
                'email' => 'naya.sundance@gmail.com',
                'password' => Hash::make('password123'),
                'namaPengguna' => 'Naya Sundance',
                'fotoProfil' => 'https://platform.dkv.global/files/new_design/app-assets/images/profile/user-uploads/user-04.jpg',
                'nomorTelepon' => '08110067890',
                'jenis_akun_id' => 1
            ],
        ]);

        DB::table('akun')->insert([
            [
                'email' => 'ember.craftworks@gmail.com',
                'password' => Hash::make('password123'),
                'namaPengguna' => 'Ember Craftworks',
                'fotoProfil' => 'https://img.freepik.com/free-photo/social-media-concept-composition_23-2150169142.jpg?semt=ais_hybrid&w=740',
                'nomorTelepon' => '08220012345',
                'jenis_akun_id' => 2
            ],
            [
                'email' => 'komunitashijau@gmail.com',
                'password' => Hash::make('password123'),
                'namaPengguna' => 'Komunitas Hijau',
                'fotoProfil' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT1bdyFohnfyO-4ocy0ftHHja_LrYIVQMLGcA&s',
                'nomorTelepon' => '08220054321',
                'jenis_akun_id' => 2
            ],
            [
                'email' => 'ecogreen@gmail.com',
                'password' => Hash::make('password123'),
                'namaPengguna' => 'Eco Green',
                'fotoProfil' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4XvXeI_wyhggb_Wj_645Wa6LcqZiloZXovS6ZZErRo1vEld1GoRPH8pCtG7IApHVqLyI&usqp=CAU',
                'nomorTelepon' => '08220067890',
                'jenis_akun_id' => 2
            ],
        ]);
    }
}
