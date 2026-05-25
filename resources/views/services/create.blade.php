@extends('layouts.app')

@section('title', 'Tambah Service')

@section('content')
<div class="page-header">
    <div>
        <h1><span class="icon"><x-icon name="plus" size="28" /></span> Tambah Service</h1>
        <p>Tambahkan layanan baru</p>
    </div>
    <a href="{{ route('services.index') }}" class="btn btn-ghost">← Kembali</a>
</div>

<div class="card" style="max-width:580px">
    <div class="card-header">
        <span class="card-title">Formulir Service</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('services.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nama Layanan <span style="color:var(--danger)">*</span></label>
                <input id="name" type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    value="{{ old('name') }}" placeholder="Misal: Paket Internet 10Mbps" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="price">Harga (Rp) <span style="color:var(--danger)">*</span></label>
                <input id="price" type="number" name="price" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                    value="{{ old('price', 0) }}" min="0" placeholder="0" required>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                    rows="4" placeholder="Deskripsi layanan...">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="1" selected>Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:8px">
                <a href="{{ route('services.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Service</button>
            </div>
        </form>
    </div>
</div>
@endsection
