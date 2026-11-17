<?php

namespace Database\Seeders;

use App\Models\DataPenduduk;
use App\Models\DataPengantar;
use Illuminate\Database\Seeder;

class DataPengantarSeeder extends Seeder
{
    public function run(): void
    {
        $keperluan = [
            ['Pengurusan SKCK',                    'Untuk melengkapi persyaratan melamar pekerjaan.'],
            ['Pembuatan KTP Elektronik',           'KTP lama hilang, mengurus penggantian di Dispendukcapil.'],
            ['Pembuatan Kartu Keluarga',           'Penambahan anggota keluarga baru.'],
            ['Surat Keterangan Tidak Mampu',       'Pengajuan beasiswa pendidikan anak.'],
            ['Surat Keterangan Domisili Usaha',    'Pendaftaran izin usaha mikro (NIB).'],
            ['Pengurusan Akta Kelahiran',          'Akta kelahiran anak pertama.'],
            ['Surat Pengantar Nikah (N1)',         'Persyaratan pernikahan di KUA.'],
            ['Pindah Domisili',                    'Pindah tempat tinggal ke luar kelurahan.'],
            ['Surat Keterangan Kematian',          'Pengurusan administrasi anggota keluarga yang meninggal.'],
            ['Pengajuan Kredit Usaha Rakyat',      'Persyaratan administrasi pengajuan KUR di bank.'],
        ];

        // Sebaran tahap verifikasi: [keterangan, status(aktif=1/arsip=0)]
        $tahap = [
            ['verifikasi_rt', 1], ['verifikasi_rt', 1], ['verifikasi_rt', 1], ['verifikasi_rt', 1],
            ['verifikasi_rw', 1], ['verifikasi_rw', 1], ['verifikasi_rw', 1],
            ['verifikasi_lurah', 1], ['verifikasi_lurah', 1], ['verifikasi_lurah', 1],
            ['terverifikasi', 1], ['terverifikasi', 1], ['terverifikasi', 1], ['terverifikasi', 1],
            ['terverifikasi', 0], ['terverifikasi', 0],
        ];

        $penduduk = DataPenduduk::where('kewarganegaraan', 'wni')->orderBy('id')->get();

        foreach ($tahap as $i => [$keterangan, $status]) {
            $warga  = $penduduk[($i * 2) % $penduduk->count()];
            [$perlu, $desc] = $keperluan[$i % count($keperluan)];
            $dibuat = now()->subDays(20 - $i)->setTime(8 + $i % 8, ($i * 13) % 60);

            DataPengantar::create([
                'id_surat'    => sprintf('PNTR-%06d', $i + 1),
                'nik'         => $warga->nomor_nik,
                'keperluan'   => $perlu,
                'description' => $desc,
                'status'      => $status,
                'keterangan'  => $keterangan,
                'tgl_berlaku' => $keterangan === 'terverifikasi' ? $dibuat->copy()->addDays(7)->format('Y-m-d') : null,
                'created_at'  => $dibuat,
                'updated_at'  => $dibuat,
            ]);
        }
    }
}
