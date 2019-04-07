<div class="col-12 table-responsive">
    <table id="comparison-table" class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Metode</th>
                <th scope="col">MAD</th>
                <th scope="col">MSE</th>
                <th scope="col">MAPE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($calc as $method => $item)
                @php
                    if ($loop->first) {
                        $min['mad'] = $item->mad;
                        $min['mse'] = $item->mse;
                        $min['mape'] = $item->mape;
                    } else {
                        $min['mad'] = min($min['mad'], $item->mad);
                        $min['mse'] = min($min['mse'], $item->mse);
                        $min['mape'] = min($min['mape'], $item->mape);
                    }
                @endphp
                <tr>
                    <td>{{$method === 'mva' ? ucwords('moving average') : ucwords('hot winter multiplicative')}}</td>
                    <td>{{number_format((float)$item->mad, 2, '.', '')}}</td>
                    <td>{{number_format((float)$item->mse, 2, '.', '')}}</td>
                    <td>{{number_format((float)$item->mape, 2, '.', '')}}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Hasil (nilai minimum)</th>
                <th>{{number_format((float)$min['mad'], 2, '.', '')}}</th>
                <th>{{number_format((float)$min['mse'], 2, '.', '')}}</th>
                <th>{{number_format((float)$min['mape'], 2, '.', '')}}</th>
            </tr>
        </tfoot>
    </table>
</div>