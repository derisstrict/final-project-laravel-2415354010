@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="page-header">
    <div>
        <h1><span class="icon"><x-icon name="pencil" size="28" /></span> Edit Customer</h1>
        <p>Perbarui data pelanggan</p>
    </div>
    <a href="{{ route('customers.show', $customer['id']) }}" class="btn btn-ghost">← Kembali</a>
</div>

<div class="card" style="max-width:640px">
    <div class="card-header">
        <span class="card-title">Edit: {{ $customer['name'] }}</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('customers.update', $customer['id']) }}">
            @csrf @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="customer_id">Customer ID <span style="color:var(--danger)">*</span></label>
                    <input id="customer_id" type="text" name="customer_id" class="form-control {{ $errors->has('customer_id') ? 'is-invalid' : '' }}"
                        value="{{ old('customer_id', $customer['customer_id']) }}" required>
                    @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="name">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                    <input id="name" type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        value="{{ old('name', $customer['name']) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email', $customer['email']) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Telepon</label>
                    <input id="phone" type="text" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                        value="{{ old('phone', $customer['phone']) }}">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea id="address" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                    rows="3">{{ old('address', $customer['address']) }}</textarea>
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="1" {{ old('status', $customer['status'] ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status', $customer['status'] ? '1' : '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:8px">
                <a href="{{ route('customers.show', $customer['id']) }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Update Customer</button>
            </div>
        </form>
    </div>
</div>
@endsection
