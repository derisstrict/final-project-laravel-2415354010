@extends('layouts.app')

@section('title', 'Tambah Subscription')

@section('content')
<div class="page-header">
    <div>
        <h1><span class="icon"><x-icon name="plus" size="28" /></span> Tambah Subscription</h1>
        <p>Buat langganan baru untuk pelanggan</p>
    </div>
    <a href="{{ route('subscriptions.index') }}" class="btn btn-ghost">← Kembali</a>
</div>

<div class="card" style="max-width:620px">
    <div class="card-header">
        <span class="card-title">Formulir Subscription</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('subscriptions.store') }}">
            @csrf

            <div class="form-group">
                <label for="customer_id">Customer <span style="color:var(--danger)">*</span></label>
                <select id="customer_id" name="customer_id" class="form-control {{ $errors->has('customer_id') ? 'is-invalid' : '' }}" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach($customers as $c)
                        @if($c['status'] == 'active')
                            <option value="{{ $c['id'] }}" {{ old('customer_id') == $c['id'] ? 'selected' : '' }}>
                                {{ $c['name'] }} ({{ $c['customer_id'] }})
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="service_id">Layanan <span style="color:var(--danger)">*</span></label>
                <select id="service_id" name="service_id" class="form-control {{ $errors->has('service_id') ? 'is-invalid' : '' }}" required>
                    <option value="">-- Pilih Service --</option>
                    @foreach($services as $sv)
                        @if($sv['status'] == 'active')
                            <option value="{{ $sv['id'] }}" {{ old('service_id') == $sv['id'] ? 'selected' : '' }}>
                                {{ $sv['name'] }} — Rp {{ number_format($sv['price'], 0, ',', '.') }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="start_date">Tanggal Mulai</label>
                    <input id="start_date" type="date" name="start_date" class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}"
                        value="{{ old('start_date') }}">
                    @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="end_date">Tanggal Selesai</label>
                    <input id="end_date" type="date" name="end_date" class="form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}"
                        value="{{ old('end_date') }}">
                    @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status <span style="color:var(--danger)">*</span></label>
                <select id="status" name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                    {{-- <option value="">-- Pilih Status --</option> --}}
                    @foreach($statuses as $st)
                        <option value="{{ $st }}" {{ old('status') === $st || (!old('status') && $loop->first) ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:8px">
                <a href="{{ route('subscriptions.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Subscription</button>
            </div>
        </form>
    </div>
</div>
@endsection
