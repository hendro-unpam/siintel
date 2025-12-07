@extends('layouts.app')

@section('title', 'Detail Ujian')
@section('page-title', 'Detail Ujian')

@section('content')
<div class="row">
    {{-- Left: Ujian Info --}}
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>{{ $ujian->nama_ujian }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" width="120"><i class="fas fa-tags me-2"></i>Kategori</td>
                        <td><span class="badge bg-secondary">{{ $ujian->kategori->nama_kategori ?? 'Tidak ada' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted" width="120"><i class="fas fa-chalkboard me-2"></i>Kelas</td>
                        <td><strong>{{ $ujian->kelas->nama ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="fas fa-book me-2"></i>Mapel</td>
                        <td>{{ $ujian->mataPelajaran->nama_mp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="fas fa-user-tie me-2"></i>Guru</td>
                        <td>{{ $ujian->guru->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="fas fa-calendar me-2"></i>Tanggal</td>
                        <td>{{ $ujian->tanggal->format('d F Y') }}</td>
                    </tr>
                    @if($ujian->keterangan)
                    <tr>
                        <td class="text-muted"><i class="fas fa-sticky-note me-2"></i>Keterangan</td>
                        <td>{{ $ujian->keterangan }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="card-footer bg-white">
                <div class="d-grid gap-2">
                    <a href="{{ route('ujian.input-nilai', $ujian) }}" class="btn btn-success">
                        <i class="fas fa-keyboard me-2"></i>Input Nilai
                    </a>
                    <a href="{{ route('ujian.edit', $ujian) }}" class="btn btn-outline-warning">
                        <i class="fas fa-edit me-2"></i>Edit Ujian
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Nilai</h6>
            </div>
            <div class="card-body">
                <div class="row text-center g-2">
                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted d-block">Sudah Dinilai</small>
                            <h4 class="mb-0 text-primary">{{ $nilaiStats['count'] }}/{{ $nilaiStats['total'] }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted d-block">Rata-rata</small>
                            <h4 class="mb-0 text-success">{{ number_format($nilaiStats['avg'], 1) }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted d-block">Tertinggi</small>
                            <h4 class="mb-0 text-info">{{ number_format($nilaiStats['max'], 1) }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <small class="text-muted d-block">Terendah</small>
                            <h4 class="mb-0 text-danger">{{ number_format($nilaiStats['min'], 1) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Nilai Table --}}
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list-ol me-2"></i>Daftar Nilai Siswa</h5>
                <div>
                    <button type="button" class="btn btn-danger btn-sm me-2" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </button>
                    <button type="button" class="btn btn-success btn-sm" onclick="exportToExcel()">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="nilai-table">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th width="100" class="text-center">Nilai</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nilaiMap = $ujian->nilais->keyBy('siswa_id');
                            @endphp
                            @forelse($siswaKelas as $index => $siswa)
                            @php
                                $nilaiSiswa = $nilaiMap->get($siswa->id);
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><code>{{ $siswa->nis }}</code></td>
                                <td>{{ $siswa->nama }}</td>
                                <td class="text-center">
                                    @if($nilaiSiswa)
                                        <span class="badge {{ $nilaiSiswa->nilai >= 75 ? 'bg-success' : ($nilaiSiswa->nilai >= 60 ? 'bg-warning' : 'bg-danger') }} fs-6">
                                            {{ number_format($nilaiSiswa->nilai, 1) }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $nilaiSiswa->catatan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">Tidak ada siswa di kelas ini</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('ujian.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Ujian
    </a>
</div>
@endsection

@push('scripts')
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
<script>
    function exportToExcel() {
        if (typeof XLSX === 'undefined') {
            alert('Library Excel belum dimuat. Periksa koneksi internet Anda.');
            return;
        }

        const btn = document.querySelector('button[onclick="exportToExcel()"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Loading...';
        btn.disabled = true;

        const url = "{{ route('ujian.export', $ujian->id) }}";

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.error || 'Terjadi kesalahan server'); });
                }
                return response.json();
            })
            .then(response => {
                const data = response.data;
                const examInfo = response.exam_info;
                const school = response.school;

                // Create header rows
                let headerRows = [
                    [school],
                    ['Daftar Nilai Ujian'],
                    ['Tanggal Cetak: ' + new Date().toLocaleDateString('id-ID')],
                    [] // Empty row
                ];

                // Add exam info to header
                if (Object.keys(examInfo).length > 0) {
                    headerRows.push(['Informasi Ujian:']);
                    for (const [key, value] of Object.entries(examInfo)) {
                        headerRows.push([key, value]);
                    }
                    headerRows.push([]); // Empty row
                }

                // Create worksheet
                const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerRows.length });
                
                // Add header rows to worksheet
                XLSX.utils.sheet_add_aoa(worksheet, headerRows, { origin: "A1" });

                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Nilai Ujian");
                
                // Auto-width columns
                worksheet["!cols"] = [
                    { wch: 5 },  // No
                    { wch: 15 }, // NIS
                    { wch: 30 }, // Nama Siswa
                    { wch: 10 }, // Nilai
                    { wch: 30 }  // Catatan
                ];

                // Generate descriptive filename
                const clean = (str) => (str || '').replace(/[\/\\:*?"<>|]/g, '').replace(/\s+/g, '_');
                const fileName = `Nilai_${clean(examInfo['Nama Ujian'])}_${clean(examInfo['Kelas'])}_${clean(examInfo['Mata Pelajaran'])}.xlsx`;

                XLSX.writeFile(workbook, fileName);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengunduh data nilai: ' + error.message);
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    }

    function exportToPDF() {
        const table = document.getElementById('nilai-table');
        if (!table) {
            alert('Tabel tidak ditemukan');
            return;
        }

        // Clone table to modify for print if needed
        const clonedTable = table.cloneNode(true);
        
        // Prepare exam info HTML
        const examInfoHtml = `
            <table style="width: 100%; margin-bottom: 20px; border: none;">
                <tr>
                    <td width="150"><strong>Nama Ujian</strong></td>
                    <td>: {{ $ujian->nama_ujian }}</td>
                    <td width="150"><strong>Mata Pelajaran</strong></td>
                    <td>: {{ $ujian->mataPelajaran->nama_mp ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Kelas</strong></td>
                    <td>: {{ $ujian->kelas->nama ?? '-' }}</td>
                    <td><strong>Guru</strong></td>
                    <td>: {{ $ujian->guru->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>: {{ $ujian->tanggal->format('d F Y') }}</td>
                    <td><strong>Kategori</strong></td>
                    <td>: {{ $ujian->kategori->nama_kategori ?? '-' }}</td>
                </tr>
            </table>
        `;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Nilai_{{ Str::slug($ujian->nama_ujian) }}_{{ Str::slug($ujian->kelas->nama) }}_{{ Str::slug($ujian->mataPelajaran->nama_mp) }}</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    h1 { text-align: center; color: #333; font-size: 18px; margin-bottom: 5px; }
                    h2 { text-align: center; color: #666; font-size: 14px; margin-bottom: 20px; }
                    .info-table td { padding: 4px; border: none; font-size: 12px; }
                    table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    table.data-table th, table.data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 11px; }
                    table.data-table th { background-color: #4f46e5; color: white; text-align: center; }
                    table.data-table td.text-center { text-align: center; }
                    tr:nth-child(even) { background-color: #f9f9f9; }
                    .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #666; }
                    .badge { padding: 2px 6px; border-radius: 4px; color: white; font-size: 10px; }
                    .bg-success { background-color: #198754; }
                    .bg-warning { background-color: #ffc107; color: #000; }
                    .bg-danger { background-color: #dc3545; }
                    .bg-secondary { background-color: #6c757d; }
                    @media print { body { print-color-adjust: exact; -webkit-print-color-adjust: exact; } }
                </style>
            </head>
            <body>
                <h1>{{ session('sekolah_nama', 'SiIntel') }}</h1>
                <h2>Daftar Nilai Ujian</h2>
                <div class="info-table">
                    ${examInfoHtml}
                </div>
                <table class="data-table">
                    ${clonedTable.innerHTML}
                </table>
                <div class="footer">Dicetak pada: ${new Date().toLocaleString('id-ID')}</div>
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.print();
        };
    }
</script>
@endpush
