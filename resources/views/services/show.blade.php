@extends('layouts.app')

@section('title', $service['name'] . ' - Service Detail')

@section('content')
<div class="page-header">
    <div>
        <h1><span class="icon"><x-icon name="wrench" size="28" /></span> {{ $service['name'] }}</h1>
        <p>Detail informasi layanan</p>
    </div>
    <div class="card" style="display:flex;gap:8px;padding:8px;">
        <a href="{{ route('services.edit', $service['id']) }}" class="btn btn-warning"><span class="icon"><x-icon name="pencil" size="18" /></span> Edit</a>
        <a href="{{ route('services.index') }}" class="btn btn-ghost">← Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title">Informasi Service</span>
        <div class="action-group">
            @if($service['status'])
                <span class="badge badge-success">● Aktif</span>
                <form method="POST" action="{{ route('services.deactivate', $service['id']) }}" style="margin:0">
                    @csrf @method('PATCH')
                    <button class="btn btn-ghost btn-sm" onclick="return confirm('Nonaktifkan service ini?')">Nonaktifkan</button>
                </form>
            @else
                <span class="badge badge-danger">● Nonaktif</span>
                <form method="POST" action="{{ route('services.activate', $service['id']) }}" style="margin:0">
                    @csrf @method('PATCH')
                    <button class="btn btn-success btn-sm">Aktifkan</button>
                </form>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <label>ID</label>
                <div class="value">#{{ $service['id'] }}</div>
            </div>
            <div class="detail-item">
                <label>Nama Layanan</label>
                <div class="value">{{ $service['name'] }}</div>
            </div>
            <div class="detail-item">
                <label>Harga</label>
                <div class="value" style="color:var(--accent-light);font-size:20px;font-weight:700">
                    Rp {{ number_format($service['price'], 0, ',', '.') }}
                </div>
            </div>
            <div class="detail-item">
                <label>Status</label>
                <div class="value">
                    @if($service['status'])
                        <span class="badge badge-success">● Aktif</span>
                    @else
                        <span class="badge badge-danger">● Nonaktif</span>
                    @endif
                </div>
            </div>
            <div class="detail-item" style="grid-column:1/-1">
                <label>Deskripsi</label>
                <div class="value" style="color:var(--text-muted);line-height:1.6">{{ $service['description'] ?? '-' }}</div>
            </div>
            <div class="detail-item">
                <label>Dibuat</label>
                <div class="value" style="color:var(--text-muted);font-size:13px">{{ \Carbon\Carbon::parse($service['created_at'])->format('d M Y, H:i') }}</div>
            </div>
            <div class="detail-item">
                <label>Diperbarui</label>
                <div class="value" style="color:var(--text-muted);font-size:13px">{{ \Carbon\Carbon::parse($service['updated_at'])->format('d M Y, H:i') }}</div>
            </div>
        </div>

        <div style="margin-top:20px;padding-top:20px;border-top:1px solid var(--border);display:flex;gap:10px">
            <form method="POST" action="{{ route('services.destroy', $service['id']) }}">
                @csrf @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Hapus service {{ $service['name'] }}? Pastikan tidak ada subscription terkait.')"><span class="icon"><x-icon name="trash" size="18" /></span> Hapus Service</button>
            </form>
        </div>
    </div>
</div>
@endsection
