@extends(request()->is('web-admin/*') ? 'layouts.web-admin' : 'layouts.app')

@section('content')
<div class="container-fluid px-4">
    @php
        $isWebAdmin = request()->is('web-admin/*');
        $routePrefix = $isWebAdmin ? 'webadmin.' : '';
    @endphp
    <h1 class="mt-4">Edit Prestasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ $isWebAdmin ? route('webadmin.dashboard') : route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route($routePrefix . 'prestasi.index') }}">Prestasi</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> Form Edit Prestasi
        </div>
        <div class="card-body">
            <form action="{{ route($routePrefix . 'prestasi.update', $prestasi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Prestasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $prestasi->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="akademik" {{ old('kategori', $prestasi->kategori) == 'akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="non_akademik" {{ old('kategori', $prestasi->kategori) == 'non_akademik' ? 'selected' : '' }}>Non-Akademik</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Pilih Kelas <span class="text-danger">*</span></label>
                            <select class="form-select @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" data-nama="{{ $k->nama }}" {{ old('kelas_id', $prestasi->kelas_id ?? '') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="siswa_id" class="form-label">Pilih Siswa</label>
                            <select class="form-select @error('siswa_id') is-invalid @enderror" id="siswa_id" name="siswa_id">
                                <option value="">-- Pilih Kelas Dulu --</option>
                            </select>
                            @error('siswa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Opsional: Pilih siswa dari kelas atau input manual di bawah</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_siswa" class="form-label">Nama Siswa/Tim <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa', $prestasi->nama_siswa) }}" required>
                            <div class="form-text">Nama otomatis terisi jika memilih siswa, atau input manual untuk tim/kelompok</div>
                            @error('nama_siswa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas', $prestasi->kelas) }}" required>
                            <div class="form-text">Kelas otomatis terisi jika memilih kelas di atas</div>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Prestasi <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $prestasi->tanggal->format('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Foto Dokumentasi</label>
                    <div class="row">
                        <div class="col-md-8">
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*" onchange="previewImage(this)">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG, GIF. Max: 2MB</div>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div id="imagePreviewContainer" style="border: 2px dashed #ddd; border-radius: 8px; padding: 10px; text-align: center; min-height: 150px; display: flex; align-items: center; justify-content: center;">
                                @if($prestasi->gambar)
                                    <img id="imagePreview" src="{{ asset('storage/' . $prestasi->gambar) }}" alt="Preview" style="max-width: 100%; max-height: 150px; border-radius: 8px;">
                                @else
                                    <span id="noPreview" style="color: #999;"><i class="fas fa-image fa-3x"></i><br>Preview Gambar</span>
                                    <img id="imagePreview" src="" alt="Preview" style="max-width: 100%; max-height: 150px; border-radius: 8px; display: none;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan detail pencapaian prestasi...">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Prestasi</button>
                    <a href="{{ route($routePrefix . 'prestasi.index') }}" class="btn btn-secondary"><i class="fas fa-times me-1"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview image before upload
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const noPreview = document.getElementById('noPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (noPreview) noPreview.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Load siswa when kelas changes
document.getElementById('kelas_id').addEventListener('change', function() {
    const kelasId = this.value;
    const kelasNama = this.options[this.selectedIndex].dataset.nama || '';
    const siswaSelect = document.getElementById('siswa_id');
    const kelasInput = document.getElementById('kelas');
    
    // Update kelas text input
    if (kelasNama) {
        kelasInput.value = kelasNama;
    }
    
    // Clear siswa dropdown
    siswaSelect.innerHTML = '<option value="">-- Memuat siswa... --</option>';
    
    if (kelasId) {
        // Fetch siswa by kelas
        fetch(`/api/kelas/${kelasId}/siswa`)
            .then(response => response.json())
            .then(data => {
                siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
                data.forEach(siswa => {
                    const option = document.createElement('option');
                    option.value = siswa.id;
                    option.textContent = siswa.nama + ' (' + siswa.nis + ')';
                    option.dataset.nama = siswa.nama;
                    siswaSelect.appendChild(option);
                });
            })
            .catch(() => {
                siswaSelect.innerHTML = '<option value="">-- Tidak ada siswa --</option>';
            });
    } else {
        siswaSelect.innerHTML = '<option value="">-- Pilih Kelas Dulu --</option>';
    }
});

// Auto-fill nama_siswa when siswa selected
document.getElementById('siswa_id').addEventListener('change', function() {
    const namaSiswa = this.options[this.selectedIndex].dataset.nama || '';
    if (namaSiswa) {
        document.getElementById('nama_siswa').value = namaSiswa;
    }
});
</script>
@endsection
