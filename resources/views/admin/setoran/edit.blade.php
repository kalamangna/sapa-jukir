@extends('layouts.admin')

@section('title', 'Edit Setoran')

@section('page-title', 'Edit Setoran')

@section('content')

<div class="container-fluid">

    {{-- ==========================================================
        HEADER
    =========================================================== --}}

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Edit Setoran
            </h4>

            <p class="text-muted mb-0">
                Perbarui data setoran Petugas.
            </p>
        </div>

        <div class="mt-3 mt-md-0">

            <a
                href="{{ route('admin.setoran.index') }}"
                class="btn btn-light border"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>

        </div>

    </div>


    {{-- ==========================================================
        FORM
    =========================================================== --}}

    <form
        action="{{ route('admin.setoran.update', $setoran->id) }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <div class="row g-4">


                    <div class="col-12">
                        <label for="sumber_pemasukan_id" class="form-label fw-semibold">Sumber Pendapatan <span class="text-danger">*</span></label>
                        <select name="sumber_pemasukan_id" id="sumber_pemasukan_id" class="form-select @error('sumber_pemasukan_id') is-invalid @enderror" required>
                            <option value="">Pilih sumber pendapatan</option>
                            @foreach($sumberPemasukans as $sumber)
                                <option value="{{ $sumber->id }}" data-kode="{{ $sumber->kode }}" @selected(old('sumber_pemasukan_id', $setoran->sumber_pemasukan_id) == $sumber->id)>{{ $sumber->nama }}</option>
                            @endforeach
                        </select>
                        @error('sumber_pemasukan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- ==================================================
                        Petugas
                    =================================================== --}}

                    <div class="col-12 col-md-6">

                        <label
                            for="jukir_id"
                            class="form-label fw-semibold"
                        >
                            Petugas
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="jukir_id"
                            id="jukir_id"
                            class="form-select @error('jukir_id') is-invalid @enderror"
                        >

                            <option value="">
                                Pilih petugas
                            </option>

                            @foreach ($jukirs as $jukir)

                                <option
                                    value="{{ $jukir->id }}"
                                    {{ old('jukir_id', $setoran->jukir_id) == $jukir->id ? 'selected' : '' }}
                                >
                                    {{ $jukir->kode_jukir }}
                                    -
                                    {{ $jukir->nama }}
                                </option>

                            @endforeach

                        </select>

                        @error('jukir_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- ==================================================
                        TITIK PARKIR
                    =================================================== --}}

                    <div class="col-12 col-md-6">

                        <label
                            for="titik_parkir_id"
                            class="form-label fw-semibold"
                        >
                            Titik Parkir
                        </label>

                        <select
                            name="titik_parkir_id"
                            id="titik_parkir_id"
                            class="form-select @error('titik_parkir_id') is-invalid @enderror"
                        >

                            <option value="">
                                Pilih titik parkir
                            </option>

                            @foreach ($titikParkirs as $titik)

                                <option
                                    value="{{ $titik->id }}"
                                    {{ old('titik_parkir_id', $setoran->titik_parkir_id) == $titik->id ? 'selected' : '' }}
                                >
                                    {{ $titik->kode_titik }}
                                    -
                                    {{ $titik->nama }}
                                    ({{ $titik->jenisParkir?->nama ?? 'Tanpa kategori' }})
                                </option>

                            @endforeach

                        </select>

                        @error('titik_parkir_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- ==================================================
                        TANGGAL
                    =================================================== --}}

                    <div class="col-12 col-md-4">

                        <label
                            for="tanggal"
                            class="form-label fw-semibold"
                        >
                            Tanggal Setoran
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            id="tanggal"
                            class="form-control @error('tanggal') is-invalid @enderror"
                            value="{{ old('tanggal', $setoran->tanggal?->format('Y-m-d')) }}"
                            required
                        >

                        @error('tanggal')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    @php
                        $ticketLines = old('karcis_lines', $ticketLines);
                        if (empty($ticketLines)) {
                            $ticketLines = [['allocation_id' => '', 'nomor' => '']];
                        }
                        $ticketRequired = $setoran->karcisUsages->isNotEmpty();
                    @endphp
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                            <label class="form-label fw-semibold mb-0">Seri Karcis Terpakai @if($ticketRequired)<span class="text-danger">*</span>@endif</label>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-karcis-line"><i class="bi bi-plus-lg me-1"></i>Tambah jenis karcis</button>
                        </div>
                        <div id="karcis-lines">
                            @foreach($ticketLines as $index => $line)
                                <div class="karcis-line border rounded p-3 mb-3">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Seri penyerahan</label>
                                            <select name="karcis_lines[{{ $index }}][allocation_id]" class="form-select karcis-allocation" @required($ticketRequired)>
                                                <option value="">Pilih seri karcis</option>
                                                @foreach($karcisAllocations as $allocation)
                                                    <option value="{{ $allocation->id }}" data-source="{{ $allocation->sumber_pemasukan_id }}" data-jukir="{{ $allocation->jukir_id ?? '' }}" data-start="{{ $allocation->nomor_awal }}" data-end="{{ $allocation->nomor_akhir }}" data-value="{{ $allocation->nilai_per_karcis }}" @selected(($line['allocation_id'] ?? '') == $allocation->id)>
                                                        {{ $allocation->sumberPemasukan->nama }} — {{ $allocation->jenis_karcis }} — {{ $allocation->seri_prefix }}{{ str_pad($allocation->nomor_awal, $allocation->lebar_nomor, '0', STR_PAD_LEFT) }}–{{ $allocation->seri_prefix }}{{ str_pad($allocation->nomor_akhir, $allocation->lebar_nomor, '0', STR_PAD_LEFT) }} (sisa {{ $allocation->jumlah_tersedia }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Nomor terpakai</label>
                                            <textarea name="karcis_lines[{{ $index }}][nomor]" rows="2" class="form-control karcis-nomor" placeholder="Contoh: 0001-0020, 0022" @required($ticketRequired)>{{ $line['nomor'] ?? '' }}</textarea>
                                            <div class="form-text">Angka saja; awalan seri ditambahkan otomatis. Masukkan rentang atau nomor dipisahkan koma/baris baru.</div>
                                            <div class="small fw-semibold text-primary mt-2 karcis-summary" aria-live="polite"></div>
                                        </div>
                                        <div class="col-12 text-end"><button type="button" class="btn btn-sm btn-outline-danger remove-karcis-line" @if($loop->first) hidden @endif>Hapus baris</button></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('karcis_lines')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>


                    <div class="col-12 col-md-4">
                        <label for="jumlah_motor" class="form-label fw-semibold">Jumlah Motor</label>
                        <input type="number" name="jumlah_motor" id="jumlah_motor" class="form-control @error('jumlah_motor') is-invalid @enderror" value="{{ old('jumlah_motor', $setoran->jumlah_motor) }}" min="0" step="1">
                        @error('jumlah_motor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="jumlah_mobil_kecil" class="form-label fw-semibold">Jumlah Mobil Kecil</label>
                        <input type="number" name="jumlah_mobil_kecil" id="jumlah_mobil_kecil" class="form-control @error('jumlah_mobil_kecil') is-invalid @enderror" value="{{ old('jumlah_mobil_kecil', $setoran->jumlah_mobil_kecil ?? $setoran->jumlah_mobil) }}" min="0" step="1">
                        @error('jumlah_mobil_kecil')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="jumlah_mobil_besar" class="form-label fw-semibold">Jumlah Mobil Besar</label>
                        <input type="number" name="jumlah_mobil_besar" id="jumlah_mobil_besar" class="form-control @error('jumlah_mobil_besar') is-invalid @enderror" value="{{ old('jumlah_mobil_besar', $setoran->jumlah_mobil_besar) }}" min="0" step="1">
                        @error('jumlah_mobil_besar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>


                    {{-- ==================================================
                        PENDAPATAN BRUTO
                    =================================================== --}}

                    <div class="col-12 col-md-4">

                        <label
                            for="pendapatan_bruto"
                            class="form-label fw-semibold"
                        >
                            Pendapatan Bruto
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="text"
                                id="pendapatan_bruto_display"
                                class="form-control @error('pendapatan_bruto') is-invalid @enderror"
                                value="{{ number_format((float) old('pendapatan_bruto', $setoran->pendapatan_bruto), 0, ',', '.') }}"
                                inputmode="numeric"
                                placeholder="0"
                                autocomplete="off"
                                required
                            >
                            <input type="hidden" name="pendapatan_bruto" id="pendapatan_bruto" value="{{ old('pendapatan_bruto', $setoran->pendapatan_bruto) }}">

                        </div>

                        @error('pendapatan_bruto')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- ==================================================
                        JUMLAH SETORAN
                    =================================================== --}}

                    <div class="col-12 col-md-4">

                        <label
                            for="jumlah_setoran"
                            class="form-label fw-semibold"
                        >
                            Jumlah Setoran
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="text"
                                id="jumlah_setoran_display"
                                class="form-control @error('jumlah_setoran') is-invalid @enderror"
                                value="{{ number_format((float) old('jumlah_setoran', $setoran->jumlah_setoran), 0, ',', '.') }}"
                                inputmode="numeric"
                                placeholder="0"
                                autocomplete="off"
                                required
                            >
                            <input type="hidden" name="jumlah_setoran" id="jumlah_setoran" value="{{ old('jumlah_setoran', $setoran->jumlah_setoran) }}">

                        </div>

                        @error('jumlah_setoran')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- ==================================================
                        SELISIH
                    =================================================== --}}

                    <div class="col-12 col-md-6">

                        <label
                            for="selisih"
                            class="form-label fw-semibold"
                        >
                            Selisih
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="text"
                                id="selisih"
                                class="form-control bg-light"
                                value="Rp 0"
                                readonly
                            >

                        </div>

                        <div class="form-text">
                            Selisih dihitung otomatis dari pendapatan bruto dikurangi jumlah setoran.
                        </div>

                    </div>


                    {{-- ==================================================
                        STATUS
                    =================================================== --}}

                    <div class="col-12 col-md-6">

                        <label
                            for="status"
                            class="form-label fw-semibold"
                        >
                            Status
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select @error('status') is-invalid @enderror"
                            required
                        >

                            <option value="">
                                Pilih status
                            </option>

                            <option
                                value="belum_verifikasi"
                                {{ old('status', $setoran->status) === 'belum_verifikasi' ? 'selected' : '' }}
                            >
                                Belum Verifikasi
                            </option>

                            <option
                                value="terverifikasi"
                                {{ old('status', $setoran->status) === 'terverifikasi' ? 'selected' : '' }}
                            >
                                Terverifikasi
                            </option>

                            <option
                                value="ditolak"
                                {{ old('status', $setoran->status) === 'ditolak' ? 'selected' : '' }}
                            >
                                Ditolak
                            </option>

                        </select>

                        @error('status')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- ==================================================
                        KETERANGAN
                    =================================================== --}}

                    <div class="col-12">

                        <label
                            for="keterangan"
                            class="form-label fw-semibold"
                        >
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            id="keterangan"
                            rows="4"
                            class="form-control @error('keterangan') is-invalid @enderror"
                            placeholder="Keterangan tambahan setoran"
                        >{{ old('keterangan', $setoran->keterangan) }}</textarea>

                        @error('keterangan')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- ==========================================================
                FOOTER
            =========================================================== --}}

            <div class="card-footer bg-white border-top p-4">

                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('admin.setoran.index') }}"
                        class="btn btn-light border"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-save me-1"></i>

                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


