<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $campaigns = [
            [
                'akun_id' => 4,
                'nama' => 'Bersih-Bersih Sungai Ciliwung',
                'waktu' => $now->copy()->addDays(2),
                'waktu_diperbarui' => $now,
                'deskripsi' => 'Aksi bersih-bersih sungai dan pemilahan sampah organik/anorganik untuk didaur ulang. Kegiatan ini melibatkan relawan dari berbagai komunitas dan masyarakat sekitar untuk bersama-sama menjaga kebersihan Sungai Ciliwung. Selain membersihkan sampah, peserta juga akan mendapatkan edukasi tentang pentingnya menjaga ekosistem sungai dan cara memilah sampah yang benar agar dapat didaur ulang secara optimal.',
                'lokasi' => 'Jakarta Selatan',
                'kontak' => 'ciliwung@bersihdaur.id',
                'kuota_partisipan' => 100,
            ],
            [
                'akun_id' => 5,
                'nama' => 'Aksi Sabtu Bersih Taman Kota',
                'waktu' => $now->copy()->addDays(3),
                'waktu_diperbarui' => $now,
                'deskripsi' => 'Membersihkan taman kota dan memilah sampah plastik untuk bank sampah. Kegiatan ini diadakan setiap hari Sabtu dengan tujuan menciptakan lingkungan taman yang bersih dan nyaman untuk masyarakat. Selain itu, peserta juga diajak untuk memilah sampah plastik yang nantinya akan disalurkan ke bank sampah sebagai upaya mendukung program daur ulang dan pengurangan limbah plastik di kota.',
                'lokasi' => 'Depok',
                'kontak' => 'sabtubersih@taman.id',
                'kuota_partisipan' => 80,
            ],
            [
                'akun_id' => 6,
                'nama' => 'Clean Up Day + Workshop Daur Ulang',
                'waktu' => $now->copy()->addDays(5),
                'waktu_diperbarui' => $now,
                'deskripsi' => 'Kegiatan bersih-bersih lingkungan sekaligus belajar mendaur ulang sampah rumah tangga. Peserta akan diajak untuk membersihkan area sekitar dan kemudian mengikuti workshop yang membahas cara-cara kreatif mendaur ulang sampah rumah tangga menjadi barang yang bermanfaat. Workshop ini juga menghadirkan narasumber dari komunitas daur ulang yang sudah berpengalaman.',
                'lokasi' => 'Bekasi',
                'kontak' => 'cleanup@reuse.org',
                'kuota_partisipan' => 60,
            ],
            [
                'akun_id' => 4,
                'nama' => 'Bersih-Bersih Pantai dan Edukasi Sampah Laut',
                'waktu' => $now->copy()->addDays(6),
                'waktu_diperbarui' => $now,
                'deskripsi' => 'Aksi bersih pantai dan edukasi dampak limbah plastik di laut. Kegiatan ini bertujuan untuk mengurangi jumlah sampah plastik yang mencemari pantai dan laut. Selain membersihkan pantai, peserta juga akan mendapatkan materi edukasi mengenai bahaya limbah plastik bagi biota laut dan cara-cara sederhana yang bisa dilakukan untuk mengurangi penggunaan plastik sekali pakai.',
                'lokasi' => 'Anyer',
                'kontak' => 'pantai@bersihlaut.id',
                'kuota_partisipan' => 120,
            ],
            [
                'akun_id' => 5,
                'nama' => 'Pendampingan desa dalam pengelolaan sampah di sungai',
                'waktu' => $now->copy()->addDays(7),
                'waktu_diperbarui' => $now,
                'deskripsi' => 'Warga bergotong royong membersihkan lingkungan dan memilah sampah untuk daur ulang. Kegiatan ini melibatkan seluruh warga sekitar untuk bersama-sama menjaga kebersihan lingkungan tempat tinggal. Selain membersihkan, peserta juga diajarkan cara memilah sampah organik dan anorganik agar dapat didaur ulang dan mengurangi volume sampah yang dibuang ke TPA.',
                'lokasi' => 'Cimahi',
                'kontak' => 'lingkungan@gotongdaur.id',
                'kuota_partisipan' => 70,
            ],
            [
                'akun_id' => 6,
                'nama' => 'Clean & Recycle Day Sekolah',
                'waktu' => $now->copy()->addDays(4),
                'waktu_diperbarui' => $now,
                'deskripsi' => 'Siswa membersihkan area sekolah dan mendaur ulang kertas serta plastik. Kegiatan ini bertujuan untuk menanamkan kebiasaan baik kepada siswa dalam menjaga kebersihan lingkungan sekolah. Selain membersihkan, siswa juga diajak untuk mengumpulkan kertas dan plastik bekas yang kemudian akan didaur ulang menjadi produk baru yang bermanfaat.',
                'lokasi' => 'Yogyakarta',
                'kontak' => 'schoolrecycle@edu.id',
                'kuota_partisipan' => 90,
            ],
            [
                'akun_id' => 4,
                'nama' => 'Aksi Jumat Bersih + Edukasi Kompos',
                'waktu' => $now->copy()->addDays(2),
                'waktu_diperbarui' => $now,
                'deskripsi' => 'Jumat bersih rutin yang dilengkapi pelatihan mengompos sampah organik. Setiap hari Jumat, warga diajak untuk membersihkan lingkungan dan mengikuti pelatihan membuat kompos dari sampah organik rumah tangga. Pelatihan ini bertujuan untuk mengurangi sampah organik yang dibuang ke TPA dan menghasilkan kompos yang dapat digunakan untuk tanaman di rumah.',
                'lokasi' => 'Bogor',
                'kontak' => 'jumatkompos@desa.id',
                'kuota_partisipan' => 50,
            ],
            [
                'akun_id' => 5,
                'nama' => 'Bersih-Bersih Mall + Dropbox Sampah',
                'waktu' => $now->copy()->addDays(3),
                'waktu_diperbarui' => $now,
                'deskripsi' => 'Pembersihan area mall dan peluncuran dropbox sampah daur ulang. Kegiatan ini melibatkan pengunjung dan pengelola mall untuk bersama-sama membersihkan area mall dari sampah. Selain itu, akan diluncurkan dropbox khusus untuk sampah daur ulang agar pengunjung dapat membuang sampah plastik dan kertas secara terpisah untuk didaur ulang.',
                'lokasi' => 'Tangerang',
                'kontak' => 'mallbersih@reuse.org',
                'kuota_partisipan' => 85,
            ],
            [
                'akun_id' => 6,
                'nama' => 'Car Free Day Recycle Walk',
                'waktu' => $now->copy()->addDay(),
                'waktu_diperbarui' => $now,
                'deskripsi' => 'Jalan sehat sambil mengumpulkan sampah di area CFD dan edukasi daur ulang. Peserta akan berjalan santai di area Car Free Day sambil memungut sampah yang ditemukan di sepanjang jalan. Setelah itu, akan ada sesi edukasi mengenai pentingnya daur ulang dan cara memilah sampah yang benar agar lingkungan tetap bersih dan sehat.',
                'lokasi' => 'Bandung',
                'kontak' => 'cfdwalk@zerowaste.id',
                'kuota_partisipan' => 200,
            ],
            [
                'akun_id' => 4,
                'nama' => 'Aksi Bersih Pasar Tradisional',
                'waktu' => $now->copy()->addDays(5),
                'waktu_diperbarui' => $now,
                'deskripsi' => 'Pembersihan pasar dan pengumpulan kantong plastik untuk didaur ulang. Kegiatan ini bertujuan untuk menciptakan pasar tradisional yang bersih dan bebas dari sampah plastik. Selain membersihkan, peserta juga akan mengumpulkan kantong plastik bekas yang nantinya akan didaur ulang menjadi produk yang lebih ramah lingkungan.',
                'lokasi' => 'Surabaya',
                'kontak' => 'pasarbersih@greenbiz.id',
                'kuota_partisipan' => 100,
            ],
        ];

        DB::table('campaign')->insert($campaigns);
    }
}
