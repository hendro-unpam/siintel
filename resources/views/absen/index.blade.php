@extends('layouts.app')

@section('title', 'Rekap Absensi')
@section('page-title', 'Rekap Absensi')

@push('styles')
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
@endpush

@section('content')
<div class="table-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Rekap Absensi</h5>
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-danger btn-sm" onclick="exportToPDF()">
                    <i class="fas fa-file-pdf me-1"></i> Export PDF
                </button>
                <button type="button" class="btn btn-success btn-sm" onclick="exportToExcel()">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </button>
                <a href="{{ route('absen.input') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Input Absensi
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body p-4">
        {{-- View Mode Toggle --}}
        <ul class="nav nav-pills mb-4" id="viewModeTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="list-view-tab" data-bs-toggle="pill" data-bs-target="#list-view" type="button" role="tab">
                    <i class="fas fa-list me-1"></i> Daftar
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="calendar-view-tab" data-bs-toggle="pill" data-bs-target="#calendar-view" type="button" role="tab">
                    <i class="fas fa-calendar-alt me-1"></i> Kalender
                </button>
            </li>
        </ul>

        <div class="tab-content" id="viewModeTabContent">
            {{-- LIST VIEW --}}
            <div class="tab-pane fade show active" id="list-view" role="tabpanel">
                {{-- Filters --}}
                <form action="{{ route('absen.index') }}" method="GET" class="row g-2 mb-3">
                    <div class="col-md-2">
                        <select name="kelas_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelass as $kelas)
                                <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="date" name="tgl_awal" class="form-control form-control-sm" value="{{ request('tgl_awal', now()->format('Y-m-d')) }}" placeholder="Dari" title="Dari Tanggal">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="fas fa-arrow-right"></i></span>
                            <input type="date" name="tgl_akhir" class="form-control form-control-sm" value="{{ request('tgl_akhir', now()->format('Y-m-d')) }}" placeholder="Sampai" title="Sampai Tanggal">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="ket" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Status --</option>
                            <option value="M" {{ request('ket') == 'M' ? 'selected' : '' }}>Masuk</option>
                            <option value="S" {{ request('ket') == 'S' ? 'selected' : '' }}>Sakit</option>
                            <option value="I" {{ request('ket') == 'I' ? 'selected' : '' }}>Izin</option>
                            <option value="A" {{ request('ket') == 'A' ? 'selected' : '' }}>Alpa</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2 text-end">
                        @if(request()->hasAny(['kelas_id', 'tgl_awal', 'tgl_akhir', 'ket']))
                            <a href="{{ route('absen.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Reset
                            </a>
                        @endif
                    </div>
                </form>

                {{-- Stats Cards --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body py-3 text-center">
                                <h3 class="mb-0">{{ $stats['masuk'] ?? 0 }}</h3>
                                <small>Masuk</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body py-3 text-center">
                                <h3 class="mb-0">{{ $stats['sakit'] ?? 0 }}</h3>
                                <small>Sakit</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body py-3 text-center">
                                <h3 class="mb-0">{{ $stats['izin'] ?? 0 }}</h3>
                                <small>Izin</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body py-3 text-center">
                                <h3 class="mb-0">{{ $stats['alpa'] ?? 0 }}</h3>
                                <small>Alpa</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                                <th>Diubah Oleh</th>
                                <th>Waktu Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absens as $absen)
                            <tr>
                                <td>{{ $absen->tgl->format('d/m/Y') }}</td>
                                <td>{{ $absen->siswa->nama ?? '-' }}</td>
                                <td><span class="badge bg-info">{{ $absen->jadwal->kelas->nama ?? '-' }}</span></td>
                                <td>{{ $absen->jadwal->mataPelajaran->nama_mp ?? '-' }}</td>
                                <td>
                                    @switch($absen->ket)
                                        @case('M')<span class="badge bg-success">Masuk</span>@break
                                        @case('S')<span class="badge bg-warning">Sakit</span>@break
                                        @case('I')<span class="badge bg-info">Izin</span>@break
                                        @case('A')<span class="badge bg-danger">Alpa</span>@break
                                    @endswitch
                                </td>
                                <td>
                                    @if($absen->updated_by_name)
                                        <span class="text-dark">{{ $absen->updated_by_name }}</span>
                                        <small class="text-muted d-block">{{ ucfirst($absen->updated_by_role ?? '-') }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $absen->updated_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    <form action="{{ route('absen.destroy', $absen) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada data absensi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($absens->hasPages())
                <div class="mt-3">{{ $absens->appends(request()->query())->links() }}</div>
                @endif
            </div>

            {{-- CALENDAR VIEW --}}
            <div class="tab-pane fade" id="calendar-view" role="tabpanel">
                @php
                    // Default date range = current month
                    $defaultStart = now()->startOfMonth()->format('Y-m-d');
                    $defaultEnd = now()->endOfMonth()->format('Y-m-d');
                    
                    $calTglAwal = request('cal_tgl_awal', $defaultStart);
                    $calTglAkhir = request('cal_tgl_akhir', $defaultEnd);
                    
                    $queryStart = \Carbon\Carbon::parse($calTglAwal);
                    $queryEnd = \Carbon\Carbon::parse($calTglAkhir);
                    
                    // Calculate months span
                    $monthsDiff = (int) $queryStart->diffInMonths($queryEnd);
                    $currentPage = (int) request('cal_page', 0);
                    
                    // Display month based on page
                    $displayMonth = $queryStart->copy()->addMonths($currentPage);
                    $startOfMonth = $displayMonth->copy()->startOfMonth();
                    $endOfMonth = $displayMonth->copy()->endOfMonth();
                    $startOfCalendar = $startOfMonth->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
                    $endOfCalendar = $endOfMonth->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);
                    
                    // Get absensi counts per day (filtered by kelas and date range)
                    $calAbsenQuery = \App\Models\Absen::selectRaw('DATE(tgl) as tanggal, ket, COUNT(*) as total')
                        ->whereBetween('tgl', [$startOfMonth, $endOfMonth])
                        ->where('tgl', '>=', $queryStart)
                        ->where('tgl', '<=', $queryEnd);
                    
                    if (request('cal_kelas')) {
                        $calAbsenQuery->whereHas('jadwal', fn($q) => $q->where('kelas_id', request('cal_kelas')));
                    }
                    
                    $calendarAbsens = $calAbsenQuery->groupBy('tanggal', 'ket')
                        ->get()
                        ->groupBy('tanggal');
                        
                    // Check if can navigate
                    $canPrev = $currentPage > 0;
                    $canNext = $currentPage < $monthsDiff;
                @endphp

                {{-- Calendar Filters --}}
                <div class="d-flex justify-content-center align-items-center mb-3 flex-wrap gap-2">
                    {{-- Kelas Filter --}}
                    <select id="calKelasPicker" class="form-select form-select-sm" style="width: auto;">
                        <option value="">Semua Kelas</option>
                        @foreach($kelass as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('cal_kelas') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama }}
                            </option>
                        @endforeach
                    </select>
                    
                    <span class="text-muted">|</span>
                    
                    {{-- Date Range --}}
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        <input type="date" id="calTglAwal" class="form-control form-control-sm" value="{{ $calTglAwal }}" title="Dari Tanggal">
                    </div>
                    <span class="text-muted">s/d</span>
                    <div class="input-group input-group-sm" style="width: auto;">
                        <input type="date" id="calTglAkhir" class="form-control form-control-sm" value="{{ $calTglAkhir }}" title="Sampai Tanggal">
                    </div>
                    
                    <button type="button" class="btn btn-primary btn-sm" onclick="applyCalendarFilter()">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    
                    @if(request('cal_kelas') || request('cal_tgl_awal') != $defaultStart || request('cal_tgl_akhir') != $defaultEnd)
                    <a href="{{ route('absen.index', ['view' => 'calendar']) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times"></i> Reset
                    </a>
                    @endif
                </div>

                {{-- Month Navigation (if multi-month range) --}}
                @if($monthsDiff >= 1)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    @if($canPrev)
                    <a href="{{ route('absen.index', ['view' => 'calendar', 'cal_kelas' => request('cal_kelas'), 'cal_tgl_awal' => $calTglAwal, 'cal_tgl_akhir' => $calTglAkhir, 'cal_page' => $currentPage - 1]) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-chevron-left"></i> Sebelumnya
                    </a>
                    @else
                    <span></span>
                    @endif
                    
                    <div class="text-center">
                        <strong class="text-primary">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $displayMonth->translatedFormat('F Y') }}
                        </strong>
                        <small class="text-muted d-block">Halaman {{ $currentPage + 1 }} dari {{ $monthsDiff + 1 }}</small>
                    </div>
                    
                    @if($canNext)
                    <a href="{{ route('absen.index', ['view' => 'calendar', 'cal_kelas' => request('cal_kelas'), 'cal_tgl_awal' => $calTglAwal, 'cal_tgl_akhir' => $calTglAkhir, 'cal_page' => $currentPage + 1]) }}" class="btn btn-outline-secondary btn-sm">
                        Selanjutnya <i class="fas fa-chevron-right"></i>
                    </a>
                    @else
                    <span></span>
                    @endif
                </div>
                @else
                <div class="text-center mb-3">
                    <strong class="text-primary">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $displayMonth->translatedFormat('F Y') }}
                    </strong>
                </div>
                @endif

                {{-- Legend --}}
                <div class="d-flex gap-3 mb-3 justify-content-center">
                    <span><span class="badge bg-success">M</span> Masuk</span>
                    <span><span class="badge bg-warning">S</span> Sakit</span>
                    <span><span class="badge bg-info">I</span> Izin</span>
                    <span><span class="badge bg-danger">A</span> Alpa</span>
                </div>

                {{-- Calendar Grid --}}
                <div class="calendar-container">
                    <div class="table-responsive">
                        <table class="table table-bordered calendar-table mb-0">
                            <thead>
                                <tr class="table-primary">
                                    <th class="text-center">Senin</th>
                                    <th class="text-center">Selasa</th>
                                    <th class="text-center">Rabu</th>
                                    <th class="text-center">Kamis</th>
                                    <th class="text-center">Jumat</th>
                                    <th class="text-center">Sabtu</th>
                                    <th class="text-center text-danger">Minggu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $date = $startOfCalendar->copy(); @endphp
                                @while ($date <= $endOfCalendar)
                                    <tr>
                                        @for ($i = 0; $i < 7; $i++)
                                            @php
                                                $isCurrentMonth = $date->month == $displayMonth->month && $date->year == $displayMonth->year;
                                                $isToday = $date->isToday();
                                                $dateKey = $date->format('Y-m-d');
                                                $dayStats = $calendarAbsens->get($dateKey, collect());
                                            @endphp
                                            <td class="calendar-cell {{ !$isCurrentMonth ? 'other-month' : '' }} {{ $isToday ? 'today' : '' }}">
                                                <div class="date-number {{ $i == 6 ? 'text-danger' : '' }}">{{ $date->day }}</div>
                                                @if($dayStats->count() > 0)
                                                <div class="absen-stats">
                                                    @foreach($dayStats as $stat)
                                                        @php
                                                            $badgeClass = match($stat->ket) {
                                                                'M' => 'bg-success',
                                                                'S' => 'bg-warning',
                                                                'I' => 'bg-info',
                                                                'A' => 'bg-danger',
                                                                default => 'bg-secondary'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }} absen-badge">{{ $stat->ket }}: {{ $stat->total }}</span>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </td>
                                            @php $date->addDay(); @endphp
                                        @endfor
                                    </tr>
                                @endwhile
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .nav-pills .nav-link {
        color: #6b7280;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }

    .nav-pills .nav-link.active {
        background: var(--primary-color);
        color: #fff;
    }

    .calendar-container {
        background: #f8fafc;
        border-radius: 0.75rem;
        padding: 1rem;
    }

    .calendar-table {
        background: #fff;
        table-layout: fixed;
    }

    .calendar-table th {
        padding: 0.75rem;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .calendar-cell {
        vertical-align: top;
        padding: 0.5rem !important;
        min-height: 80px;
        height: 90px;
        background: #fff;
    }

    .calendar-cell.other-month {
        background: #f8fafc;
        opacity: 0.5;
    }

    .calendar-cell.today {
        background: #eff6ff;
        border: 2px solid #3b82f6 !important;
    }

    .date-number {
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
        color: #374151;
    }

    .absen-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 0.2rem;
    }

    .absen-badge {
        font-size: 0.65rem;
        padding: 0.15rem 0.35rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('view') === 'calendar') {
            const calendarTab = document.getElementById('calendar-view-tab');
            if (calendarTab) {
                calendarTab.click();
            }
        }
    });

    function applyCalendarFilter() {
        const kelasEl = document.getElementById('calKelasPicker');
        const tglAwalEl = document.getElementById('calTglAwal');
        const tglAkhirEl = document.getElementById('calTglAkhir');
        
        let url = '{{ route("absen.index") }}?view=calendar';
        if (kelasEl && kelasEl.value) url += '&cal_kelas=' + kelasEl.value;
        if (tglAwalEl && tglAwalEl.value) url += '&cal_tgl_awal=' + tglAwalEl.value;
        if (tglAkhirEl && tglAkhirEl.value) url += '&cal_tgl_akhir=' + tglAkhirEl.value;
        window.location.href = url;
    }

    function exportToExcel() {
        if (typeof XLSX === 'undefined') {
            alert('Library Excel belum dimuat. Periksa koneksi internet Anda.');
            return;
        }

        // Show loading state
        const btn = document.querySelector('button[onclick="exportToExcel()"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Loading...';
        btn.disabled = true;

        // Get current query parameters
        const params = new URLSearchParams(window.location.search);
        const url = `{{ route('absen.export') }}?${params.toString()}`;

        fetch(url)
            .then(response => response.json())
            .then(response => {
                const data = response.data;
                const filters = response.filters;
                const school = response.school;

                // Create header rows
                let headerRows = [
                    [school],
                    ['Rekap Absensi'],
                    ['Tanggal Cetak: ' + new Date().toLocaleDateString('id-ID')],
                    [] // Empty row
                ];

                // Add filters to header
                if (Object.keys(filters).length > 0) {
                    headerRows.push(['Filter:']);
                    for (const [key, value] of Object.entries(filters)) {
                        headerRows.push([key, value]);
                    }
                    headerRows.push([]); // Empty row
                }

                // Create worksheet
                const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerRows.length });
                
                // Add header rows to worksheet
                XLSX.utils.sheet_add_aoa(worksheet, headerRows, { origin: "A1" });

                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Rekap Absensi");
                
                // Auto-width columns
                worksheet["!cols"] = [
                    { wch: 12 }, // Tanggal
                    { wch: 25 }, // Siswa
                    { wch: 10 }, // Kelas
                    { wch: 15 }, // Mapel
                    { wch: 10 }, // Status
                    { wch: 15 }, // Diubah Oleh
                    { wch: 18 }  // Waktu Update
                ];

                XLSX.writeFile(workbook, 'rekap_absensi_{{ now()->format("Y-m-d") }}.xlsx');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengunduh data absensi.');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    }

    function exportToPDF() {
        const table = document.querySelector('#list-view table');
        if (!table) {
            alert('Tabel tidak ditemukan');
            return;
        }

        // Clone table and remove last column
        const clonedTable = table.cloneNode(true);
        const rows = clonedTable.querySelectorAll('tr');
        rows.forEach(row => {
            const cells = row.querySelectorAll('th, td');
            if (cells.length > 0) {
                cells[cells.length - 1].remove();
            }
        });

        // Get filter info from DOM
        let filterInfo = '';
        const kelas = document.querySelector('select[name="kelas_id"] option:checked');
        const tglAwal = document.querySelector('input[name="tgl_awal"]').value;
        const tglAkhir = document.querySelector('input[name="tgl_akhir"]').value;
        const status = document.querySelector('select[name="ket"] option:checked');

        if (kelas && kelas.value) filterInfo += `<p>Kelas: ${kelas.text}</p>`;
        if (tglAwal) filterInfo += `<p>Dari Tanggal: ${tglAwal}</p>`;
        if (tglAkhir) filterInfo += `<p>Sampai Tanggal: ${tglAkhir}</p>`;
        if (status && status.value) filterInfo += `<p>Status: ${status.text}</p>`;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Rekap Absensi - {{ session('sekolah_nama', 'SiIntel') }}</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    h1 { text-align: center; color: #333; font-size: 18px; margin-bottom: 5px; }
                    h2 { text-align: center; color: #666; font-size: 14px; margin-bottom: 20px; }
                    .filters { margin-bottom: 20px; font-size: 12px; color: #444; border-bottom: 1px solid #eee; padding-bottom: 10px; }
                    .filters p { margin: 2px 0; }
                    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 11px; }
                    th { background-color: #4f46e5; color: white; }
                    tr:nth-child(even) { background-color: #f9f9f9; }
                    .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #666; }
                    @media print { body { print-color-adjust: exact; -webkit-print-color-adjust: exact; } }
                </style>
            </head>
            <body>
                <h1>{{ session('sekolah_nama', 'SiIntel') }}</h1>
                <h2>Rekap Absensi</h2>
                <div class="filters">
                    ${filterInfo}
                    <p>Tanggal Cetak: ${new Date().toLocaleDateString('id-ID')}</p>
                </div>
                ${clonedTable.outerHTML}
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
