<?php

namespace Database\Seeders;

use App\Models\DataPenduduk;
use Illuminate\Database\Seeder;

class GenerateDataPenduduk extends Seeder
{
    /**
     * Data penduduk semi-real (nama, wilayah & pekerjaan dibuat mirip kondisi nyata).
     */
    public function run(): void
    {
        $alamat = [
            [1, 1, 'Jl. Munggut - Sidorejo No. %d, Sidorejo'],
            [2, 1, 'Jl. Melati No. %d, Sidorejo'],
            [3, 1, 'Jl. Raya Madiun - Ngawi No. %d, Sidorejo'],
            [1, 2, 'Gg. Kenanga No. %d, Sidorejo'],
            [2, 2, 'Jl. Mawar No. %d, Sidorejo'],
        ];

        $kota = ['Klaten', 'Ngawi', 'Madiun', 'Semarang', 'Surabaya', 'Magetan', 'Ponorogo', 'Solo', 'Yogyakarta', 'Jakarta'];

        $laki = [
            'Agus Setyo Nugraha', 'Hari Setyawan Nugroho', 'Ahmad Sayyidul Arifin', 'Budi Santoso', 'Slamet Riyadi',
            'Eko Prasetyo', 'Dwi Cahyono', 'Wahyu Hidayat', 'Joko Susilo', 'Rizky Ramadhan', 'Bayu Pratama',
            'Fajar Nugroho', 'Andi Wijaya', 'Hendra Kurniawan', 'Muhammad Iqbal', 'Teguh Purnomo', 'Sugeng Widodo',
            'Anwar Fauzi', 'Rudi Hartono', 'Yoga Aditya',
        ];
        $perempuan = [
            'Yunia Agustin Lutfiyah', 'Siti Nurhaliza', 'Dewi Lestari', 'Rina Marlina', 'Sri Wahyuni',
            'Ayu Kartika Putri', 'Nur Aini', 'Fitri Handayani', 'Lestari Ningsih', 'Indah Permatasari',
            'Wulan Sari', 'Aisyah Rahmawati', 'Retno Wulandari', 'Maya Anggraeni', 'Putri Amelia',
            'Tri Utami', 'Eka Septiana', 'Dian Puspita', 'Nia Kurniasih', 'Citra Maharani',
        ];

        $pekerjaan = ['Wirausaha', 'Karyawan Swasta', 'Petani', 'Guru', 'Pedagang', 'PNS', 'Buruh Harian', 'Mahasiswa', 'Perawat', 'Mengurus Rumah Tangga'];
        $pendidikan = ['sd', 'smp', 'sma', 'sma', 'diploma', 'sarjana'];

        $rows = [];
        $no = 0;
        foreach ([['l', $laki], ['p', $perempuan]] as [$jk, $names]) {
            foreach ($names as $nama) {
                $no++;
                [$rt, $rw, $jalan] = $alamat[$no % count($alamat)];
                $tahun = 1965 + (($no * 7) % 40);
                $bulan = 1 + (($no * 5) % 12);
                $hari  = 1 + (($no * 11) % 27);
                $tgl   = sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari);
                $tglNik = $jk === 'p' ? $hari + 40 : $hari;

                $rows[] = [
                    'nama_lengkap'    => $nama,
                    // 3521 = kode wilayah Kab. Ngawi, lalu 2 digit kecamatan, ddmmyy, nomor urut
                    'nomor_nik'       => sprintf('352108%02d%02d%02d%04d', $tglNik, $bulan, $tahun % 100, $no),
                    'jenis_kelamin'   => $jk,
                    'tempat_lahir'    => $kota[$no % count($kota)],
                    'tgl_lahir'       => $tgl,
                    'kewarganegaraan' => 'wni',
                    'agama'           => $no % 9 === 0 ? 'katolik' : 'islam',
                    'pend_terakhir'   => $pendidikan[$no % count($pendidikan)],
                    'pekerjaan'       => $pekerjaan[$no % count($pekerjaan)],
                    'alamat_jalan'    => sprintf($jalan, 1 + ($no * 3) % 60),
                    'RT'              => $rt,
                    'RW'              => $rw,
                ];
            }
        }

        // Satu warga negara asing (KITAS)
        $rows[] = [
            'nama_lengkap'    => 'Catherine Amelia Sugiarto',
            'nomor_nik'       => 'KTS12881213312',
            'jenis_kelamin'   => 'p',
            'tempat_lahir'    => 'Abu Dhabi',
            'tgl_lahir'       => '1993-12-12',
            'kewarganegaraan' => 'wna',
            'agama'           => 'islam',
            'pend_terakhir'   => 'sarjana',
            'pekerjaan'       => 'Karyawan Swasta',
            'alamat_jalan'    => 'Jl. Munggut - Sidorejo No. 12, Sidorejo',
            'RT'              => 3,
            'RW'              => 1,
        ];

        foreach ($rows as $row) {
            DataPenduduk::updateOrCreate(['nomor_nik' => $row['nomor_nik']], $row);
        }
    }
}
