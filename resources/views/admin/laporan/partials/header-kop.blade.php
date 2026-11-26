<style>
    .report-kop {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        text-align: left;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 3px solid #111827;
    }

    .report-kop__badge {
        width: 62px;
        height: 62px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-radius: 50%;
        box-shadow: 0 0 0 2px #111827;
        background: #fff;
        flex-shrink: 0;
    }

    .report-kop__badge img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .report-kop__meta {
        text-align: center;
    }

    .report-kop__title {
        margin: 0;
        font-size: 15px;
        line-height: 1.2;
        font-weight: 700;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }

    .report-kop__unit {
        margin: 3px 0 0;
        font-size: 12px;
        line-height: 1.2;
        font-weight: 700;
        text-transform: uppercase;
    }

    .report-kop__agency {
        margin: 2px 0 0;
        font-size: 10px;
        line-height: 1.2;
        font-weight: 600;
        text-transform: uppercase;
        color: #1f2937;
    }
</style>

<div class="report-kop">
    <div class="report-kop__badge" aria-hidden="true">
        <img src="{{ asset('images/logo-sinjai-kop.svg') }}" alt="Logo Kabupaten Sinjai" />
    </div>
    <div class="report-kop__meta">
        <div class="report-kop__title">PEMERINTAH KABUPATEN SINJAI</div>
        <div class="report-kop__unit">UPTD TERMINAL DAN PERPARKIRAN</div>
        <div class="report-kop__agency">DINAS PERHUBUNGAN KABUPATEN SINJAI</div>
    </div>
</div>
