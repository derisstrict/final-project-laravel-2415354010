@extends('layouts.app')

@section('title', $customer['name'] . ' - Customer Detail')

@section('content')
<div class="page-header">
    <div>
        <h1><span class="icon"><x-icon name="users" size="28" /></span> {{ $customer['name'] }}</h1>
        <p>Detail informasi customer</p>
    </div>
    <div class="card" style="display:flex;gap:8px;padding:8px">
        <a href="{{ route('customers.edit', $customer['id']) }}" class="btn btn-warning"><span class="icon"><x-icon name="pencil" size="18" /></span> Edit</a>
        <a href="{{ route('customers.index') }}" class="btn btn-ghost">← Kembali</a>
    </div>
</div>

<div class="card" style="margin-bottom:20px">
    <div class="card-header">
        <span class="card-title">Informasi Customer</span>
        <div class="action-group">
            @if($customer['status'])
                <span class="badge badge-success">● Aktif</span>
                <form method="POST" action="{{ route('customers.deactivate', $customer['id']) }}" style="margin:0">
                    @csrf @method('PATCH')
                    <button class="btn btn-ghost btn-sm" onclick="return confirm('Nonaktifkan customer ini?')">Nonaktifkan</button>
                </form>
            @else
                <span class="badge badge-danger">● Nonaktif</span>
                <form method="POST" action="{{ route('customers.activate', $customer['id']) }}" style="margin:0">
                    @csrf @method('PATCH')
                    <button class="btn btn-success btn-sm">Aktifkan</button>
                </form>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <label>Customer ID</label>
                <div class="value"><code style="background:var(--surface2);padding:3px 10px;border-radius:6px">{{ $customer['customer_id'] }}</code></div>
            </div>
            <div class="detail-item">
                <label>Nama</label>
                <div class="value">{{ $customer['name'] }}</div>
            </div>
            <div class="detail-item">
                <label>Email</label>
                <div class="value" style="color:var(--text-muted)">{{ $customer['email'] ?? '-' }}</div>
            </div>
            <div class="detail-item">
                <label>Telepon</label>
                <div class="value" style="color:var(--text-muted)">{{ $customer['phone'] ?? '-' }}</div>
            </div>
            <div class="detail-item" style="grid-column:1/-1">
                <label>Alamat</label>
                <div class="value" style="color:var(--text-muted)">{{ $customer['address'] ?? '-' }}</div>
            </div>
            <div class="detail-item">
                <label>Dibuat</label>
                <div class="value" style="color:var(--text-muted);font-size:13px">{{ \Carbon\Carbon::parse($customer['created_at'])->format('d M Y, H:i') }}</div>
            </div>
            <div class="detail-item">
                <label>Diperbarui</label>
                <div class="value" style="color:var(--text-muted);font-size:13px">{{ \Carbon\Carbon::parse($customer['updated_at'])->format('d M Y, H:i') }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Subscriptions terkait -->
<div class="card">
    <div class="card-header">
        <span class="card-title"><span class="icon"><x-icon name="clipboard" size="28" /></span> Subscriptions ({{ count($subscriptions) }})</span>
        <a href="{{ route('subscriptions.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Layanan</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscriptions as $i => $s)
                @php
                    $statusColors = [
                        'active'   => 'badge-success',
                        'inactive' => 'badge-danger',
                        'trial'    => 'badge-info',
                        'isolir'   => 'badge-warning',
                        'dismantle'=> 'badge-secondary',
                    ];
                    $sc = $statusColors[$s['status']] ?? 'badge-secondary';
                @endphp
                <tr>
                    <td style="color:var(--text-muted)">{{ $i + 1 }}</td>
                    <td style="font-weight:500">{{ $s['service']['name'] ?? '-' }}</td>
                    <td style="color:var(--text-muted)">{{ $s['start_date'] ? \Carbon\Carbon::parse($s['start_date'])->format('d M Y') : '-' }}</td>
                    <td style="color:var(--text-muted)">{{ $s['end_date'] ? \Carbon\Carbon::parse($s['end_date'])->format('d M Y') : '-' }}</td>
                    <td><span class="badge {{ $sc }}">{{ ucfirst($s['status']) }}</span></td>
                    <td>
                        <a href="{{ route('subscriptions.show', $s['id']) }}" class="btn btn-ghost btn-sm">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <span class="icon"><x-icon name="users" size="18" /></span>
                            <p>Belum ada subscription untuk customer ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
