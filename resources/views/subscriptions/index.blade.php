@extends('layouts.app')

@section('title', 'Subscriptions')

@section('content')
<div class="page-header">
    <div>
        <h1><span class="icon"><x-icon name="clipboard" size="28" /></span> Subscriptions</h1>
        <p>Kelola langganan pelanggan</p>
    </div>
    <a href="{{ route('subscriptions.create') }}" class="btn btn-primary">+ Tambah Subscription</a>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route('subscriptions.index') }}" style="display:flex;gap:10px;align-items:center;width:100%;flex-wrap:wrap">
        <label style="margin:0;white-space:nowrap">Status:</label>
        <select name="status" class="form-control" style="width:auto">
            <option value="">Semua Status</option>
            @foreach(['active','inactive','trial','isolir','dismantle'] as $st)
                <option value="{{ $st }}" {{ $status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
            @endforeach
        </select>

        <label style="margin:0;white-space:nowrap">Customer:</label>
        <select name="customer_id" class="form-control" style="width:auto">
            <option value="">Semua Customer</option>
            @foreach($customers as $c)
                <option value="{{ $c['id'] }}" {{ $customerId == $c['id'] ? 'selected' : '' }}>{{ $c['name'] }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        @if($status || $customerId)
            <a href="{{ route('subscriptions.index') }}" class="btn btn-ghost btn-sm">Reset</a>
        @endif
        <span style="margin-left:auto;color:var(--text-muted);font-size:13px">
            {{ count($subscriptions) }} subscription ditemukan
        </span>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Layanan</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $statusColors = [
                    'active'   => 'badge-success',
                    'inactive' => 'badge-danger',
                    'trial'    => 'badge-info',
                    'isolir'   => 'badge-warning',
                    'dismantle'=> 'badge-secondary',
                ];
                @endphp
                @forelse($subscriptions as $i => $s)
                @php $sc = $statusColors[$s['status']] ?? 'badge-secondary'; @endphp
                <tr>
                    <td style="color:var(--text-muted)">{{ $i + 1 }}</td>
                    <td>
                        <a href="{{ route('customers.show', $s['customer']['id'] ?? 0) }}" style="color:var(--text);text-decoration:none;font-weight:500" class="hover-link">
                            {{ $s['customer']['name'] ?? '-' }}
                        </a>
                    </td>
                    <td style="color:var(--accent-light)">{{ $s['service']['name'] ?? '-' }}</td>
                    <td style="color:var(--text-muted)">{{ $s['start_date'] ? \Carbon\Carbon::parse($s['start_date'])->format('d M Y') : '-' }}</td>
                    <td style="color:var(--text-muted)">{{ $s['end_date'] ? \Carbon\Carbon::parse($s['end_date'])->format('d M Y') : '-' }}</td>
                    <td><span class="badge {{ $sc }}">{{ ucfirst($s['status']) }}</span></td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('subscriptions.show', $s['id']) }}" class="btn btn-secondary btn-sm">Detail</a>
                            @if($s['status'] != 'dismantle')   
                                <a href="{{ route('subscriptions.edit', $s['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                            @endif
                            <form method="POST" action="{{ route('subscriptions.destroy', $s['id']) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus subscription ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <span class="icon"><x-icon name="clipboard" size="28" /></span>
                            <p>Belum ada subscription. <a href="{{ route('subscriptions.create') }}" style="color:var(--accent)">Tambahkan sekarang</a></p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('styles')
<style>
    .hover-link:hover { color: var(--accent-light) !important; }
</style>
@endpush
@endsection