{{-- ==========================================================
    HITUNG SELISIH OTOMATIS
=========================================================== --}}

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const sumberPendapatan = document.getElementById('sumber_pemasukan_id');
    const jukir = document.getElementById('jukir_id');
    const karcisLines = document.getElementById('karcis-lines');
    const ticketRequired = @json($ticketRequired);

    const pendapatanBrutoDisplay =
        document.getElementById('pendapatan_bruto_display');

    const pendapatanBruto =
        document.getElementById('pendapatan_bruto');

    const jumlahSetoranDisplay =
        document.getElementById('jumlah_setoran_display');

    const jumlahSetoran =
        document.getElementById('jumlah_setoran');

    const selisih =
        document.getElementById('selisih');


    function formatRupiah(angka) {

        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);

    }

    function syncNominal(displayInput, hiddenInput) {
        const digits = displayInput.value.replace(/\D/g, '');
        hiddenInput.value = digits;
        displayInput.value = digits ? Number(digits).toLocaleString('id-ID') : '';
    }

    function updateTicketLines() {
        const sourceId = sumberPendapatan.value;
        const jukirId = jukir.value;
        let totalGross = 0;
        let hasInvalidLine = false;
        const allNumbers = new Set();

        karcisLines.querySelectorAll('.karcis-line').forEach(line => {
            const select = line.querySelector('.karcis-allocation');
            const nomorInput = line.querySelector('.karcis-nomor');
            const summary = line.querySelector('.karcis-summary');

            Array.from(select.options).slice(1).forEach(option => {
                const matchesSource = !sourceId || option.dataset.source === sourceId;
                const matchesJukir = !option.dataset.jukir || !jukirId || option.dataset.jukir === jukirId;
                option.hidden = !(matchesSource && matchesJukir);
            });
            if (select.selectedOptions[0]?.hidden) select.value = '';

            const selected = select.selectedOptions[0];
            const input = nomorInput.value.trim();
            if (!selected || !input) {
                summary.textContent = '';
                return;
            }

            let count = 0;
            const numbers = new Set();
            for (const part of input.split(/[,\r\n]+/).filter(Boolean)) {
                const match = part.trim().match(/^(\d+)(?:\s*-\s*(\d+))?$/);
                if (!match) {
                    summary.textContent = 'Format nomor belum valid; gunakan nomor atau rentang angka.';
                    hasInvalidLine = true;
                    return;
                }
                const start = Number(match[1]);
                const end = Number(match[2] || match[1]);
                if (start > end || start < Number(selected.dataset.start) || end > Number(selected.dataset.end) || end - start + 1 > 2000) {
                    summary.textContent = 'Nomor berada di luar rentang penyerahan atau melebihi batas input.';
                    hasInvalidLine = true;
                    return;
                }
                for (let number = start; number <= end; number++) {
                    const serialKey = `${selected.value}:${number}`;
                    if (numbers.has(number) || allNumbers.has(serialKey)) {
                        summary.textContent = 'Ada nomor karcis yang tercantum lebih dari satu kali.';
                        hasInvalidLine = true;
                        return;
                    }
                    numbers.add(number);
                    allNumbers.add(serialKey);
                    count++;
                }
            }

            const gross = count * Number(selected.dataset.value);
            totalGross += gross;
            summary.textContent = `${count} karcis × Rp ${Number(selected.dataset.value).toLocaleString('id-ID')} = Rp ${gross.toLocaleString('id-ID')}`;
        });

        if (!hasInvalidLine && totalGross > 0) {
            pendapatanBruto.value = totalGross;
            pendapatanBrutoDisplay.value = totalGross.toLocaleString('id-ID');
            hitungSelisih();
        }
    }

    let lineIndex = Array.from(karcisLines.querySelectorAll('.karcis-allocation'))
        .reduce((max, select) => Math.max(max, Number(select.name.match(/\[(\d+)\]/)?.[1] || 0)), -1) + 1;
    document.getElementById('add-karcis-line').addEventListener('click', () => {
        const line = karcisLines.querySelector('.karcis-line').cloneNode(true);
        line.querySelector('.karcis-allocation').name = `karcis_lines[${lineIndex}][allocation_id]`;
        line.querySelector('.karcis-allocation').value = '';
        line.querySelector('.karcis-allocation').required = ticketRequired;
        line.querySelector('.karcis-nomor').name = `karcis_lines[${lineIndex}][nomor]`;
        line.querySelector('.karcis-nomor').value = '';
        line.querySelector('.karcis-nomor').required = ticketRequired;
        line.querySelector('.karcis-summary').textContent = '';
        line.querySelector('.remove-karcis-line').hidden = false;
        karcisLines.appendChild(line);
        lineIndex++;
        updateTicketLines();
    });

    karcisLines.addEventListener('click', event => {
        if (event.target.closest('.remove-karcis-line')) {
            event.target.closest('.karcis-line').remove();
            updateTicketLines();
        }
    });
    karcisLines.addEventListener('input', event => {
        if (event.target.matches('.karcis-nomor')) updateTicketLines();
    });
    karcisLines.addEventListener('change', event => {
        if (event.target.matches('.karcis-allocation')) updateTicketLines();
    });
    [sumberPendapatan, jukir].forEach(input => input.addEventListener('change', updateTicketLines));

    document.querySelector('form').addEventListener('submit', () => {
        karcisLines.querySelectorAll('.karcis-line').forEach(line => {
            const allocation = line.querySelector('.karcis-allocation').value;
            const nomor = line.querySelector('.karcis-nomor').value.trim();
            if (!allocation && !nomor && (!ticketRequired || karcisLines.querySelectorAll('.karcis-line').length > 1)) {
                line.remove();
            }
        });
    });
    updateTicketLines();


    function hitungSelisih() {

        const bruto =
            parseFloat(pendapatanBruto.value) || 0;

        const setoran =
            parseFloat(jumlahSetoran.value) || 0;

        const hasil =
            bruto - setoran;

        selisih.value =
            formatRupiah(hasil);

    }


    pendapatanBrutoDisplay.addEventListener(
        'input',
        function () {
            syncNominal(pendapatanBrutoDisplay, pendapatanBruto);
            hitungSelisih();
            updateTicketSummary();
        }
    );

    jumlahSetoranDisplay.addEventListener(
        'input',
        function () {
            syncNominal(jumlahSetoranDisplay, jumlahSetoran);
            hitungSelisih();
        }
    );


    hitungSelisih();

});

</script>

@endpush

@endsection