@extends('layouts.app')

@section('title', 'Edit Service')

@section('content')
<div class="page-header">
    <div>
        <h1><span class="icon"><x-icon name="pencil" size="28" /></span> Edit Service</h1>
        <p>Perbarui data layanan</p>
    </div>
    <a href="{{ route('services.show', $service['id']) }}" class="btn btn-ghost">← Kembali</a>
</div>

<div class="card" style="max-width:580px">
    <div class="card-header">
        <span class="card-title">Edit: {{ $service['name'] }}</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('services.update', $service['id']) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label for="name">Nama Layanan <span style="color:var(--danger)">*</span></label>
                <input id="name" type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    value="{{ old('name', $service['name']) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="price">Harga (Rp) <span style="color:var(--danger)">*</span></label>
                <input id="price" type="number" name="price" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                    value="{{ old('price', $service['price']) }}" min="0" required>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                    rows="4">{{ old('description', $service['description']) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="1" {{ old('status', $service['status'] ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status', $service['status'] ? '1' : '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:8px">
                <a href="{{ route('services.show', $service['id']) }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Update Service</button>
            </div>
        </form>
    </div>
</div>
@endsection
