@extends('layouts.admin')

@section('title', 'Penempatan Petugas')

@section('page-title', 'Penempatan Petugas')

@section('content')

{{-- ==========================================================
    HEADER
========================================================== --}}

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Penempatan Petugas
        </h4>

        <p class="text-muted mb-0">
            Kelola penempatan Petugas pada setiap titik/objek pendapatan.
        </p>

    </div>


    @unless(auth()->user()->isPimpinan())
    <a
        href="{{ route('admin.penempatan-jukir.create') }}"
        class="btn btn-success"
    >

        <i class="bi bi-plus-circle me-1"></i>

        Tambah Penempatan

    </a>
    @endunless

</div>


{{-- ==========================================================
    DATA PENEMPATAN
========================================================== --}}

<div class="card">

    <div class="card-header bg-white border-bottom py-3">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-person-badge me-2 text-success"></i>

                Daftar Penempatan Petugas

            </h6>


            <span class="badge text-bg-light border">

                {{ $penempatans->total() }}

                Data

            </span>

        </div>

    </div>


    <div class="card-body p-0">

        @if($penempatans->count())

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th
                                class="text-center"
                                style="width:60px;"
                            >
                                #
                            </th>

                            <th>
                                Petugas
                            </th>

                            <th>
                                Titik/Objek Pendapatan
                            </th>

                            <th>
                                Peran
                            </th>

                            <th>
                                Target Per Hari
                            </th>

                            <th>
                                Waktu Kerja
                            </th>

                            <th>
                                Tanggal Mulai
                            </th>

                            <th>
                                Tanggal Selesai
                            </th>

                            <th class="text-center">
                                Status
                            </th>

                            <th
                                class="text-center"
                                style="width:150px;"
                            >
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($penempatans as $penempatan)

                            <tr>

                                {{-- NOMOR --}}

                                <td class="text-center">

                                    {{ $penempatans->firstItem() + $loop->index }}

                                </td>


                                {{-- Petugas --}}

                                <td>

                                    @if($penempatan->jukir)

                                        <div class="fw-semibold">

                                            {{ $penempatan->jukir->nama }}

                                        </div>

                                        <small class="text-muted font-monospace">

                                            {{ $penempatan->jukir->kode_jukir }}

                                        </small>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- TITIK PARKIR --}}

                                <td>

                                    @if($penempatan->titikParkir)

                                        <div class="fw-semibold">

                                            {{ $penempatan->titikParkir->nama }}

                                        </div>

                                        <small class="text-muted font-monospace">

                                            {{ $penempatan->titikParkir->kode_titik }}

                                        </small>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    @if($penempatan->role === 'koordinator')
                                        <span class="badge bg-primary">Koordinator</span>
                                    @elseif($penempatan->role === 'anggota')
                                        <span class="badge bg-secondary">Anggota</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $penempatan->target_per_hari ? 'Rp ' . number_format((float) $penempatan->target_per_hari, 0, ',', '.') : '-' }}
                                </td>

                                <td>
                                    {{ $penempatan->waktu_kerja ?? '-' }}
                                </td>

                                {{-- TANGGAL MULAI --}}

                                <td>

                                    {{ $penempatan->tanggal_mulai?->format('d-m-Y') ?? '-' }}

                                </td>


                                {{-- TANGGAL SELESAI --}}

                                <td>

                                    {{ $penempatan->tanggal_selesai?->format('d-m-Y') ?? '-' }}

                                </td>


                                {{-- STATUS --}}

                                <td class="text-center">

                                    @if($penempatan->status === 'aktif')

                                        <span class="badge bg-success">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Aktif

                                        </span>

                                    @elseif($penempatan->status === 'selesai')

                                        <span class="badge bg-secondary">

                                            <i class="bi bi-check2-all me-1"></i>

                                            Selesai

                                        </span>

                                    @elseif($penempatan->status === 'dibatalkan')

                                        <span class="badge bg-danger">

                                            <i class="bi bi-x-circle me-1"></i>

                                            Dibatalkan

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            -

                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}

                                <td class="text-center">

                                    <div class="d-flex justify-content-center gap-1">

                                        {{-- DETAIL --}}

                                        <a
                                            href="{{ route('admin.penempatan-jukir.show', $penempatan) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Detail"
                                        >

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        @unless(auth()->user()->isPimpinan())
                                        {{-- EDIT --}}

                                        <a
                                            href="{{ route('admin.penempatan-jukir.edit', $penempatan) }}"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Edit"
                                        >

                                            <i class="bi bi-pencil-square"></i>

                                        </a>


                                        {{-- HAPUS --}}

                                        <form
                                            action="{{ route('admin.penempatan-jukir.destroy', $penempatan) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus penempatan ini?');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Hapus"
                                            >

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>
                                        @endunless

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- EMPTY STATE --}}

            <div class="text-center py-5">

                <div
                    class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:80px;height:80px;"
                >

                    <i
                        class="bi bi-person-badge"
                        style="font-size:36px;"
                    ></i>

                </div>


                <h5 class="fw-bold mb-2">

                    Belum Ada Penempatan Petugas

                </h5>


                <p class="text-muted mb-3">

                    Belum ada data penempatan Petugas.

                </p>


                @unless(auth()->user()->isPimpinan())
                <a
                    href="{{ route('admin.penempatan-jukir.create') }}"
                    class="btn btn-success"
                >

                    <i class="bi bi-plus-circle me-1"></i>

                    Tambah Penempatan

                </a>
                @endunless

            </div>

        @endif

    </div>


    {{-- ======================================================
        PAGINATION
    ======================================================= --}}

    @if($penempatans->hasPages())

        <div class="card-footer bg-white border-top">

            {{ $penempatans->links() }}

        </div>

    @endif

</div>

@endsection