@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')
@section('page-title', 'Jadwal Pelajaran')

@section('content')
<div class="table-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i>Data Jadwal
            </h5>
            <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Jadwal
            </a>
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
                    <i class="fas fa-th me-1"></i> Kalender
                </button>
            </li>
        </ul>

        <div class="tab-content" id="viewModeTabContent">
            {{-- LIST VIEW --}}
            <div class="tab-pane fade show active" id="list-view" role="tabpanel">
                {{-- Tab Hari --}}
                <ul class="nav nav-tabs" id="jadwalTab" role="tablist">
                    @foreach ($haris as $hari)
                        <li class="nav-item" role="presentation">
                            <button 
                                class="nav-link {{ ($selectedHari ?? $haris->first()->id) == $hari->id ? 'active' : '' }}"
                                id="hari{{ $hari->id }}-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#hari{{ $hari->id }}"
                                type="button"
                                role="tab"
                            >
                                {{ $hari->hari }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                {{-- Filter & Per Page --}}
                <div class="row g-2 mt-3 mb-3">
                    <div class="col-md-3">
                        <select id="perPage" class="form-select form-select-sm" onchange="updatePerPage(this.value)">
                            @foreach ([10, 25, 50, 100] as $size)
                                <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                                    {{ $size }} records per page
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-4">
                        <input 
                            type="text" 
                            id="searchInput" 
                            class="form-control form-control-sm" 
                            placeholder="Search..." 
                            onkeyup="filterTable()"
                        >
                    </div>
                </div>

                {{-- Tab Content --}}
                <div class="tab-content" id="jadwalTabContent">
                    @foreach ($haris as $hari)
                        @php
                            $jadwalHari = $jadwals->where('hari_id', $hari->id)->sortBy('jam_mulai');
                        @endphp

                        <div 
                            class="tab-pane fade {{ ($selectedHari ?? $haris->first()->id) == $hari->id ? 'show active' : '' }}"
                            id="hari{{ $hari->id }}"
                            role="tabpanel"
                        >
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered mb-0 jadwal-table" id="table-hari{{ $hari->id }}">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Hari</th>
                                            <th>Jam</th>
                                            <th>Kelas</th>
                                            <th>Guru</th>
                                            <th>Mata Pelajaran</th>
                                            <th width="130">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($jadwalHari as $jadwal)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $jadwal->hari->hari }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                </td>
                                                <td>{{ $jadwal->kelas->nama ?? '-' }}</td>
                                                <td>{{ $jadwal->guru->nama ?? '-' }}</td>
                                                <td>{{ $jadwal->mataPelajaran->nama_mp ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('jadwal.edit', $jadwal) }}" class="btn btn-info btn-sm">
                                                        Edit
                                                    </a>
                                                    <form 
                                                        action="{{ route('jadwal.destroy', $jadwal) }}" 
                                                        method="POST" 
                                                        class="d-inline"
                                                        onsubmit="return confirm('Yakin hapus?')"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-3 text-muted">
                                                    Tidak ada jadwal untuk hari {{ $hari->hari }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-2">
                                <small class="text-muted">Showing {{ $jadwalHari->count() }} entries</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- CALENDAR VIEW --}}
            <div class="tab-pane fade" id="calendar-view" role="tabpanel">
                {{-- Filter by Kelas --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Filter Kelas:</label>
                        <select id="filterKelas" class="form-select form-select-sm" onchange="filterCalendar()">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelass ?? [] as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Weekly Scheduler Grid --}}
                <div class="scheduler-container">
                    <div class="table-responsive">
                        <table class="table table-bordered scheduler-table mb-0">
                            <thead>
                                <tr class="table-primary">
                                    <th class="time-column">Jam</th>
                                    @foreach($haris as $hari)
                                        <th class="day-column text-center">{{ $hari->hari }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Generate time slots from 07:00 to 16:00
                                    $timeSlots = [];
                                    for ($h = 7; $h <= 15; $h++) {
                                        $timeSlots[] = sprintf('%02d:00', $h);
                                    }
                                @endphp

                                @foreach($timeSlots as $timeSlot)
                                    <tr class="scheduler-row" data-time="{{ $timeSlot }}">
                                        <td class="time-cell">{{ $timeSlot }}</td>
                                        @foreach($haris as $hari)
                                            @php
                                                // Find jadwal that falls within this time slot
                                                $slotJadwals = $jadwals->filter(function($j) use ($hari, $timeSlot) {
                                                    if ($j->hari_id != $hari->id) return false;
                                                    $jamMulai = \Carbon\Carbon::parse($j->jam_mulai)->format('H:00');
                                                    return $jamMulai == $timeSlot;
                                                });
                                            @endphp
                                            <td class="schedule-cell" data-hari="{{ $hari->id }}" data-time="{{ $timeSlot }}">
                                                @php
                                                    // Bright solid colors array
                                                    $colors = [
                                                        '#FF6B6B', // Coral Red
                                                        '#4ECDC4', // Teal
                                                        '#45B7D1', // Sky Blue
                                                        '#96CEB4', // Sage Green
                                                        '#FFEAA7', // Soft Yellow
                                                        '#DDA0DD', // Plum
                                                        '#98D8C8', // Mint
                                                        '#F7DC6F', // Warm Yellow
                                                        '#BB8FCE', // Lavender
                                                        '#85C1E9', // Light Blue
                                                        '#F8B500', // Golden
                                                        '#00CED1', // Dark Cyan
                                                    ];
                                                @endphp
                                                @foreach($slotJadwals as $jadwal)
                                                    @php
                                                        $colorIndex = ($jadwal->mata_pelajaran_id ?? 0) % count($colors);
                                                        $bgColor = $colors[$colorIndex];
                                                        // Determine text color based on background brightness
                                                        $textColor = in_array($bgColor, ['#FFEAA7', '#F7DC6F', '#96CEB4', '#98D8C8']) ? '#333' : '#fff';
                                                    @endphp
                                                    <div class="schedule-item" 
                                                         data-kelas="{{ $jadwal->kelas_id }}"
                                                         data-id="{{ $jadwal->id }}"
                                                         data-edit-url="{{ route('jadwal.edit', $jadwal) }}"
                                                         data-tooltip="<strong>{{ $jadwal->mataPelajaran->nama_mp ?? '-' }}</strong><br>Kelas: {{ $jadwal->kelas->nama ?? '-' }}<br>Guru: {{ $jadwal->guru->nama ?? '-' }}<br>Jam: {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}"
                                                         ondblclick="window.location.href='{{ route('jadwal.edit', $jadwal) }}'"
                                                         style="background: {{ $bgColor }}; color: {{ $textColor }}; cursor: pointer;">
                                                        <div class="schedule-time">
                                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                        </div>
                                                        <div class="schedule-mapel">{{ $jadwal->mataPelajaran->nama_mp ?? '-' }}</div>
                                                        <div class="schedule-kelas">{{ $jadwal->kelas->nama ?? '-' }}</div>
                                                        <div class="schedule-guru">{{ $jadwal->guru->nama ?? '-' }}</div>
                                                    </div>
                                                @endforeach
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="mt-3 d-flex gap-3 flex-wrap">
                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Klik item jadwal untuk melihat detail</small>
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

    .nav-tabs .nav-link {
        color: #6b7280;
        border: 1px solid transparent;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        padding: 0.75rem 1.25rem;
    }

    .nav-tabs .nav-link:hover {
        border-color: #e5e7eb #e5e7eb #dee2e6;
    }

    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        font-weight: 600;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    .jadwal-table th {
        font-size: 0.85rem;
        font-weight: 600;
    }

    .jadwal-table td {
        vertical-align: middle;
    }

    /* Scheduler Styles */
    .scheduler-container {
        background: #f8fafc;
        border-radius: 0.75rem;
        padding: 1rem;
    }

    .scheduler-table {
        background: #fff;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .scheduler-table th {
        padding: 0.75rem;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .time-column {
        width: 80px;
        background: #f1f5f9 !important;
    }

    .day-column {
        min-width: 140px;
    }

    .time-cell {
        font-weight: 700;
        font-size: 0.9rem;
        color: #fff;
        background: linear-gradient(180deg, #6366f1 0%, #4f46e5 100%);
        text-align: center;
        vertical-align: middle;
        padding: 0.75rem 0.5rem !important;
        border-radius: 0;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }

    .schedule-cell {
        vertical-align: top;
        padding: 0.25rem !important;
        min-height: 60px;
        background: #fff;
    }

    .schedule-item {
        padding: 0.5rem;
        border-radius: 0.5rem;
        margin-bottom: 0.25rem;
        color: #fff;
        font-size: 0.75rem;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .schedule-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .schedule-time {
        font-size: 0.7rem;
        font-weight: 600;
        background: rgba(0,0,0,0.2);
        margin: -0.5rem -0.5rem 0.4rem -0.5rem;
        padding: 0.35rem 0.5rem;
        border-radius: 0.5rem 0.5rem 0 0;
        letter-spacing: 0.3px;
    }

    .schedule-mapel {
        font-weight: 700;
        font-size: 0.8rem;
        margin: 0.15rem 0;
    }

    .schedule-kelas {
        font-size: 0.7rem;
        background: rgba(0,0,0,0.15);
        padding: 0.1rem 0.4rem;
        border-radius: 0.25rem;
        display: inline-block;
    }

    .schedule-guru {
        font-size: 0.65rem;
        opacity: 0.85;
        margin-top: 0.15rem;
    }

    .scheduler-row:nth-child(even) .schedule-cell {
        background: #fafbfc;
    }

    /* Tooltip styles */
    .schedule-tooltip {
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

    .schedule-tooltip.show {
        opacity: 1;
    }

    .schedule-tooltip strong {
        color: #60a5fa;
        font-size: 0.9rem;
    }

    .schedule-item:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        z-index: 10;
        position: relative;
    }

    .schedule-hint {
        font-size: 0.65rem;
        opacity: 0.7;
        text-align: center;
        margin-top: 0.25rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const activeTab = document.querySelector('#jadwalTabContent .tab-pane.active');
        if (!activeTab) return;
        const table = activeTab.querySelector('table');
        if (!table) return;
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    }

    function updatePerPage(value) {
        console.log('Per page:', value);
    }

    function filterCalendar() {
        const kelasId = document.getElementById('filterKelas').value;
        const items = document.querySelectorAll('.schedule-item');

        items.forEach(item => {
            if (!kelasId || item.dataset.kelas == kelasId) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Tooltip functionality with 3 second delay
    document.addEventListener('DOMContentLoaded', function() {
        // Create tooltip element
        const tooltip = document.createElement('div');
        tooltip.className = 'schedule-tooltip';
        document.body.appendChild(tooltip);

        let hoverTimeout = null;
        let currentItem = null;
        let mouseX = 0;
        let mouseY = 0;

        // Add event listeners to schedule items
        document.querySelectorAll('.schedule-item').forEach(item => {
            item.addEventListener('mouseenter', function(e) {
                currentItem = this;
                mouseX = e.clientX;
                mouseY = e.clientY;
                
                // Clear any existing timeout
                if (hoverTimeout) clearTimeout(hoverTimeout);
                
                // Set 3 second delay
                hoverTimeout = setTimeout(() => {
                    const content = currentItem.dataset.tooltip;
                    if (content) {
                        tooltip.innerHTML = content + '<div class="schedule-hint mt-2"><i class="fas fa-mouse me-1"></i>Double-click untuk edit</div>';
                        tooltip.style.left = (mouseX + 15) + 'px';
                        tooltip.style.top = (mouseY + 15) + 'px';
                        tooltip.classList.add('show');
                    }
                }, 3000); // 3 seconds
            });

            item.addEventListener('mousemove', function(e) {
                mouseX = e.clientX;
                mouseY = e.clientY;
                
                // Update tooltip position if visible
                if (tooltip.classList.contains('show')) {
                    tooltip.style.left = (e.clientX + 15) + 'px';
                    tooltip.style.top = (e.clientY + 15) + 'px';
                }
            });

            item.addEventListener('mouseleave', function() {
                // Clear timeout and hide tooltip
                if (hoverTimeout) clearTimeout(hoverTimeout);
                tooltip.classList.remove('show');
                currentItem = null;
            });
        });
    });
</script>
@endpush
