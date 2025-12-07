@extends('layouts.app')

@section('title', 'Data Ujian')
@section('page-title', 'Data Ujian')

@section('content')
<div class="table-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Daftar Ujian</h5>
            <div class="btn-group">
                <a href="{{ route('ujian-kategori.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-tags me-1"></i> Kategori
                </a>
                <a href="{{ route('ujian.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Ujian
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
                <form action="{{ route('ujian.index') }}" method="GET" class="row g-2 mb-3">
                    <div class="col-md-3">
                        <select name="kategori_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="kelas_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelass as $kelas)
                                <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="mata_pelajaran_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Mapel --</option>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}" {{ request('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama_mp }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-md-end">
                        @if(request()->hasAny(['kelas_id', 'mata_pelajaran_id', 'kategori_id']))
                            <a href="{{ route('ujian.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Reset Filter
                            </a>
                        @endif
                    </div>
                </form>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Ujian</th>
                                <th>Kategori</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Tanggal</th>
                                <th width="140">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ujians as $index => $ujian)
                            <tr>
                                <td>{{ $ujians->firstItem() + $index }}</td>
                                <td><strong>{{ $ujian->nama_ujian }}</strong></td>
                                <td>
                                    @if($ujian->kategori)
                                        <span class="badge bg-secondary">{{ $ujian->kategori->nama_kategori }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-info">{{ $ujian->kelas->nama ?? '-' }}</span></td>
                                <td>{{ $ujian->mataPelajaran->nama_mp ?? '-' }}</td>
                                <td>{{ $ujian->tanggal->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('ujian.show', $ujian) }}" class="btn btn-outline-info" title="Detail & Nilai">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('ujian.input-nilai', $ujian) }}" class="btn btn-outline-success" title="Input Nilai">
                                            <i class="fas fa-keyboard"></i>
                                        </a>
                                        <a href="{{ route('ujian.edit', $ujian) }}" class="btn btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('ujian.destroy', $ujian) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus ujian ini? Semua nilai akan ikut terhapus!')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data ujian</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($ujians->hasPages())
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan {{ $ujians->firstItem() }} - {{ $ujians->lastItem() }} dari {{ $ujians->total() }}</small>
                    {{ $ujians->links() }}
                </div>
                @endif
            </div>

            {{-- CALENDAR VIEW --}}
            <div class="tab-pane fade" id="calendar-view" role="tabpanel">
                @php
                    // Get current month/year from request or use current
                    $currentMonth = request('month', now()->month);
                    $currentYear = request('year', now()->year);
                    $startOfMonth = \Carbon\Carbon::create($currentYear, $currentMonth, 1);
                    $endOfMonth = $startOfMonth->copy()->endOfMonth();
                    $startOfCalendar = $startOfMonth->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
                    $endOfCalendar = $endOfMonth->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);
                    
                    // Get all ujians for this month (bypass pagination for calendar)
                    $calendarUjians = \App\Models\Ujian::with(['kelas', 'mataPelajaran', 'kategori'])
                        ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                        ->orderBy('tanggal')
                        ->get();
                    
                    // Bright colors
                    $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E9', '#F8B500', '#00CED1'];
                @endphp

                {{-- Month Navigation --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('ujian.index', ['month' => $startOfMonth->copy()->subMonth()->month, 'year' => $startOfMonth->copy()->subMonth()->year, 'view' => 'calendar']) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-chevron-left"></i> Sebelumnya
                    </a>
                    
                    {{-- Month/Year Picker --}}
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-calendar text-primary"></i>
                        <select id="monthPicker" class="form-select form-select-sm" style="width: auto;" onchange="goToMonth()">
                            @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $bulan)
                                <option value="{{ $index + 1 }}" {{ $currentMonth == ($index + 1) ? 'selected' : '' }}>{{ $bulan }}</option>
                            @endforeach
                        </select>
                        <select id="yearPicker" class="form-select form-select-sm" style="width: auto;" onchange="goToMonth()">
                            @for($y = now()->year - 5; $y <= now()->year + 5; $y++)
                                <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <a href="{{ route('ujian.index', ['month' => $startOfMonth->copy()->addMonth()->month, 'year' => $startOfMonth->copy()->addMonth()->year, 'view' => 'calendar']) }}" class="btn btn-outline-secondary btn-sm">
                        Selanjutnya <i class="fas fa-chevron-right"></i>
                    </a>
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
                                                $isCurrentMonth = $date->month == $currentMonth;
                                                $isToday = $date->isToday();
                                                $dayUjians = $calendarUjians->filter(fn($u) => $u->tanggal->isSameDay($date));
                                            @endphp
                                            <td class="calendar-cell {{ !$isCurrentMonth ? 'other-month' : '' }} {{ $isToday ? 'today' : '' }}">
                                                <div class="date-number {{ $i == 6 ? 'text-danger' : '' }}">{{ $date->day }}</div>
                                                <div class="calendar-events">
                                                    @foreach($dayUjians as $ujian)
                                                        @php
                                                            $colorIndex = ($ujian->mata_pelajaran_id ?? 0) % count($colors);
                                                            $bgColor = $colors[$colorIndex];
                                                            $textColor = in_array($bgColor, ['#FFEAA7', '#F7DC6F', '#96CEB4', '#98D8C8']) ? '#333' : '#fff';
                                                        @endphp
                                                        <div class="calendar-event" 
                                                             style="background: {{ $bgColor }}; color: {{ $textColor }};"
                                                             data-id="{{ $ujian->id }}"
                                                             data-tooltip="<strong>{{ $ujian->nama_ujian }}</strong><br>Kategori: {{ $ujian->kategori->nama_kategori ?? '-' }}<br>Kelas: {{ $ujian->kelas->nama ?? '-' }}<br>Mapel: {{ $ujian->mataPelajaran->nama_mp ?? '-' }}"
                                                             ondblclick="window.location.href='{{ route('ujian.edit', $ujian) }}'">
                                                            <div class="event-time">{{ $ujian->kategori->nama_kategori ?? 'Ujian' }}</div>
                                                            <div class="event-title">{{ Str::limit($ujian->nama_ujian, 20) }}</div>
                                                            <div class="event-kelas">{{ $ujian->kelas->nama ?? '-' }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            @php $date->addDay(); @endphp
                                        @endfor
                                    </tr>
                                @endwhile
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Hover 3 detik untuk detail, double-click untuk edit</small>
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

    /* Calendar styles */
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
        min-height: 100px;
        height: 120px;
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

    .calendar-events {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .calendar-event {
        padding: 0.4rem;
        border-radius: 0.4rem;
        font-size: 0.7rem;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .calendar-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10;
        position: relative;
    }

    .event-time {
        font-size: 0.65rem;
        font-weight: 600;
        background: rgba(0,0,0,0.2);
        margin: -0.4rem -0.4rem 0.25rem -0.4rem;
        padding: 0.2rem 0.4rem;
        border-radius: 0.4rem 0.4rem 0 0;
    }

    .event-title {
        font-weight: 700;
        font-size: 0.75rem;
    }

    .event-kelas {
        font-size: 0.6rem;
        opacity: 0.85;
    }

    /* Tooltip styles */
    .calendar-tooltip {
        position: fixed;
        background: #1e293b;
        color: #fff;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        max-width: 250px;
        z-index: 9999;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .calendar-tooltip.show {
        opacity: 1;
    }

    .calendar-tooltip strong {
        color: #60a5fa;
        font-size: 0.9rem;
    }

    .calendar-hint {
        font-size: 0.65rem;
        opacity: 0.7;
        text-align: center;
        margin-top: 0.25rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Tooltip functionality with 3 second delay
    document.addEventListener('DOMContentLoaded', function() {
        const tooltip = document.createElement('div');
        tooltip.className = 'calendar-tooltip';
        document.body.appendChild(tooltip);

        let hoverTimeout = null;
        let currentItem = null;
        let mouseX = 0;
        let mouseY = 0;

        document.querySelectorAll('.calendar-event').forEach(item => {
            item.addEventListener('mouseenter', function(e) {
                currentItem = this;
                mouseX = e.clientX;
                mouseY = e.clientY;
                
                if (hoverTimeout) clearTimeout(hoverTimeout);
                
                hoverTimeout = setTimeout(() => {
                    const content = currentItem.dataset.tooltip;
                    if (content) {
                        tooltip.innerHTML = content + '<div class="calendar-hint mt-2"><i class="fas fa-mouse me-1"></i>Double-click untuk edit</div>';
                        tooltip.style.left = (mouseX + 15) + 'px';
                        tooltip.style.top = (mouseY + 15) + 'px';
                        tooltip.classList.add('show');
                    }
                }, 3000);
            });

            item.addEventListener('mousemove', function(e) {
                mouseX = e.clientX;
                mouseY = e.clientY;
                
                if (tooltip.classList.contains('show')) {
                    tooltip.style.left = (e.clientX + 15) + 'px';
                    tooltip.style.top = (e.clientY + 15) + 'px';
                }
            });

            item.addEventListener('mouseleave', function() {
                if (hoverTimeout) clearTimeout(hoverTimeout);
                tooltip.classList.remove('show');
                currentItem = null;
            });
        });

        // Auto-switch to calendar tab if view=calendar in URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('view') === 'calendar') {
            const calendarTab = document.getElementById('calendar-view-tab');
            if (calendarTab) {
                calendarTab.click();
            }
        }
    });

    // Navigate to selected month/year
    function goToMonth() {
        const month = document.getElementById('monthPicker').value;
        const year = document.getElementById('yearPicker').value;
        window.location.href = '{{ route("ujian.index") }}?month=' + month + '&year=' + year + '&view=calendar';
    }
</script>
@endpush
