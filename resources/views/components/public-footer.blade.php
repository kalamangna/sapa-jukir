@props(['id' => null])

<footer class="public-footer" @if($id) id="{{ $id }}" @endif>
    <div class="container footer-inner">
        <div class="footer-copy">&copy; SAPA JUKIR {{ date('Y') }}</div>
        <p>UPTD Terminal dan Perparkiran<br>DINAS PERHUBUNGAN KABUPATEN SINJAI</p>
    </div>
</footer>
