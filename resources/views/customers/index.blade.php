@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="page-header">
    <div>
        <h1><span class="icon"><x-icon name="users" size="28" /></span> Customers</h1>
        <p>Kelola data pelanggan Anda</p>
    </div>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        + Tambah Customer
    </a>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route('customers.index') }}" style="display:flex;gap:10px;align-items:center;width:100%">
        <label style="margin:0;white-space:nowrap">Filter Status:</label>
        <select name="status" class="form-control" style="width:auto" onchange="this.form.submit()">
            <option value="">Semua</option>
            <option value="active"   {{ $status === 'active'   ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        @if($status)
            <a href="{{ route('customers.index') }}" class="btn btn-ghost btn-sm">Reset</a>
        @endif
        <span style="margin-left:auto;color:var(--text-muted);font-size:13px">
            {{ count($customers) }} customer ditemukan
        </span>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $i => $c)
                <tr>
                    <td style="color:var(--text-muted)">{{ $i + 1 }}</td>
                    <td><code style="background:var(--surface2);padding:2px 8px;border-radius:4px;font-size:12px">{{ $c['customer_id'] }}</code></td>
                    <td style="font-weight:500">{{ $c['name'] }}</td>
                    <td style="color:var(--text-muted)">{{ $c['email'] ?? '-' }}</td>
                    <td style="color:var(--text-muted)">{{ $c['phone'] ?? '-' }}</td>
                    <td>
                        @if($c['status'])
                            <span class="badge badge-success">● Aktif</span>
                        @else
                            <span class="badge badge-danger">● Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('customers.show', $c['id']) }}" class="btn btn-secondary btn-sm">Detail</a>
                            <a href="{{ route('customers.edit', $c['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                            @if($c['status'])
                                <form method="POST" action="{{ route('customers.deactivate', $c['id']) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-ghost btn-sm" onclick="return confirm('Nonaktifkan customer ini?')">Nonaktifkan</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('customers.activate', $c['id']) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-ghost btn-sm">Aktifkan</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('customers.destroy', $c['id']) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus customer {{ $c['name'] }}? Pastikan tidak ada subscription terkait.')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <span class="icon"><x-icon name="users" size="28" /></span>
                            <p>Belum ada customer. <a href="{{ route('customers.create') }}" style="color:var(--accent)">Tambahkan sekarang</a></p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
