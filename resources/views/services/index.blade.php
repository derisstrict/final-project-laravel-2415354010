@extends('layouts.app')

@section('title', 'Services')

@section('content')
<div class="page-header">
    <div>
        <h1><span class="icon"><x-icon name="wrench" size="28" /></span> Services</h1>
        <p>Kelola layanan yang tersedia</p>
    </div>
    <a href="{{ route('services.create') }}" class="btn btn-primary">+ Tambah Service</a>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route('services.index') }}" style="display:flex;gap:10px;align-items:center;width:100%">
        <label style="margin:0;white-space:nowrap">Filter Status:</label>
        <select name="status" class="form-control" style="width:auto" onchange="this.form.submit()">
            <option value="">Semua</option>
            <option value="active"   {{ $status === 'active'   ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        @if($status)
            <a href="{{ route('services.index') }}" class="btn btn-ghost btn-sm">Reset</a>
        @endif
        <span style="margin-left:auto;color:var(--text-muted);font-size:13px">
            {{ count($services) }} service ditemukan
        </span>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Layanan</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $i => $s)
                <tr>
                    <td style="color:var(--text-muted)">{{ $i + 1 }}</td>
                    <td style="font-weight:500">{{ $s['name'] }}</td>
                    <td style="color:var(--text-muted);max-width:240px">
                        <span title="{{ $s['description'] ?? '' }}">
                            {{ Str::limit($s['description'] ?? '-', 60) }}
                        </span>
                    </td>
                    <td style="font-weight:600;color:var(--accent-light)">
                        Rp {{ number_format($s['price'], 0, ',', '.') }}
                    </td>
                    <td>
                        @if($s['status'])
                            <span class="badge badge-success">● Aktif</span>
                        @else
                            <span class="badge badge-danger">● Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('services.show', $s['id']) }}" class="btn btn-secondary btn-sm">Detail</a>
                            <a href="{{ route('services.edit', $s['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                            @if($s['status'])
                                <form method="POST" action="{{ route('services.deactivate', $s['id']) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-ghost btn-sm" onclick="return confirm('Nonaktifkan service ini?')">Nonaktifkan</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('services.activate', $s['id']) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-ghost btn-sm">Aktifkan</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('services.destroy', $s['id']) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus service {{ $s['name'] }}?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <span class="icon"><x-icon name="wrench" size="28" /></span>
                            <p>Belum ada service. <a href="{{ route('services.create') }}" style="color:var(--accent)">Tambahkan sekarang</a></p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
