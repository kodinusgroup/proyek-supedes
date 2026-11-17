<?php

namespace Database\Seeders;

use App\Models\DataPenduduk;
use App\Models\KritikSaran;
use Illuminate\Database\Seeder;

class KritikSaranSeeder extends Seeder
{
    public function run(): void
    {
        $pesan = [
            ['lurah',    'Aplikasinya sangat membantu, tidak perlu antre lagi untuk minta surat pengantar. Terima kasih!'],
            ['ketua_rt', 'Mohon proses verifikasi di tingkat RT bisa lebih cepat, karena surat saya dibutuhkan minggu ini.'],
            ['ketua_rw', 'Usul agar jadwal pelayanan tatap muka diumumkan juga lewat aplikasi ini.'],
            ['lurah',    'Tampilan cetak surat sudah rapi. Mohon ditambahkan kolom keterangan alamat lengkap.'],
            ['ketua_rt', 'Terima kasih Pak RT, pelayanannya ramah dan cepat.'],
            ['lurah',    'Tolong perbaiki jalan lingkungan di sekitar balai kelurahan, banyak yang berlubang.'],
        ];

        $penduduk = DataPenduduk::where('kewarganegaraan', 'wni')->orderBy('id')->take(count($pesan))->get();

        foreach ($pesan as $i => [$untuk, $isi]) {
            $warga = $penduduk[$i];
            $waktu = now()->subDays(10 - $i);

            KritikSaran::create([
                'nik'            => $warga->nomor_nik,
                'nomor_whatsapp' => '08123' . sprintf('%07d', 4510000 + $i * 7301),
                'email'          => strtolower(explode(' ', $warga->nama_lengkap)[0]) . '@mail.com',
                'for'            => $untuk,
                'confirmed'      => $i % 2 === 0,
                'description'    => $isi,
                'created_at'     => $waktu,
                'updated_at'     => $waktu,
            ]);
        }
    }
}
