<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserDataGenerate extends Seeder
{
    /**
     * Akun demo — kata sandi: <nama depan>123
     */
    public function run(): void
    {
        $akun = [
            ['Hardiyanto Setyawan, S.H., M.Kom.',     'hardiyanto@supedes.co.id', 'hardiyanto123', 'lurah'],
            ['Rudi Kurniawan Saputra, S.H., M.Hum.',  'rudi@supedes.co.id',       'rudi123',       'lurah'],
            ['Bambang Sutrisno',                      'bambang@supedes.co.id',    'bambang123',    'ketua_rw'],
            ['Yulia Putri Nur Anggraeni, S.Kom., M.H.', 'yulia@supedes.co.id',    'yulia123',      'ketua_rt'],
            ['Suharto Wibisono',                      'suharto@supedes.co.id',    'suharto123',    'ketua_rt'],
        ];

        foreach ($akun as [$nama, $email, $password, $jabatan]) {
            User::updateOrCreate(['email' => $email], [
                'nama_terang'       => $nama,
                'password'          => bcrypt($password),
                'email_verified_at' => now(),
                'jabatan'           => $jabatan,
                'status'            => 'active',
            ]);
        }
    }
}
