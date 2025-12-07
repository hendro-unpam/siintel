<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\Sekolah;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all sekolah
        $sekolahs = Sekolah::all();
        
        // 5 berita templates with long content (A4 length)
        $beritaTemplates = [
            [
                'judul' => 'Upacara Bendera Peringatan Hari Kemerdekaan Indonesia ke-79',
                'gambar' => 'berita/berita_upacara.png',
                'penulis' => 'Tim Humas',
                'tanggal_post' => '2024-08-17',
                'views' => rand(100, 500),
                'konten' => <<<EOT
<p>Dalam rangka memperingati Hari Kemerdekaan Republik Indonesia yang ke-79, seluruh civitas akademika sekolah menggelar upacara bendera dengan penuh khidmat dan semangat nasionalisme yang tinggi. Kegiatan ini diikuti oleh seluruh siswa, guru, dan tenaga kependidikan yang mengenakan pakaian merah putih, menciptakan suasana yang sangat patriotik dan membanggakan.</p>

<p>Upacara dimulai tepat pukul 07.00 WIB dengan cuaca yang cerah dan mendukung. Petugas upacara yang terdiri dari siswa-siswi terpilih tampil dengan sangat disiplin dan professional. Pembawa bendera melaksanakan tugasnya dengan sempurna, mengibarkan Sang Saka Merah Putih dengan penuh kebanggaan di tiang bendera yang menjulang tinggi di tengah lapangan sekolah.</p>

<p>Kepala Sekolah dalam amanatnya menyampaikan pesan mendalam tentang pentingnya memaknai kemerdekaan di era modern ini. "Kemerdekaan bukanlah akhir dari perjuangan, melainkan awal dari tanggung jawab kita untuk membangun bangsa yang lebih baik. Sebagai generasi penerus, kalian memiliki peran penting dalam melanjutkan cita-cita para pahlawan," ujar beliau dengan penuh semangat.</p>

<p>Dalam sambutannya, Kepala Sekolah juga menekankan bahwa kemerdekaan harus diisi dengan prestasi-prestasi yang membanggakan. Siswa-siswi diharapkan dapat meraih prestasi terbaik dalam bidang akademik maupun non-akademik sebagai bentuk kontribusi nyata terhadap kemajuan bangsa dan negara. Semangat juang para pahlawan harus ditransformasikan menjadi semangat belajar dan berkarya.</p>

<p>Suasana upacara semakin meriah dengan penampilan paduan suara sekolah yang membawakan lagu-lagu nasional dengan sangat memukau. Alunan lagu "Indonesia Raya", "Mengheningkan Cipta", dan "Hari Merdeka" menggema dengan lantang, membangkitkan rasa patriotisme yang mendalam di hati seluruh peserta upacara. Air mata haru terlihat mengalir di beberapa wajah guru dan siswa yang terhanyut dalam suasana penuh khidmat tersebut.</p>

<p>Tidak hanya itu, kegiatan dilanjutkan dengan lomba-lomba kemerdekaan yang sangat meriah dan penuh suka cita. Berbagai lomba tradisional seperti lomba makan kerupuk, lomba balap karung, lomba tarik tambang, dan lomba bakiak menjadi ajang kebersamaan yang mempererat hubungan antar siswa dari berbagai kelas. Gelak tawa dan sorak sorai terdengar mengiringi setiap perlombaan yang berlangsung.</p>

<p>Panitia kegiatan juga menyiapkan doorprize menarik bagi para pemenang lomba. Hadiah-hadiah berupa alat tulis, buku bacaan, dan voucher belanja diserahkan langsung oleh Kepala Sekolah kepada para pemenang. Semangat kompetisi yang sehat terlihat jelas dari antusiasme siswa dalam mengikuti setiap perlombaan dengan penuh semangat dan sportivitas.</p>

<p>Kegiatan peringatan kemerdekaan ini tidak hanya menjadi ajang seremonial semata, tetapi juga menjadi momentum penting untuk menanamkan nilai-nilai kebangsaan kepada generasi muda. Melalui kegiatan seperti ini, diharapkan siswa-siswi dapat memahami dan menghargai perjuangan para pahlawan yang telah mengorbankan jiwa dan raga demi kemerdekaan bangsa Indonesia.</p>

<p>Di akhir kegiatan, seluruh peserta upacara berfoto bersama sebagai dokumentasi yang akan menjadi kenangan indah. Foto-foto tersebut akan dipajang di majalah dinding sekolah dan diunggah ke media sosial resmi sekolah sebagai bentuk publikasi kegiatan positif yang dapat menginspirasi masyarakat luas tentang semangat nasionalisme yang masih membara di kalangan generasi muda.</p>
EOT
            ],
            [
                'judul' => 'Pekan Olahraga dan Seni (PORSENI) Tahunan Berlangsung Meriah',
                'gambar' => 'berita/berita_olahraga.png',
                'penulis' => 'Tim Humas',
                'tanggal_post' => '2024-09-15',
                'views' => rand(100, 500),
                'konten' => <<<EOT
<p>Sekolah kembali menggelar Pekan Olahraga dan Seni (PORSENI) tahunan yang disambut dengan antusiasme luar biasa dari seluruh siswa. Kegiatan yang berlangsung selama tiga hari ini menjadi ajang unjuk kebolehan dalam bidang olahraga dan kesenian, sekaligus mempererat tali persaudaraan antar siswa dari berbagai kelas dan tingkatan.</p>

<p>Pembukaan PORSENI dilaksanakan dengan sangat meriah. Parade seluruh kontingen kelas memasuki lapangan dengan mengenakan kostum unik dan kreatif yang mencerminkan identitas masing-masing kelas. Atraksi drum band sekolah membuka acara dengan penampilan yang memukau, diiringi oleh gerakan cheerleaders yang enerjik dan penuh semangat. Suasana lapangan seolah berubah menjadi arena festival yang sangat meriah.</p>

<p>Berbagai cabang olahraga dipertandingkan dalam PORSENI kali ini. Mulai dari sepak bola mini, basket, voli, bulu tangkis, tenis meja, hingga atletik. Setiap pertandingan berlangsung dengan penuh semangat kompetisi yang sehat. Para supporter dari masing-masing kelas tidak henti-hentinya memberikan dukungan moral kepada para atlet yang berlaga di lapangan.</p>

<p>Dalam cabang sepak bola mini, pertandingan final berlangsung sangat sengit antara Tim Kelas 5A melawan Tim Kelas 6B. Kedua tim bermain dengan strategi yang apik dan menampilkan skill individu yang mengagumkan. Pertandingan berakhir dengan skor 2-1 untuk kemenangan Tim Kelas 6B yang berhasil mencetak gol di menit-menit akhir pertandingan.</p>

<p>Tidak kalah meriah, cabang kesenian juga menampilkan berbagai talenta siswa yang luar biasa. Lomba menyanyi solo, paduan suara, tari tradisional, tari modern, dan drama musikal menjadi ajang ekspresi kreativitas siswa. Juri yang terdiri dari guru seni dan musisi profesional memberikan penilaian yang objektif terhadap setiap penampilan peserta.</p>

<p>Salah satu penampilan yang paling memukau adalah pertunjukan drama musikal yang ditampilkan oleh siswa kelas 6. Mereka mengangkat cerita rakyat Nusantara dengan sentuhan modern yang sangat kreatif. Kostum yang colorful, tata panggung yang apik, dan akting para pemain yang natural berhasil membuat penonton terhanyut dalam cerita yang dibawakan.</p>

<p>Kepala Sekolah menyampaikan apresiasi yang tinggi atas penyelenggaraan PORSENI yang sukses. "PORSENI bukan hanya tentang kompetisi dan memenangkan hadiah, tetapi lebih dari itu adalah tentang membangun karakter sportivitas, kerjasama tim, dan mengembangkan bakat serta minat siswa dalam bidang olahraga dan seni," tegas beliau dalam sambutannya saat penutupan.</p>

<p>Pada upacara penutupan, berbagai penghargaan diserahkan kepada para pemenang dari setiap cabang yang dilombakan. Piala bergulir untuk juara umum PORSENI tahun ini berhasil diraih oleh Kelas 6A yang konsisten menunjukkan performa terbaik di berbagai cabang. Selain piala, para pemenang juga menerima medali dan sertifikat penghargaan yang dapat menjadi kebanggaan dan motivasi untuk berprestasi lebih baik lagi.</p>

<p>PORSENI tahun ini juga didukung oleh berbagai sponsor dari komunitas orang tua siswa dan mitra bisnis sekolah. Dukungan tersebut memungkinkan penyelenggaraan kegiatan yang lebih berkualitas dengan fasilitas dan hadiah yang lebih memadai. Kerjasama antara sekolah dan komunitas ini diharapkan dapat terus berlanjut untuk kegiatan-kegiatan positif lainnya di masa mendatang.</p>
EOT
            ],
            [
                'judul' => 'Pentas Seni Budaya Nusantara Meriahkan Perayaan Hari Kartini',
                'gambar' => 'berita/berita_pentas.png',
                'penulis' => 'Tim Humas',
                'tanggal_post' => '2024-04-21',
                'views' => rand(100, 500),
                'konten' => <<<EOT
<p>Dalam rangka memperingati Hari Kartini yang jatuh pada tanggal 21 April, sekolah menyelenggarakan Pentas Seni Budaya Nusantara yang sangat meriah dan penuh warna. Acara ini bertujuan untuk melestarikan budaya Indonesia sekaligus mengenang jasa R.A. Kartini sebagai pahlawan emansipasi perempuan Indonesia yang telah menginspirasi jutaan perempuan untuk terus maju dan berprestasi.</p>

<p>Seluruh siswa dan guru hadir dengan mengenakan pakaian adat dari berbagai daerah di Indonesia. Beragam corak batik, kebaya, baju bodo, ulos, dan pakaian adat lainnya memenuhi halaman sekolah, menciptakan pemandangan yang sangat indah dan membanggakan. Keanekaragaman budaya Indonesia terpancar jelas dari busana yang dikenakan oleh seluruh civitas akademika.</p>

<p>Pentas seni dibuka dengan tarian tradisional Tari Pakarena dari Sulawesi Selatan yang ditarikan oleh siswi-siswi kelas 5. Gerakan anggun dan lemah gemulai para penari berhasil memukau seluruh penonton. Kostum yang elegan dengan warna emas dan merah menambah keindahan penampilan yang mendapat tepuk tangan meriah dari hadirin.</p>

<p>Tidak ketinggalan, siswa-siswa kelas 4 menampilkan Tari Saman dari Aceh yang terkenal dengan gerakan yang kompak dan energik. Meski membutuhkan latihan yang intensif, para penari berhasil menampilkan Tari Saman dengan sangat memukau. Kekompakan gerakan dan irama tepuk tangan yang mengikuti lagu tradisional Aceh membuat penonton terpana dan tidak henti-hentinya memberikan apresiasi.</p>

<p>Selain tarian tradisional, acara juga dimeriahkan dengan penampilan musik gamelan yang dimainkan oleh siswa-siswa yang tergabung dalam ekstrakurikuler karawitan. Alunan gamelan yang khas Jawa mengalun merdu, membawa suasana yang kental dengan nuansa tradisional. Penampilan ini mendapat sambutan hangat dari penonton, terutama dari para orang tua yang merasa bangga melihat anak-anak mereka menguasai alat musik tradisional.</p>

<p>Drama singkat yang mengisahkan perjuangan R.A. Kartini juga ditampilkan dalam pentas seni ini. Naskah drama yang ditulis oleh guru bahasa Indonesia berhasil menyentuh hati penonton. Adegan ketika Kartini berjuang untuk mendapatkan pendidikan dan hak-hak perempuan berhasil membangkitkan emosi penonton. Beberapa orang tua terlihat meneteskan air mata haru menyaksikan perjuangan sang pahlawan yang diperankan dengan sangat baik.</p>

<p>Kepala Sekolah dalam sambutannya menekankan pentingnya meneladani semangat Kartini dalam kehidupan sehari-hari. "R.A. Kartini telah menunjukkan bahwa perempuan memiliki hak yang sama dalam memperoleh pendidikan dan berkarya. Mari kita lanjutkan perjuangan beliau dengan terus belajar dan berprestasi, tidak memandang gender," pesan beliau yang disambut tepuk tangan meriah.</p>

<p>Acara ditutup dengan penampilan paduan suara yang membawakan lagu "Ibu Kita Kartini" dan "Perempuan Indonesia". Seluruh hadirin ikut bernyanyi bersama, menciptakan momen yang sangat emosional dan membanggakan. Kegiatan ini tidak hanya menjadi ajang hiburan, tetapi juga menjadi media pembelajaran tentang sejarah perjuangan perempuan Indonesia dan pentingnya melestarikan budaya bangsa.</p>

<p>Panitia penyelenggara yang terdiri dari guru dan komite sekolah menyatakan bahwa acara tahun ini berjalan dengan sangat sukses. Partisipasi yang tinggi dari siswa, orang tua, dan masyarakat sekitar menunjukkan antusiasme yang besar terhadap pelestarian budaya dan peringatan hari-hari bersejarah. Diharapkan kegiatan serupa dapat terus dilaksanakan setiap tahun dengan konsep yang lebih inovatif.</p>
EOT
            ],
            [
                'judul' => 'Kunjungan Edukatif ke Museum Nasional Menambah Wawasan Sejarah',
                'gambar' => 'berita/berita_kunjungan.png',
                'penulis' => 'Tim Humas',
                'tanggal_post' => '2024-10-05',
                'views' => rand(100, 500),
                'konten' => <<<EOT
<p>Sebagai bagian dari program pendidikan yang komprehensif, sekolah mengadakan kunjungan edukatif ke Museum Nasional Indonesia yang berlokasi di Jakarta Pusat. Kegiatan ini diikuti oleh seluruh siswa kelas atas dengan didampingi oleh guru-guru pendamping. Tujuan utama kunjungan ini adalah untuk memberikan pengalaman belajar langsung tentang sejarah dan kebudayaan Indonesia.</p>

<p>Rombongan berangkat dari sekolah pukul 07.00 WIB menggunakan bus pariwisata yang telah disiapkan. Perjalanan yang memakan waktu sekitar satu setengah jam diisi dengan berbagai kegiatan seru seperti bernyanyi bersama, kuis tentang sejarah Indonesia, dan diskusi tentang apa yang akan dilihat di museum. Antusiasme siswa terlihat sangat tinggi, mereka tidak sabar untuk segera sampai di destinasi.</p>

<p>Sesampainya di Museum Nasional, rombongan disambut oleh pemandu museum yang profesional dan berpengalaman. Pemandu memberikan penjelasan singkat tentang sejarah museum yang didirikan pada tahun 1778 serta berbagai koleksi yang tersimpan di dalamnya. Siswa-siswa terlihat sangat antusias mendengarkan penjelasan sambil mencatat poin-poin penting dalam buku catatan mereka.</p>

<p>Tur dimulai dari ruang pamer prasejarah yang memamerkan berbagai fosil dan artefak dari zaman prasejarah. Siswa-siswa terkagum-kagum melihat fosil manusia purba dan berbagai peralatan batu yang digunakan oleh manusia zaman dahulu. Pemandu menjelaskan dengan detail tentang evolusi manusia dan kehidupan masyarakat prasejarah di Nusantara yang sangat berbeda dengan kehidupan modern saat ini.</p>

<p>Selanjutnya, rombongan memasuki ruang pamer keramik dan arca. Koleksi keramik dari berbagai dinasti Tiongkok dan arca-arca peninggalan kerajaan Hindu-Buddha memukau siswa dengan keindahan dan kehalusan seninya. Patung-patung dewa dan relief candi yang dipamerkan menjadi bukti nyata kejayaan kerajaan-kerajaan Nusantara di masa lalu.</p>

<p>Ruang pamer yang paling diminati siswa adalah ruang pamer Harta Karun. Di ruangan ini terpampang berbagai perhiasan emas dan permata peninggalan kerajaan-kerajaan Nusantara. Mahkota, kalung, gelang, dan berbagai perhiasan lainnya yang terbuat dari emas murni membuat siswa terkesima. Kemegahan dan kemakmuran kerajaan-kerajaan Nusantara di masa lalu terpancar jelas dari koleksi-koleksi tersebut.</p>

<p>Tidak hanya melihat-lihat koleksi, siswa juga diberi kesempatan untuk mengikuti workshop mini tentang batik dan wayang. Workshop ini bertujuan untuk memberikan pengalaman langsung kepada siswa tentang proses pembuatan karya seni tradisional Indonesia. Banyak siswa yang tertarik dan ingin belajar lebih dalam tentang seni batik dan wayang setelah mengikuti workshop tersebut.</p>

<p>Sebelum pulang, rombongan menyempatkan diri untuk berfoto bersama di depan museum. Foto-foto tersebut akan digunakan sebagai dokumentasi kegiatan dan dipajang di majalah dinding sekolah. Siswa-siswa juga membeli berbagai suvenir khas museum sebagai oleh-oleh dan kenang-kenangan dari kunjungan yang sangat berkesan ini.</p>

<p>Guru pendamping mengungkapkan kepuasan atas pelaksanaan kunjungan yang berjalan dengan lancar dan tertib. "Kunjungan ke museum adalah salah satu metode pembelajaran yang efektif untuk menanamkan kecintaan terhadap sejarah dan budaya bangsa. Melalui pengalaman langsung seperti ini, siswa dapat lebih memahami dan mengapresiasi warisan budaya yang dimiliki bangsa Indonesia," jelas salah satu guru pendamping.</p>
EOT
            ],
            [
                'judul' => 'Siswa Raih Juara di Olimpiade Sains Nasional Tingkat Kabupaten',
                'gambar' => 'berita/berita_lomba.png',
                'penulis' => 'Tim Humas',
                'tanggal_post' => '2024-11-20',
                'views' => rand(100, 500),
                'konten' => <<<EOT
<p>Kebanggaan besar dirasakan oleh seluruh civitas akademika sekolah setelah siswa-siswi berhasil meraih prestasi gemilang dalam Olimpiade Sains Nasional (OSN) tingkat Kabupaten. Tiga siswa berhasil meraih medali emas, lima siswa meraih medali perak, dan empat siswa meraih medali perunggu dalam berbagai bidang sains yang dilombakan.</p>

<p>Olimpiade Sains Nasional merupakan ajang kompetisi sains bergengsi yang diselenggarakan oleh Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi. Kompetisi ini bertujuan untuk menemukan dan mengembangkan bakat serta minat siswa dalam bidang sains. Berbagai bidang yang dilombakan meliputi Matematika, IPA, dan Bahasa Indonesia.</p>

<p>Dalam bidang Matematika, sekolah berhasil menempatkan tiga siswanya di peringkat teratas. Siswa dengan inisial AS berhasil meraih medali emas dengan skor tertinggi di antara seluruh peserta. Prestasi ini sangat membanggakan mengingat tingginya tingkat persaingan dengan peserta dari sekolah-sekolah unggulan lainnya di kabupaten.</p>

<p>Bidang IPA juga menjadi cabang yang sangat gemilang bagi sekolah. Dua siswa berhasil meraih medali emas dan tiga siswa meraih medali perak. Materi yang diujikan meliputi fisika, kimia, dan biologi dengan tingkat kesulitan yang cukup tinggi. Para siswa telah mempersiapkan diri dengan intensif selama beberapa bulan sebelum kompetisi berlangsung.</p>

<p>Keberhasilan ini tidak lepas dari kerja keras dan dedikasi para guru pembimbing yang telah mendampingi siswa dalam persiapan menghadapi olimpiade. Latihan intensif dilakukan setiap hari setelah jam sekolah, dengan fokus pada penguasaan materi dan teknik menjawab soal-soal olimpiade yang membutuhkan analisis dan pemecahan masalah tingkat tinggi.</p>

<p>Kepala Sekolah menyampaikan apresiasi setinggi-tingginya kepada para siswa peraih medali dan guru pembimbing. "Prestasi ini adalah buah dari kerja keras dan ketekunan. Kalian telah membuktikan bahwa dengan tekad yang kuat dan usaha yang maksimal, tidak ada yang mustahil untuk dicapai. Teruslah berprestasi dan jadilah kebanggaan sekolah, orang tua, dan bangsa," ujar beliau dalam sambutannya saat penyambutan para juara.</p>

<p>Sekolah memberikan penghargaan khusus kepada para peraih medali berupa beasiswa pendidikan dan berbagai hadiah lainnya. Penghargaan ini diharapkan dapat menjadi motivasi bagi siswa lain untuk terus berprestasi dan mengikuti jejak para juara. Kompetisi yang sehat dalam bidang akademik akan mendorong peningkatan kualitas pendidikan secara keseluruhan.</p>

<p>Para peraih medali emas akan mewakili kabupaten untuk berlaga di tingkat provinsi bulan depan. Persiapan yang lebih intensif sedang dilakukan untuk memastikan para siswa siap bersaing dengan peserta-peserta terbaik dari kabupaten lain. Harapannya, prestasi yang lebih gemilang dapat diraih di tingkat yang lebih tinggi.</p>

<p>Komunitas orang tua siswa turut menyampaikan dukungan dan kebanggaan atas prestasi yang diraih. Banyak orang tua yang mengakui bahwa keberhasilan ini adalah hasil kerjasama yang baik antara sekolah dan keluarga dalam mendukung perkembangan akademik anak-anak. Sinergi yang positif ini diharapkan dapat terus terjaga untuk mendukung prestasi-prestasi selanjutnya di masa yang akan datang.</p>
EOT
            ],
        ];

        // Create berita for each sekolah
        foreach ($sekolahs as $sekolah) {
            foreach ($beritaTemplates as $template) {
                Berita::withoutGlobalScope('sekolah')->updateOrCreate(
                    [
                        'sekolah_id' => $sekolah->id,
                        'judul' => $template['judul'],
                    ],
                    [
                        'konten' => $template['konten'],
                        'gambar' => $template['gambar'],
                        'penulis' => $template['penulis'],
                        'tanggal_post' => $template['tanggal_post'],
                        'views' => $template['views'],
                    ]
                );
            }
        }
    }
}
