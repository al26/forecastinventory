<ul class="nav nav-tabs mt-1" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="mva-tab" data-toggle="tab" href="#mva" role="tab" aria-controls="mva" aria-selected="true">Moving Average</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="hwm-tab" data-toggle="tab" href="#hwm" role="tab" aria-controls="hwm" aria-selected="false">Holt Winter Multiplicative</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="comparison-tab" data-toggle="tab" href="#comparison" role="tab" aria-controls="comparison" aria-selected="false">Hasil Perbandingan Akhir</a>
    </li>
</ul>
<div class="tab-content pl-3 p-1" id="myTabContent">
    <div class="tab-pane fade show active" id="mva" role="tabpanel" aria-labelledby="mva-tab">
        <h4 class="px-3 mt-3 mb-4">Tabel Perhitungan Akurasi Metode Moving Average</h4>
        @include('forecast::partials.ma_accuracy')
    </div>
    <div class="tab-pane fade" id="hwm" role="tabpanel" aria-labelledby="hwm-tab">
        <h4 class="px-3 mt-3 mb-4">Tabel Perhitungan Akurasi Metode Hot Winter Multiplicative</h4>
        @include('forecast::partials.hwm_accuracy')
    </div>
    <div class="tab-pane fade" id="comparison" role="tabpanel" aria-labelledby="comparison-tab">
        <h4 class="px-3 mt-3 mb-4">Tabel Perbandingan Perhitungan Akurasi</h4>
        @include('forecast::partials.comparison')
    </div>
</div>