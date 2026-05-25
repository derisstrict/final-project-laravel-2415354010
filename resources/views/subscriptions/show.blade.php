@extends('layouts.app')

@section('title', 'Detail Subscription #' . $subscription['id'] . '')

@section('content')
@php
$statusColors = [
    'active'   => 'badge-success',
    'inactive' => 'badge-danger',
    'trial'    => 'badge-info',
    'isolir'   => 'badge-warning',
    'dismantle'=> 'badge-secondary',
];
$sc = $statusColors[$subscription['status']] ?? 'badge-secondary';
@endphp

<div class="page-header">
    <div>
        <h1><span class="icon"><x-icon name="clipboard" size="28" /></span> Subscription #{{ $subscription['id'] }}</h1>
        <p>Detail langganan pelanggan</p>
    </div>
    <div class="card" style="display:flex;gap:8px;padding:8px">
        @if ($subscription['status'] != 'dismantle')
            <a href="{{ route('subscriptions.edit', $subscription['id']) }}" class="btn btn-warning"><span class="icon"><x-icon name="pencil" size="18" /></span> Edit</a>
        @endif
        <a href="{{ route('subscriptions.index') }}" class="btn btn-ghost">← Kembali</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
    <!-- Info Customer -->
    <div class="card">
        <div class="card-header">
            <span class="card-title"><span class="icon"><x-icon name="users" size="28" /></span> Customer</span>
        </div>
        <div class="card-body">
            @if($subscription['customer'])
            <div class="detail-grid" style="grid-template-columns:1fr">
                <div class="detail-item">
                    <label>ID Customer</label>
                    <div class="value"><code style="background:var(--surface2);padding:2px 8px;border-radius:4px">{{ $subscription['customer']['customer_id'] }}</code></div>
                </div>
                <div class="detail-item">
                    <label>Nama</label>
                    <div class="value">
                        <a href="{{ route('customers.show', $subscription['customer']['id']) }}" style="color:var(--accent-light);text-decoration:none">
                            {{ $subscription['customer']['name'] }}
                        </a>
                    </div>
                </div>
                <div class="detail-item">
                    <label>Email</label>
                    <div class="value" style="color:var(--text-muted)">{{ $subscription['customer']['email'] ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <label>Telepon</label>
                    <div class="value" style="color:var(--text-muted)">{{ $subscription['customer']['phone'] ?? '-' }}</div>
                </div>
            </div>
            @else
            <p style="color:var(--text-muted)">Data customer tidak tersedia.</p>
            @endif
        </div>
    </div>

    <!-- Info Service -->
    <div class="card">
        <div class="card-header">
            <span class="card-title"><span class="icon"><x-icon name="wrench" size="28" /></span> Layanan</span>
        </div>
        <div class="card-body">
            @if($subscription['service'])
            <div class="detail-grid" style="grid-template-columns:1fr">
                <div class="detail-item">
                    <label>Nama Layanan</label>
                    <div class="value">
                        <a href="{{ route('services.show', $subscription['service']['id']) }}" style="color:var(--accent-light);text-decoration:none">
                            {{ $subscription['service']['name'] }}
                        </a>
                    </div>
                </div>
                <div class="detail-item">
                    <label>Harga</label>
                    <div class="value" style="font-size:20px;font-weight:700;color:var(--accent-light)">
                        Rp {{ number_format($subscription['service']['price'], 0, ',', '.') }}
                    </div>
                </div>
                <div class="detail-item">
                    <label>Deskripsi</label>
                    <div class="value" style="color:var(--text-muted)">{{ Str::limit($subscription['service']['description'] ?? '-', 80) }}</div>
                </div>
            </div>
            @else
            <p style="color:var(--text-muted)">Data service tidak tersedia.</p>
            @endif
        </div>
    </div>
</div>

<!-- Detail Subscription -->
<div class="card" style="margin-top:20px">
    <div class="card-header">
        <span class="card-title"><span class="icon"><x-icon name="chart-bar" size="28" /></span> Detail Langganan</span>
        <span class="badge {{ $sc }}">{{ ucfirst($subscription['status']) }}</span>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <label>Tanggal Mulai</label>
                <div class="value">{{ $subscription['start_date'] ? \Carbon\Carbon::parse($subscription['start_date'])->format('d M Y') : '-' }}</div>
            </div>
            <div class="detail-item">
                <label>Tanggal Selesai</label>
                <div class="value">{{ $subscription['end_date'] ? \Carbon\Carbon::parse($subscription['end_date'])->format('d M Y') : '-' }}</div>
            </div>
            @if($subscription['start_date'] && $subscription['end_date'])
            <div class="detail-item">
                <label>Durasi</label>
                <div class="value">
                    {{ \Carbon\Carbon::parse($subscription['start_date'])->diffInDays(\Carbon\Carbon::parse($subscription['end_date'])) }} hari
                </div>
            </div>
            @endif
            <div class="detail-item">
                <label>Dibuat</label>
                <div class="value" style="color:var(--text-muted);font-size:13px">{{ \Carbon\Carbon::parse($subscription['created_at'])->format('d M Y, H:i') }}</div>
            </div>
            <div class="detail-item">
                <label>Diperbarui</label>
                <div class="value" style="color:var(--text-muted);font-size:13px">{{ \Carbon\Carbon::parse($subscription['updated_at'])->format('d M Y, H:i') }}</div>
            </div>
        </div>

        <div style="margin-top:20px;padding-top:20px;border-top:1px solid var(--border);display:flex;gap:10px">
            <form method="POST" action="{{ route('subscriptions.destroy', $subscription['id']) }}">
                @csrf @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Hapus subscription ini?')"><span class="icon"><x-icon name="trash" size="18" /></span> Hapus Subscription</button>
            </form>
        </div>
    </div>
</div>
@endsection
