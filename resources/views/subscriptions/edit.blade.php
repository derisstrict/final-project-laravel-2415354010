@extends('layouts.app')

@section('title', 'Edit Subscription')

@section('content')
<div class="page-header">
    <div>
        <h1><span class="icon"><x-icon name="pencil" size="28" /></span> Edit Subscription</h1>
        <p>Perbarui data langganan</p>
    </div>
    <a href="{{ route('subscriptions.show', $subscription['id']) }}" class="btn btn-ghost">← Kembali</a>
</div>

<div class="card" style="max-width:620px">
    <div class="card-header">
        <span class="card-title">Edit Subscription #{{ $subscription['id'] }}</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('subscriptions.update', $subscription['id']) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label for="customer_id">Customer <span style="color:var(--danger)">*</span></label>
                <select id="customer_id" name="customer_id" class="form-control {{ $errors->has('customer_id') ? 'is-invalid' : '' }}" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach($customers as $c)
                        <option value="{{ $c['id'] }}" {{ old('customer_id', $subscription['customer_id']) == $c['id'] ? 'selected' : '' }}>
                            {{ $c['name'] }} ({{ $c['customer_id'] }})
                        </option>
                    @endforeach
                </select>
                @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="service_id">Layanan <span style="color:var(--danger)">*</span></label>
                <select id="service_id" name="service_id" class="form-control {{ $errors->has('service_id') ? 'is-invalid' : '' }}" required>
                    <option value="">-- Pilih Service --</option>
                    @foreach($services as $sv)
                        <option value="{{ $sv['id'] }}" {{ old('service_id', $subscription['service_id']) == $sv['id'] ? 'selected' : '' }}>
                            {{ $sv['name'] }} — Rp {{ number_format($sv['price'], 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="start_date">Tanggal Mulai</label>
                    <input id="start_date" type="date" name="start_date" class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}"
                        value="{{ old('start_date', $subscription['start_date'] ? \Carbon\Carbon::parse($subscription['start_date'])->format('Y-m-d') : '') }}">
                    @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="end_date">Tanggal Selesai</label>
                    <input id="end_date" type="date" name="end_date" class="form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}"
                        value="{{ old('end_date', $subscription['end_date'] ? \Carbon\Carbon::parse($subscription['end_date'])->format('Y-m-d') : '') }}">
                    @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status <span style="color:var(--danger)">*</span></label>
                <select id="status" name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                    <option value="{{ $subscription['status'] }}" selected hidden>
                        {{ ucfirst($subscription['status']) }}
                    </option>
                    @foreach($statuses as $st)
                        @if ($st != $subscription['status'])
                            <option value="{{ $st }}" {{ old('status', $subscription['status']) === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                        @endif
                    @endforeach
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:8px">
                <a href="{{ route('subscriptions.show', $subscription['id']) }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Update Subscription</button>
            </div>
        </form>
    </div>
</div>
@endsection
