@php($isSelf = $user && $user->is(auth()->user()))
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label fw-semibold">Nama</label>
                <input id="name" name="name" value="{{ old('name', $user?->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input id="username" name="username" value="{{ old('username', $user?->username) }}" class="form-control @error('username') is-invalid @enderror" autocomplete="off" required>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="role" class="form-label fw-semibold">Role</label>
                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" @disabled($isSelf) required>
                    @foreach(['admin','operator','pimpinan'] as $role)
                        <option value="{{ $role }}" @selected(old('role', $user?->role ?? 'operator') === $role)>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @if($isSelf)<div class="form-text">Role akun sendiri tidak bisa diubah.</div>@endif
            </div>
            <div class="col-md-4">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" @disabled($isSelf) required>
                    <option value="aktif" @selected(old('status', $user?->status ?? 'aktif') === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected(old('status', $user?->status) === 'nonaktif')>Tidak aktif</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @if($isSelf)<div class="form-text">Status akun sendiri tidak bisa diubah.</div>@endif
            </div>
            <div class="col-md-4">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" {{ $user ? '' : 'required' }}>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <div class="form-text">{{ $user ? 'Kosongkan jika password tidak diganti.' : 'Minimal 8 karakter dengan kombinasi huruf dan angka.' }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" {{ $user ? '' : 'required' }}>
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-2">
    <button class="btn btn-success"><i class="bi bi-check-lg me-1"></i>{{ $user ? 'Simpan Perubahan' : 'Simpan Pengguna' }}</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Batal</a>
</div>
