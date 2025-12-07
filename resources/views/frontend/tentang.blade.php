@extends('layouts.frontend')

@section('title', 'Tentang Kami - Sekolah Insan Teladan')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1>Tentang Kami</h1>
        <p>Mengenal lebih dekat Sekolah Insan Teladan</p>
    </div>
</div>

<!-- Content -->
<section class="section">
    <div class="container">
        <!-- Sejarah -->
        <div class="content-block">
            <h2 class="section-subtitle">Sejarah Sekolah</h2>
            <p>
                Sekolah Insan Teladan adalah sekolah swasta umum berbasis biaya yang didirikan pada tanggal 3 Agustus 2004. 
                Sekolah ini didirikan untuk menjadi sekolah model dalam Pendidikan Nilai-nilai Kemanusiaan (PNK), yang merupakan 
                program Pendidikan berkarakter yang dikembangkan di Indonesia.
            </p>
            <p>
                Pendidikan Nilai-nilai Kemanusiaan memiliki lima nilai inti yang menjadi karakteristik manusia, yaitu Kebenaran, 
                Kebajikan, Kasih Sayang, Kedamaian dan Tanpa Kekerasan. Nilai-nilai ini yang dianut serta seluruh sekolah dimulai 
                dari pendidik, penanggung kepentingan (stakeholders), guru, siswa dan seluruh orang tua (wali murid).
            </p>
        </div>

        <!-- Visi Misi -->
        <div class="content-block">
            <h2 class="section-subtitle">Visi & Misi</h2>
            
            <div class="visi-misi-container">
                <div class="visi-box">
                    <div class="vm-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>VISI</h3>
                    <p>
                        "Menumbuhkan Kembangkan Generasi Penerus Bangsa Yang Cerdas, Peduli, 
                        Berkarakter Baik Berdasarkan Nilai-Nilai Kemanusiaan Dan Menjadi Manusia Seutuhnya"
                    </p>
                </div>
                
                <div class="misi-box">
                    <div class="vm-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>MISI</h3>
                    <ul class="misi-list">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Mendirikan dan menyelenggarakan sekolah dalam berbagai jenjang pendidikan yang berbasis pada 
                            nilai-nilai kemanusiaan (kebenaran, kebajikan, kedamaian, cinta kasih dan tanpa kekerasan).</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Mensosialisasikan program pendidikan nilai-nilai kemanusiaan kepada masyarakat luas secara nasional melalui sekolah.</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Menjadikan sekolah sebagai sekolah model yang melaksanakan dan menerapkan pendidikan nilai-nilai 
                            kemanusiaan/pendidikan berkarakter.</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Menyelenggarakan pendidikan yang mengkombinasikan pengembangan budi pekerti dalam proses 
                            kegiatan belajar mengajar disekolah.</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Memberikan kesempatan memperoleh pendidikan bermutu, tanpa biaya dari Orang tua peserta didik 
                            terutama bagi masyarakat kurang mampu.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Filosofi -->
        <div class="content-block">
            <h2 class="section-subtitle">Filosofi Pendidikan</h2>
            <p>
                Orang tua adalah salah satu faktor yang penting dalam kesuksesan program PNK di Sekolah Insan Teladan. 
                Sekolah dan orang tua bekerja sama agar proses pembelajaran anak-anak berjalan lancar baik di sekolah 
                maupun di rumah.
            </p>
            <p>
                Kerjasama yang dilakukan sekolah dengan orang tua dan misi sekolah yaitu "Menumbuhkembangkan Generasi 
                Penerus Bangsa Yang Cerdas, Peduli, Berkarakter Baik Berdasarkan Nilai-Nilai Kemanusiaan dan Menjadi 
                Manusia Seutuhnya".
            </p>
        </div>

        <!-- Keunggulan -->
        <div class="content-block">
            <h2 class="section-subtitle">Keunggulan Kami</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon-box">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <h4>Kurikulum Nasional</h4>
                    <p>Menerapkan kurikulum nasional (KTSP) yang diperkaya dengan pendidikan karakter</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon-box">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h4>Guru Berkualitas</h4>
                    <p>Tenaga pengajar profesional dan berpengalaman di bidangnya</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon-box">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4>Pendidikan Karakter</h4>
                    <p>Fokus pada pembentukan nilai-nilai kemanusiaan dalam setiap aspek pembelajaran</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon-box">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h4>Lingkungan Kondusif</h4>
                    <p>Suasana belajar yang nyaman dan mendukung perkembangan optimal anak</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
